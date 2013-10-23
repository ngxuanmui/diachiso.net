<?php
// No direct access
defined('_JEXEC') or die;

$item = $this->item;

require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';
		
$pathUpload = JPATH_ROOT . DS . PATH_TO_IMAGE;
$pathThumb = JPATH_ROOT . DS . 'images/je_products/thumbs/' . THUMB_WIDTH_LIST . DS;

$thumb = JEUtil::thumb($item->images, $pathUpload, $pathThumb, THUMB_WIDTH_LIST, THUMB_HEIGHT_LIST);
?>

<script type="text/javascript">
<!--
jQuery(function($){
	$('.btn').click(function(){
		window.top.location = $(this).attr('href');
		return false;
	});
});
//-->
</script>

<table width="600" class="tbl-shopping-cart">
	<tr>
		<td width="200">
			<img alt="<?php echo $item->alias; ?>" src="images/je_products/thumbs/<?php echo THUMB_WIDTH_LIST . '/' . $thumb[0]; ?>">
		</td>
		<td>
			<h3><?php echo $item->name; ?></h3>
			<p class="shopping-cart-price">Giá bán: <?php echo number_format($item->promotion_price); ?> đ</p>
		</td>
		<td width="100">
			Số lượng: 1
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<a href="<?php echo JRoute::_('index.php?option=com_je_product&view=shopping_carts', false); ?>" class="btn">Xem giỏ hàng</a>
			<a href="<?php echo JRoute::_('index.php?option=com_je_product&view=order', false); ?>" class="btn">Đặt hàng</a>
		</td>
	</tr>
</table>

<div class="clr"></div>