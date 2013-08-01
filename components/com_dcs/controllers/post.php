<?php
/**
 * @version		$Id: Info.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Info controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_carman
 * @since		1.6
 */
class JE_ProductControllerPost extends JControllerForm
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_JE_PRODUCT_POST';
	
	function search()
	{
		$post = JRequest::get('post');
		
		$link = 'index.php?option=com_je_product&view=search&q='.$post['q'];
		
		$link = JRoute::_($link, false);
		
		$app = JFactory::getApplication();
		$app->redirect($link);
		
		exit();
	}
	
	public function changeLocation()
	{
		$location = JRequest::getVar('id', null);
		//set session
		$session = JFactory::getSession();
		$session->set('location', $location);
		
		$categoryModel = JModel::getInstance('Category', 'JE_ProductModel');
		$loc = $categoryModel->getLocation($location);
		
		if($loc->id)
			$t = $loc->id.'-'.$loc->alias;
		else 
			$t = $loc->alias;
		
		$link = 'index.php?option=com_je_product&view=category&Itemid=151&location='.$t;
			
		$link = JRoute::_($link, false);
		
		$app = JFactory::getApplication();
		$app->redirect($link);
		
		/*
		 * TODO: co the set ca cookie
		 */
		
		exit();
	} 
	
	function checkEdit()
	{
		$post = JRequest::get('post');
		
		if($post)
		{
			// Check for request forgeries.
			JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		}			
		
		//set link
		$linkPost = JRoute::_('index.php?option=com_je_product&view=post', false);
		
		$params = JComponentHelper::getParams('com_je_product');

		// Check for a valid session cookie
		if($params->get('validate_session', 0)) {
			if(JFactory::getSession()->getState() != 'active'){
				JError::raiseWarning(403, JText::_('Phiên làm việc không hợp lệ!'));
				
				// Redirect back to the post form.
				$this->setRedirect($linkPost);
				return false;
			}
		}
		
		$id = JRequest::getVar('id');
		
		$model = $this->getModel();
		
		$checkId = $model->checkEdit($post['email'], $post['code'], $id);
		
		$msg = '';
		
		if($checkId)
		{
			$session = JFactory::getSession();
			$session->set('je_product.post.id', 	$checkId		);
			$session->set('je_product.post.email', 	$post['email']	);
			$session->set('je_product.post.code', 	$post['code']	);
			
			//set link
			$linkPost = JRoute::_('index.php?option=com_je_product&view=post&id='.$checkId, false);
			$msg = '';
		}
		else
		{
			//set link
			$linkPost = JRoute::_('index.php?option=com_je_product&task=post.checkAdd', false);
			$msg = 'Thông tin không phù hợp. Vui lòng kiểm tra lại';
		}
		
		// Redirect to the post form.
		$this->setRedirect($linkPost, $msg);
		
		return true;
	}
	
	function checkAdd()
	{
		$session = JFactory::getSession();
		
		//unset all session
		$session->set('je_product.post.id', 	null);
		$session->set('je_product.post.email', 	null);
		$session->set('je_product.post.code', 	null);
		
		//set link
		$linkPost = JRoute::_('index.php?option=com_je_product&view=post', false);
				
		// Redirect to the post form.
		$this->setRedirect($linkPost);
		
		return true;
	}
	
	function cancel()
	{
		$session = JFactory::getSession();
		
		//unset all session
		$session->set('je_product.post.id', 	null);
		$session->set('je_product.post.email', 	null);
		$session->set('je_product.post.code', 	null);
		
		$user = JFactory::getUser();
		
		if($user->id)
			$link = 'index.php?option=com_je_product&view=posts';
		else 
			$link = JURI::base();
		
		//set link
		$linkPost = JRoute::_($link, false);
		
		// Redirect to the post form.
		$this->setRedirect($linkPost);
		
		return true;
	}
	
	function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$linkPost = JRoute::_('index.php?option=com_je_product&view=post', false);
		
		//check captcha
		$post = JRequest::get('post');
		$session = JFactory::getSession();
		
		$sessEmail = $session->get('je_product.post.email', null);
		
		//if not logged & not input email
		if( (isset($post['jform']['email']) && trim($post['jform']['email']) == '') && !JFactory::getUser()->id && !$sessEmail)
		{
			// Redirect back to the post form.
			$this->setRedirect($linkPost, 'Bạn cần nhập email để xác nhận!', 'warning');
			return false;
		}
		
		/*
		if($post['jform']['scode'] != $session->get('je_kcaptcha') && !JFactory::getUser()->id)
		{
			// Redirect back to the post form.
			$this->setRedirect($linkPost, 'Mã xác nhận không đúng!', 'warning');
			return false;
		}
		*/

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('post');
		$params = JComponentHelper::getParams('com_je_product');

		// Get the data from POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

		// Check for a valid session cookie
		if($params->get('validate_session', 0)) {
			if(JFactory::getSession()->getState() != 'active'){
				JError::raiseWarning(403, JText::_('Phiên làm việc không hợp lệ!'));

				// Save the data in the session.
				$app->setUserState('com_je_product.post.data', $data);

				// Redirect back to the post form.
				$this->setRedirect($linkPost);
				return false;
			}
		}

		// Contact plugins
		JPluginHelper::importPlugin('post');
		$dispatcher	= JDispatcher::getInstance();

		// Validate the posted data.
		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		$validate = $model->validate($form,$data);

		if ($validate === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();
			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if (JError::isError($errors[$i])) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_je_product.post.data', $data);

			// Redirect back to the post form.
			$this->setRedirect($linkPost);
			return false;
		}
		
		$result = $model->save();
		
		if(!$result)
		{
			$this->setRedirect($linkPost, 'Có lỗi xảy ra. Vui lòng thử lại.', 'warning');
			return false;
		}
		
		//send email to user & admin
		$id = $session->get('je_product.post.id', 	null);
		
		//send to user
		$status = (isset($id)) ? 'edit' : 'add';
		
		$toEmail = (isset($post['jform']['email'])) ? $post['jform']['email'] : $sessEmail;
		
		$user = JFactory::getUser();
		if($user->id)
			$toEmail = $user->email;
		
		$this->sendToUser($toEmail, $result, $status);
		
		$this->sendToAdmin('nguyenxuanmui@gmail.com', $status, $id);
		$this->sendToAdmin('bigsale.net.vn@gmail.com', $status, $id);
		
		// Flush the data from the session
		$app->setUserState('com_je_product.post.data', null);
		
		//clear session
		$session = JFactory::getSession();
		$session->set('je_product.post.id', 	null);
		$session->set('je_product.post.email', 	null);
		$session->set('je_product.post.code', 	null);

		// Redirect if it is set in the parameters, otherwise redirect back to where we came from
		$this->setRedirect(JRoute::_('index.php?option=com_je_product&view=finish', false), 'Đăng tải thông tin thành công.');
		
		return true;
	}
	
	private function _sendEmail($subject, $body, $toEmail = null)
	{
			$app		= JFactory::getApplication();
			
			$mailfrom	= $app->getCfg('mailfrom');
			$fromname	= $app->getCfg('fromname');
			$sitename	= $app->getCfg('sitename');
			
			$mail = JFactory::getMailer();
			
			$mail->addRecipient($mailfrom);
			$mail->addRecipient($toEmail);
			
			$mail->IsHTML(true);
			
			$mail->setSender(array($mailfrom, $fromname));
			$mail->setSubject($sitename.': '.$subject);
			$mail->setBody($body);
			$sent = $mail->Send();

			return $sent;
	}
	
	protected function sendToUser($toEmail, $code, $status = 'add')
	{
		$session = JFactory::getSession();
		
		//check: return false if user logged in post new content
		if(JFactory::getUser()->id && $status == 'add')
			return true;
		
		//to email
		//$toEmail = $session->get('je_product.post.email', 	null);
		
		$post = JRequest::get('post');
		
		
		if($status == 'add')
		{
			$subject = 'Thêm thông tin mới trên website bigsale.net.vn';
			$body  = "<p><strong>Chào bạn.</strong></p><p>&nbsp;</p><p>Bạn đã thêm thông tin mới để quảng cáo. Vui lòng ghi nhớ thông tin <strong>$code</strong> để sử dụng khi cần sửa lại thông tin.</p>";
			$body .= "<p>Để sửa lại thông tin, vui lòng click vào link dưới đây:</p>";
			$body .= "<p><a href='http://bigsale.net.vn/edit-info'>Sửa thông tin</a></p>";
			$body .= "<p>Cảm ơn bạn đã sử dụng website.</p>";
			$body .= "<p>&nbsp;</p>";
			$body .= "---<p><a href='http://www.bigsale.net.vn'>BIGsale.net.vn</a> - Tìm Khuyến Mại - Vì lợi ích người tiêu dùng</p>";
			
		}
		else 
		{
			$subject = 'Sửa thông tin trên website bigsale.net.vn';
			$body  = "<p><strong>Chào bạn.</strong></p><p>&nbsp;</p><p>Bạn đã sửa thông tin trên website bigsale.net.vn.</p>";
			$body .= "<p>Thông tin đã được gửi tới ban quản trị.</p>";
			$body .= "<p>Cảm ơn bạn đã sử dụng website.</p>";
			$body .= "<p>&nbsp;</p>";
			$body .= "---<p><a href='http://www.bigsale.net.vn'>BIGsale.net.vn</a> - Tìm Khuyến Mại - Vì lợi ích người tiêu dùng</p>";
			
		}
		
		
		$sent = $this->_sendEmail($subject, $body, $toEmail);
		
		return $sent;
	}
	
	protected function sendToAdmin($toEmail = null, $status = 'add', $id = NULL)
	{
		//to email
		if(!$toEmail)
			$toEmail = 'nguyenxuanmui@gmail.com';
		
		// Send the email
		if($status == 'add')
		{
			$subject = 'Thông tin mới được thêm vào lúc ' . date('d/m/Y H:i:s');
			$body = "<p>Hello.</p><p>Một thông tin mới đã được thêm vào lúc ".date('d/m/Y H:i:s').". Hãy kiểm tra backend và kích hoạt thông tin đó.</p>";
		}
		else
		{
			$subject = 'Thông tin mới được sửa lại vào lúc ' . date('d/m/Y H:i:s');
			$body = "<p>Hello.</p><p>Một thông tin mới đã được sửa lại vào lúc ".date('d/m/Y H:i:s').". Hãy kiểm tra backend và kích hoạt thông tin với ID: $id.</p>";
		}
		
		$sent = $this->_sendEmail($subject, $body, $toEmail);
		
		return $sent;
	}
}