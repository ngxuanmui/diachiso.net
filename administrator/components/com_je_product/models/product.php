<?php
/**
 * @version		$Id: product.php 17015 2010-05-13 06:37:40Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Banner model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class je_productModelProduct extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_JE_PRODUCT_PRODUCT';

	/**
	 * Method to product whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	boolean	True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canDelete($record)
	{
		$user = JFactory::getUser();

		if ($record->catid) {
			return $user->authorise('core.delete', 'com_je_product.category.'.(int) $record->catid);
		} else {
			return parent::canDelete($record);
		}
	}

	/**
	 * Method to product whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 * @return	boolean	True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		if ($record->catid) {
			return $user->authorise('core.edit.state', 'com_je_product.category.'.(int) $record->catid);
		} else {
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
	public function getTable($type = 'Product', $prefix = 'je_productTable', $config = array())
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
		$form = $this->loadForm('com_je_product.product', 'product', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		// Determine correct permissions to check.
		if ($this->getState('product.id')) {
			// Existing record. Can only edit in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.edit');
		} else {
			// New record. Can only create in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.create');
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
		$data = JFactory::getApplication()->getUserState('com_je_product.edit.product.data', array());

		if (empty($data)) {
			$data = $this->getItem();
			
			$data->set('old_images', $data->images);
			$data->set('old_thumb_images', $data->thumb_images);
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
	protected function getReorderConditions($table = null)
	{
		$condition = array();
		$condition[] = 'catid = '. (int) $table->catid;
		$condition[] = 'state >= 0';
		return $condition;
	}
	
	/**
	 * Overwrite parent save
	 * @see JModelAdmin::save()
	 */
	function save($data)
	{
		$db = JFactory::getDbo();
		$post = JRequest::get('post');
		
		$saveResult = parent::save($data);
		
		$itemId = $this->getState($this->getName().'.id');
		$record = $this->getItem($itemId);
		
		if($saveResult)
		{
			$uploadPath 		= JPATH_ROOT . DS . 'images' . DS . 'je_products' . DS . 'upload' . DS;
			
			//upload file		
			$imagesUpload = $this->uploadFiles($record->alias . '-' . $record->id, $uploadPath);
			
			$delImage = isset($post['jform']['del_image']) ? $post['jform']['del_image'] : null;
			
			//get old images			
			$oldImages = unserialize($record->images);
			
			if(is_array($oldImages) && is_array($delImage))
			{
				foreach ($delImage as $img)
				{
					if(in_array($img, $oldImages))
					{
						//search key by value
						$delKey = array_search($img, $oldImages);
						
						//remove image
						@unlink($uploadPath . $img);
						
						//unset in old image
						unset($oldImages[$delKey]);
					}
				}
			}
			
			$oldImages = (is_array($oldImages)) ? $oldImages : array();
			
			//set image to update
			$images = (is_array($imagesUpload)) ? array_merge($oldImages, $imagesUpload) : $oldImages;
			
			//save image
			$query = "UPDATE #__je_products SET images = '".serialize($images)."' WHERE id = " . (int) $record->id;
			$db->setQuery($query);
			
			$db->query();
			
			//delete all before save data to relation table
			$query = "DELETE FROM #__je_product_info WHERE product_id = '$itemId'";
			$db->setQuery($query);
			
			$db->query();
			
			foreach ($data['product_location'] as $location)
			{
				$query = "INSERT INTO #__je_product_info SET product_id = '$itemId', info_id = '$location'";
				$db->setQuery($query);
			
				$db->query();
			}
		}
		
		return $saveResult;
	}
	
	function uploadFiles($fileName, $uploadPath)
	{
		//require upload file
		require_once JPATH_ROOT . '/jelibs/classes/upload.class.php';
		
		//define upload path
		$uploadPathMore = date('Y') . DS . date('m') . DS . date('d') . DS;		
		$uploadPath .= $uploadPathMore;
		
		//echo $uploadPath; die;
		
		$files = JRequest::get('files');
		$post = JRequest::get('post');
		
		$files = $files['jform'];
		$arrOrder = $post['jform']['images']['order'];
		
		$arr_1 = array();
		$arr_2 = array();
		
		foreach ($arrOrder as $key => $order)
		{
			if(!$order)
				$arr_1[$key] = '';
			else 
				$arr_2[$key] = $order;
		}
		
		asort($arr_2);
		
		$arrOrder = $arr_1 + $arr_2;
		
		$name = array();
		$data = array();
		
		foreach ($arrOrder as $key => $order)
		{
			
			if($files['name']['images'][$key] != '' && !$files['error']['images'][$key])
			{
				//set image name
				$imageName = $fileName . '-' . time() . '.' . end(explode('.', $files['name']['images'][$key]));
				
				//upload file
				$upload = upload::file($files, 'images', $uploadPath, $imageName, $key, false);
				
				//if upload OK
				if(is_array($upload) && $upload['result'] == 'OK') 
				{
					$data[] = str_replace(DS, '/', $uploadPathMore) . $upload['file_name'];
				}
				else
				{
					JError::raiseNotice('UPLOAD_ERROR', 'Upload Error');
				}
			}
		}
		
		//$data = serialize($data);
		
		return $data;
	}
	
	/**
	 * Method to stick records.
	 *
	 * @param	array	The ids of the items to publish.
	 * @param	int		The value of the published state
	 *
	 * @return	boolean	True on success.
	 */
	function stick(&$pks, $value = 1)
	{
		// Initialise variables.
		$user	= JFactory::getUser();
		$table	= $this->getTable();
		$pks	= (array) $pks;

		// Access checks.
		foreach ($pks as $i => $pk) {
			if ($table->load($pk)) {
				if (!$this->canEditState($table)) {
					// Prune items that you can't change.
					unset($pks[$i]);
					JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
				}
			}
		}

		// Attempt to change the state of the records.
		if (!$table->stick($pks, $value, $user->get('id'))) {
			$this->setError($table->getError());
			return false;
		}

		return true;
	}
	
	function update_images()
	{
		$db = JFactory::getDbo();
		$query = "SELECT id, images FROM #__je_products ORDER BY id DESC";
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		
		foreach ($result as $obj)
		{
			
				$images = serialize(array($obj->images));
				
				//update
				$query = "UPDATE #__je_products SET images = '$images' WHERE id = " . (int) $obj->id;
				$db->setQuery($query);
				
				$db->query(); 
		}
	}
}
