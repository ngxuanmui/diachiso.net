<?php

class JE_ProductControllerOrder extends JController
{
	public function send()
	{
		$post = JRequest::get('post');
		
// 		$model = $this->getModel('Order', 'JE_ProductModel');
// 		$item = $model->getItem();
		
		$mailer =& JFactory::getMailer();
		
		$config =& JFactory::getConfig();
		$sender = array(	$config->getValue( 'config.mailfrom' ),
							$config->getValue( 'config.fromname' )
					);

		// set sender
		$mailer->setSender($sender);
		
		// set recipient
		$mailer->addRecipient($config->getValue( 'config.mailfrom' ));
		
		$mailer->setSubject('New order from website hoathuyanh.com.vn');
		
		// Optional file attached
//		$mailer->addAttachment(JPATH_COMPONENT.DS.'assets'.DS.'document.pdf');

		$body   = '<h2>Hello Admin. New order form website hoathuyanh.com.vn</h2>'
					. '<div style="margin-top: 20px; margin-bottom: 10px; font-weight: bold;">Information</div>'
					. '<div>Fullname: ' . $post['fullname'] . '</div>'
					. '<div>Email: ' . $post['email'] . '</div>'
					. '<div>Mobile: ' . $post['mobile'] . '</div>'
					. '<div>Number: ' . $post['number'] . '</div>'
					. '<div>Comment: ' . $post['comment'] . '</div>'
				;
		
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setBody($body);
		
		$send =& $mailer->Send();
		
		if ( $send !== true )
		{
			$msg = 'Có lỗi xảy ra trong quá trình gửi email. Vui lòng thử lại sau.';
			$this->setRedirect('index.php?option=com_je_product&view=order&id='.$item->id, $msg, 'notice');
		} 
		else 
		{
			$msg = 'Email đã được gửi tới chúng tôi. Cảm ơn bạn đã sử dụng dịch vụ.';
			$this->setRedirect('index.php?option=com_je_product&view=order_success', $msg);
		}
		
		return;
	}
}