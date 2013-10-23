<?php
/**
 * @version		$Id: view.html.php 21677 2011-06-25 20:56:56Z chdemko $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML Contact View class for the Contact component
 *
 * @package		Joomla.Site
 * @subpackage	com_je_product
 * @since 		1.5
 */
class JE_ProductViewDetail extends JView
{
	protected $item;
	protected $otherProducts;
	
	function display($tpl = null)
	{
		$this->item = $this->get('Item');
		
		//echo '<pre>'; print_r($this->item);
		
		if(!$this->item)
		{
			$tpl = 'not_exist';
		}
		
		$this->otherProducts = $this->get('OtherProducts');
		
		//var_dump($this->item);
		
		#var_dump($this->otherProducts);
		
		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$document = JFactory::getDocument();
		
		$item = $this->item;
		
		//add pathway
		$app		= JFactory::getApplication();
		$pathway	= $app->getPathway();
		
		if(!$item)
		{
			$document->setTitle('Thông tin không tồn tại');
			$pathway->addItem('Thông tin không tồn tại');
		}
		else 
		{
			$pathway->addItem($item->name);
			$document->setTitle($item->name);		
			$document->setDescription( $item->name . ' - ' .  JHtml::_('string.truncate', strip_tags($item->description), 400) );
		}			
		
		$key = 'khuyến mại, khuyến mãi, khuyen mai, giảm giá, giam gia, quà tặng, qua tang, miễn phí, mien phi, 
				tin khuyến mại, tin khuyen mai, thông tin khuyến mại, tin giảm giá, chương trình khuyến mại, 
				chuong trinh khuyen mai, giờ vàng, gio vang, tháng khuyến mại, thang khuyen mai, tuan khuyen mai, 
				mua khuyen mai, hàng giá rẻ, hang gia re, sale, sale off';
		
		if(isset($item->metakey) && $item->metakey)
			$key = $item->metakey;
			
		$document->setMetaData('keywords', $key);
	}
}
