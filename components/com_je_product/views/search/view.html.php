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
class JE_ProductViewSearch extends JView
{
	protected $items;
	protected $pagination;
	
	function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		
		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$document = JFactory::getDocument();
		
		$document->setTitle('Kết quả tìm kiếm');
		$document->setDescription('Khuyến mại: Thông tin các chương trình khuyến mãi giảm giá, giá sock cập nhật mới nhất. 
									Khuyến mại điện máy, tủ lạnh, tivi, điện thoại, laptop...');
		
		$key = 'khuyến mại, khuyến mãi, khuyen mai, giảm giá, giam gia, quà tặng, qua tang, miễn phí, mien phi, 
				tin khuyến mại, tin khuyen mai, thông tin khuyến mại, tin giảm giá, chương trình khuyến mại, 
				chuong trinh khuyen mai, giờ vàng, gio vang, tháng khuyến mại, thang khuyen mai, tuan khuyen mai, 
				mua khuyen mai, hàng giá rẻ, hang gia re, sale, sale off, khuyến mại laptop, khuyến mại viettel, 
				khuyến mại vinaphone, khuyen mai big c, khuyến mại siêu thị, nhà hàng khuyến mại, vé máy bay giá rẻ, 
				du lịch giá rẻ, phiếu giảm giá, coupon, ngân hàng, ngan hang, điện máy, dien may, điện tử, dien tu,
				hàng gia dụng, hang gia dung, chia sẻ, chia se, viễn thông, vien thong, di động, di dong, khách sạn, 
				khach san, nhà hàng, nha hang, ô tô, o to, xe máy, xe may, thẻ tín dụng, the tin dung, vay tiền, vay tien,
				ưu đãi lãi suất, uu dai lai suat';
		
		$document->setMetaData('keywords', $key);
	}
}
