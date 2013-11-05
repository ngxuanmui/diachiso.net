<?php
/**
 * @version		$Id: brand.php 20228 2011-01-10 00:52:54Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * brand model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @since		1.6
 */
class JE_ProductModelBrand extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_JE_PRODUCT_BRAND';

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
	public function getTable($type = 'Brand', $prefix = 'JE_ProductTable', $config = array())
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
		$form = $this->loadForm('com_je_product.brand', 'brand', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		// Determine correct permissions to check.
		if ($this->getState('brand.id')) {
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
		$data = JFactory::getApplication()->getUserState('com_je_product.edit.brand.data', array());

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
		
		$brandId = ($data['id']) ? $data['id'] : $db->insertid();
		
		$post 	= JRequest::get('post');
		
		$jinput = JFactory::getApplication()->input;
		
		// delete all sub brands before re-insert sub brands
		$query = "DELETE FROM #__je_sub_brands WHERE brand_id = '$brandId'";
		$db->setQuery($query);
		
		$db->query();
		
		if($db->getErrorMsg())
		{
			die('Error: '.$query);
		}
		
		$subBrandsTitle = $jinput->post->get('sub_brand_title', array(), 'array');
		$subBrandsDesc = $jinput->post->get('sub_brand_desc', array(), 'array');
		$files = $jinput->files->get('jform');
		
		$subBrandsFile = $files['sub_brand_logo'];
		
		var_dump($subBrandsFile);
		
		$created = explode('-', date('Y-m-d', strtotime($data['created'])));
		
		$strPath = 'images' . DS . 'sub_brands' . DS . $created[0] . DS . $created[1] . DS . $created[2] . DS . $data['id'] . DS;
		
		$subBrandLogoPath = JPATH_ROOT . DS . $strPath;
		
		// Make directory
		@mkdir($subBrandLogoPath, 0777, true);
		
// 		var_dump($data['created'], $created, $subBrandLogoPath);

// 		var_dump($subBrandsFile);
		
		$subBrandCreated = date('Y-m-d H:i:s');
		$subBrandCreatedBy = JFactory::getUser()->id;
		
		foreach ($subBrandsTitle as $key => $title)
		{
			if ($title != '')
			{
				$desc = $subBrandsDesc[$key];
				
				$image = '';
				
				$fileUpload = $subBrandsFile[$key];
				
				$fileName = $fileUpload['name'];
				
				if (isset($fileName) && $fileName) 
				{
					$filepath = JPath::clean($subBrandLogoPath . $fileName);
				
					// Move uploaded file
					jimport('joomla.filesystem.file');
				
					if (!JFile::upload($fileUpload['tmp_name'], $filepath))
					{
						JError::raiseWarning(100, JText::_('COM_MEDIA_ERROR_UNABLE_TO_UPLOAD_FILE')); // Error in upload
						return '';
					}
				
					// set value to return
					$image = str_replace(DS, '/', $strPath) . $fileName;
				}
				
				$query = "INSERT INTO #__je_sub_brands SET	brand_id 	= '$brandId', 
															title 		= '$title', 
															description = ".$db->quote($desc).", 
															logo 		= '$image', 
															state 		= 1, 
															created 	= '$subBrandCreated', 
															created_by 	= '$subBrandCreatedBy';";
				$db->setQuery($query);
				
				$db->query();
				
				if($db->getErrorMsg())
				{
					die('Query: '.$query.'. Error: ' . $db->getErrorMsg());
				}
			}
		}
		
// 		var_dump($subBrandsTitle, $subBrandsDesc, $subBrandsFile['sub_brand_logo']);
		
// 		die;
		
		//delete all recs in #__je_brand_category that brand_id = last id
		$query = "DELETE FROM #__je_brand_category WHERE brand_id = '$brandId'";
		$db->setQuery($query);
		
		$db->query();
		
		if($db->getErrorMsg())
		{
			die('Error: '.$query);
		}
		
		//for each category, insert
		foreach ($post['jform']['customcategory'] as $catId)
		{				
			$query = "INSERT INTO #__je_brand_category SET brand_id = '$brandId', category_id = '$catId';";
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
		$content = $this->copyFilesOnSave($data['description'], $brandId);
			
		if ($content)
			$data['description'] = $content;
			
		$data['id'] = $id;
		
		$saveResult = parent::save($data);
		
		return $saveResult;
	}
	
	private function copyFilesOnSave($content = '', $itemId = 0)
	{
		if(!$content || !$itemId)
			return false;
	
		$date = date('Y') . DS . date('m') . DS . date('d');
	
		$dest = JPATH_ROOT . DS . 'images' . DS . 'brand-content' . DS . $date . DS . $itemId . DS;
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
			$tmpReplace[] = 'images/brand-content/' . str_replace(DS, '/', $date) . '/' . $itemId . '/' . end($imgSrc);
	
			$src = str_replace('/', DS, JPATH_ROOT.'/'.$img['src']);
	
			if($imgSrc[0] == 'tmp')
				JFile::copy($src, $dest.end($imgSrc));
		}
	
		$content = str_replace($tmpSearch, $tmpReplace, $content);
	
		return $content;
	}
	
	private function uploadImages($field = 'images', $itemId = 0, $delImage = 0, $oldImg = '')
	{
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
	
		$dest = JPATH_ROOT . DS . 'images' . DS . 'brands' . DS . $path . DS . $date . DS . $itemId . DS;
	
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
			$image = 'images/brands/'.$path.'/' . str_replace(DS, '/', $date) . '/' . $itemId . '/' . $fileName;
				
			//			return $image;
		}
	
		return $image;
	}
}
