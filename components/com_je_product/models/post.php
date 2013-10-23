<?php
/**
 * @version		$Id: post.php 21593 2011-06-21 02:45:51Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_je_product
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');

/**
 * @package		Joomla.Site
 * @subpackage	com_je_product
 * @since 1.5
 */
class JE_ProductModelPost extends JModelForm
{
	/**
	 * @since	1.6
	 */
	protected $view_item = 'post';

	protected $_item = null;

	/**
	 * Model context string.
	 *
	 * @var		string
	 */
	protected $_context = 'com_je_product.post';

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');
	}

	/**
	 * Method to get the contact form.
	 *
	 * The base form is loaded from XML and then an event is fired
	 *
	 *
	 * @param	array	$data		An optional array of data for the form to interrogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_je_product.post', 'post', array('control' => 'jform', 'load_data' => $loadData));
		
		if (empty($form)) {
			return false;
		}

		$session = JFactory::getSession();
		$id = $session->get('je_product.post.id', null);
		
		if(isset($id) || JFactory::getUser()->id)
		{
			$form->setFieldAttribute('email', 'required', 'false');
			$form->setFieldAttribute('email', 'disabled', 'true');
			$form->setFieldAttribute('email', 'filter', 'unset');
			
			if(JFactory::getUser()->id)
				$form->setFieldAttribute('scode', 'required', 'false');
		}
		
		$id = $this->getState('post.id');
		$params = $this->getState('params');

		return $form;
	}

	protected function loadFormData()
	{
		$data = (array)JFactory::getApplication()->getUserState('com_je_product.post.data', array());
		
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		
		$tmpEmail = is_array($data) ? $data['email'] : (is_object($data) ? $data->email : null);
		
		$session = JFactory::getSession();
		$postEmail 	= $session->get('je_product.post.email', 	$tmpEmail);
		
		if(JFactory::getUser()->id)
			$email = JFactory::getUser()->email;
		elseif(isset($postEmail))
			$email = $postEmail;
			
		if(is_object($data))
			$data->email = $email;
		elseif(is_array($data))
			$data['email'] = $email;
		
		return $data;
	}
	
	public function getItem()
	{
		$session = JFactory::getSession();
		
		$postId 	= $session->get('je_product.post.id', 		null);
		$postEmail 	= $session->get('je_product.post.email', 	null);
		$postCode 	= $session->get('je_product.post.code', 	null);
		
		if(!$postId) return false;

		$db = JFactory::getDbo();
		
		$query = "SELECT * FROM #__je_products WHERE id = '$postId'";
		$db->setQuery($query);
		
		$result = $db->loadObject();
		
		if(!empty($result))
			return $result;
		
		return false;
	}
	
	/**
	 * Function to save data
	 */
	public function save()
	{
		$post = JRequest::get('post');
		$data = $post['jform'];
		
		$table		= $this->getTable();
		$key		= $table->getKeyName();
				
		//upload image
		$files = JRequest::get('files');
		
		$session = JFactory::getSession();		
		$user = JFactory::getUser();
		
		if($user->id)
			$data['userid'] = $user->id;
		
		$data['id'] = $session->get('je_product.post.id', 	null);
		
		//always set state = 0
		$data['state'] = 0;
		
		$postEmail 	= $session->get('je_product.post.email', 	null);
		
		if(isset($postEmail))
			$data['email'] = $postEmail;
		else 
		{
			//get random for code & code_msg
			$returnCode = $data['code'] = JEUtil::getRandomString();
			$data['code_msg'] 	= JEUtil::getRandomString();
		}
		
		// Bind the data.
		if (!$table->bind($data)) {
			$this->setError($table->getError());
			return false;
		}
		
		// Check the data.
		if (!$table->check()) {
			$this->setError($table->getError());
			return false;
		}		
		
		// Store the data.
		if (!$table->store()) {
			$this->setError($table->getError());
			return false;
		}
		
		$pkName = $table->getKeyName();
		
		if (isset($table->$pkName)) {
			$this->setState($this->getName().'.id', $table->$pkName);
		}
		
		//update location
		$itemId = $table->$pkName;
		
		$db = JFactory::getDbo();
		
		foreach ($post['jform']['product_location'] as $location)
		{
			$query = "INSERT INTO #__je_product_info SET product_id = '$itemId', info_id = '$location'";
			$db->setQuery($query);
		
			$db->query();
			
			if($db->getErrorMsg())
				die($db->getErrorMsg());
		}
		
		$record = $this->getProduct($itemId);
		
		$uploadPath 		= CFG_UPLOAD_IMAGES_PATH . DS . 'je_products' . DS . 'upload' . DS;
			
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
		
		if(isset($returnCode))
			return $returnCode;
		
		return true;
	}
	
	function getProduct($id)
	{
		$db = JFactory::getDbo();
		$query = "SELECT * FROM #__je_products WHERE id = '$id'";
		
		$db->setQuery($query);
		$result = $db->loadObject();
		
		return $result;
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
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Product', $prefix = 'JE_ProductTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	function checkEdit($email, $code, $id = null)
	{
		$db = JFactory::getDbo();
		
		$user = JFactory::getUser();
		$query = "SELECT id FROM #__je_products";
		
		if($user->id)
			$query .= " WHERE userid = '".$user->id."' AND id = '$id'";
		else
			$query .= " WHERE email = '$email' AND code = '$code'";
		
		$db->setQuery($query);
		$result = $db->loadObject();
		
		if(!empty($result))
			return $result->id;
			
		return false;
	}
}