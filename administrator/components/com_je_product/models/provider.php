<?php
/**
 * @version		$Id: provider.php 20228 2011-01-10 00:52:54Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * provider model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @since		1.6
 */
class JE_ProductModelProvider extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_CARMAN_INFO';

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	boolean	True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canDelete($record)
	{
		$user = JFactory::getUser();

		if (!empty($record->catid)) {
			return $user->authorise('core.delete', 'com_je_product.category.'.(int) $record->catid);
		}
		else {
			return parent::canDelete($record);
		}
	}

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	boolean	True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		// Check against the category.
		if (!empty($record->catid)) {
			return $user->authorise('core.edit.state', 'com_je_product.category.'.(int) $record->catid);
		}
		// Default to component settings if category not known.
		else {
			return parent::canEditState($record);
		}
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Provider', $prefix = 'JE_ProductTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_je_product.provider', 'provider', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		// Determine correct permissions to check.
		if ($this->getState('provider.id')) {
			// Existing record. Can only edit in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.edit');
		} else {
			// New record. Can only create in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.create');
		}

		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data)) {
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('publish_up', 'disabled', 'true');
			$form->setFieldAttribute('publish_down', 'disabled', 'true');
			$form->setFieldAttribute('state', 'disabled', 'true');
			$form->setFieldAttribute('sticky', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('publish_up', 'filter', 'unset');
			$form->setFieldAttribute('publish_down', 'filter', 'unset');
			$form->setFieldAttribute('state', 'filter', 'unset');
			$form->setFieldAttribute('sticky', 'filter', 'unset');
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_je_product.edit.provider.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}
		
		if (is_object($data))
		{
			$data->hidden_image = base64_encode($data->images);
		}
		else
		{
			$data['hidden_image'] = base64_encode($data['images']);
		}
		
		return $data;
	}

	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param	object	A record object.
	 * @return	array	An array of conditions to add to add to ordering queries.
	 * @since	1.6
	 */
	protected function getReorderConditions($table)
	{
		$condition = array();
		$condition[] = 'type = '. (int) $table->type;
		$condition[] = 'state >= 0';
		return $condition;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see JModelAdmin::save()
	 */
	public function save($data)
	{
		$save = parent::save($data);
		
		if(!$save)
			return false;
		
		$db = JFactory::getDbo();
		
		$providerId = ($data['id']) ? $data['id'] : $db->insertid();
		
		$this->saveAddresses($providerId, $data);
		
		//delete all recs in #__je_provider_category that provider_id = last id
		$query = "DELETE FROM #__je_provider_category WHERE provider_id = '$providerId'";
		$db->setQuery($query);
		
		$db->query();
		
		if($db->getErrorMsg())
		{
			die('Query: '.$query.'. Error: ' . $db->getErrorMsg());
		}
		
		$post 	= JRequest::get('post');
		
		//for each category, insert
		foreach ($post['jform']['customcategory'] as $catId)
		{				
			$query = "INSERT INTO #__je_provider_category SET provider_id = '$providerId', category_id = '$catId';";
			$db->setQuery($query);
		
			$db->query();
				
			if($db->getErrorMsg())
			{
				die('Query: '.$query.'. Error: ' . $db->getErrorMsg());
			}
		}
		
		$images = $this->uploadImages('images', $id, $data['del_image'], base64_decode($data['hidden_image']));
		
		$data['images'] = $images;
		
		// update content
		$content = $this->copyFilesOnSave($data['description'], $providerId);
			
		if ($content)
			$data['description'] = $content;
			
		$data['id'] = $id;
		
		$saveResult = parent::save($data);
		
		return $saveResult;
	}
	
	/**
	 * Function to copy image in content from temp to folder on host
	 * 
	 * @param string $content Content
	 * @param int $itemId Item ID
	 * @return Content converted
	 */
	private function copyFilesOnSave($content = '', $itemId = 0)
	{
		if(!$content || !$itemId)
			return false;
	
		$date = date('Y') . DS . date('m') . DS . date('d');
	
		$dest = JPATH_ROOT . DS . 'images' . DS . 'provider-content' . DS . $date . DS . $itemId . DS;
		@mkdir($dest, 0777, true);
	
		$doc=new DOMDocument();
	
		$doc->loadHTML($content);
	
		// just to make xpath more simple
		$xml=simplexml_import_dom($doc);
	
		$images=$xml->xpath('//img');
	
		$tmpSearch = array();
		$tmpReplace = array();
	
		foreach ($images as $img)
		{
			// Explode src to get file name
			$imgSrc = explode('/', $img['src']);
				
			// Search & Replace
			$tmpSearch[] = $img['src'];
			$tmpReplace[] = 'images/provider-content/' . str_replace(DS, '/', $date) . '/' . $itemId . '/' . end($imgSrc);
	
			$src = str_replace('/', DS, JPATH_ROOT.'/'.$img['src']);
	
			if($imgSrc[0] == 'tmp')
				JFile::copy($src, $dest.end($imgSrc));
		}
	
		$content = str_replace($tmpSearch, $tmpReplace, $content);
	
		return $content;
	}
	
	/**
	 * Function to save provider addresses
	 * 
	 * @param int $providerId Provider ID
	 * @param array $data Data (form post)
	 * @return boolean
	 */
	private function saveAddresses($providerId, $data = array())
	{
		if (empty($data['province_id']) || empty($data['address']))
			return 1;
		
		$provinceIds 	= $data['province_id'];
		$addresses 		= $data['address'];
		$phone 			= $data['phone'];
		$hotline 		= $data['hotline'];
		$nick_yahoo_support = $data['nick_yahoo_support'];
		$nick_skype_support = $data['nick_skype_support'];
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$created = date('Y-m-d H:i:s');
		
		$table = '#__je_provider_addresses';
		
		// delete all addresses before save
		$query->delete($table)->where('provider_id = ' . $providerId);
		
		$db->setQuery($query);
		$db->query();
		
		if ($db->getErrorMsg())
			die ($db->getErrorMsg());
		
		foreach ($provinceIds as $key => $provinceId)
		{
			if (!empty($provinceId))
			{
				if (!empty($addresses[$key]))
				{
					$val = array();
					
					$val['provider_id'] 	= $providerId;
					$val['province_id'] 	= $provinceId;
					$val['address'] 		= $db->quote($addresses[$key]);
					$val['phone'] 			= $db->quote($phone[$key]);
					$val['hotline'] 		= $db->quote($hotline[$key]);
					$val['nick_yahoo_support'] = $db->quote($nick_yahoo_support[$key]);
					$val['nick_skype_support'] = $db->quote($nick_skype_support[$key]);
					$val['state'] 			= 1;
					$val['created'] 		= $db->quote($created);
					
					$columns = implode(',', array_keys($val));
					$values = implode(',', $val);
					
					$query->clear()
							->insert($table)
							->columns($columns)
							->values($values)
					;
					
					$db->setQuery($query);
					$db->query();
					
					if ($db->getErrorMsg())
						die ($db->getErrorMsg());
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Function to upload images
	 * 
	 * @param string $field Field name
	 * @param int $itemId Item ID
	 * @param boolean $delImage Delete image or not
	 * @param string $oldImg Old image name
	 * @return image name
	 */
	private function uploadImages($field = 'images', $itemId = 0, $delImage = 0, $oldImg = '')
	{
		$storeImageFolder = 'providers';
		
		$jFileInput = new JInput($_FILES);
		$file = $jFileInput->get('jform', array(), 'array');
	
		// If there is no uploaded file, we have a problem...
		if (!is_array($file)) {
			//			JError::raiseWarning('', 'No file was selected.');
			return '';
		}
	
		// Build the paths for our file to move to the components 'upload' directory
		$fileName = $file['name'][$field];
		$tmp_src    = $file['tmp_name'][$field];
	
		$image = '';
	
		// if delete old image checked or upload new file
		if ($delImage || $fileName)
		{
			$item = $this->getItem();
				
			$oldImage = JPATH_ROOT . DS . str_replace('/', DS, $item->$field);
				
			// unlink file
			@unlink($oldImage);
				
			$image = '';
		}
		else
			$image = $oldImg;
	
		$date = date('Y') . DS . date('m') . DS . date('d');
	
		$path = ($field == 'images') ? 'thumbs' : 'featured';
	
		$dest = JPATH_ROOT . DS . 'images' . DS . $storeImageFolder . DS . $path . DS . $date . DS . $itemId . DS;
	
		// Make directory
		@mkdir($dest, 0777, true);
	
		if (isset($fileName) && $fileName) {
				
			$filepath = JPath::clean($dest.$fileName);
	
			/*
				if (JFile::exists($filepath)) {
			JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_FILE_EXISTS'));	// File exists
			}
			*/
	
			// Move uploaded file
			jimport('joomla.filesystem.file');
				
			if (!JFile::upload($tmp_src, $filepath))
			{
				JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_UNABLE_TO_UPLOAD_FILE')); // Error in upload
				return '';
			}
	
			// set value to return
			$image = 'images/'.$storeImageFolder.'/'.$path.'/' . str_replace(DS, '/', $date) . '/' . $itemId . '/' . $fileName;
				
			//			return $image;
		}
	
		return $image;
	}
}
