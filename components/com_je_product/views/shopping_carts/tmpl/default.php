<?php
// No direct access
defined('_JEXEC') or die;

$items = $this->items;

$thumbWidth = 100;
$thumbHeight = 800;
?>

<h2>Thông tin giỏ hàng</h2>

<form name="userForm" class="user-form" action="<?php echo JRoute::_('index.php'); ?>" method="post">
	<table width="100%" class="tbl-shopping-cart">
		<tr>
			<th>#</th>
			<th colspan="2">Sản phẩm</th>
			<th>Số lượng</th>
			<th width="5%" nowrap="nowrap">Thành tiền</th>
			<th>&nbsp;</th>
		</tr>
	  <?php 
	  $i = 1;
	  $total = 0;
	  
	  if (!empty($items)):
		  foreach ($items as $key => $item): 
			  require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';
			  
			  $pathUpload = JPATH_ROOT . DS . PATH_TO_IMAGE;
			  $pathThumb = JPATH_ROOT . DS . 'images/je_products/thumbs/' . $thumbWidth . DS;
			  
			  $thumb = JEUtil::thumb($item->images, $pathUpload, $pathThumb, $thumbWidth, $thumbHeight);
	  
	  ?>
	  <tr>
			<td width="1%"><?php echo $i; ?></td>
			<td width="110"><img alt="<?php echo $item->alias; ?>"
				src="images/je_products/thumbs/<?php echo $thumbWidth . '/' . $thumb[0]; ?>">
			</td>
			<td>
				<h3><?php echo $item->name; ?></h3>
				<p class="shopping-cart-price">Giá bán: <?php echo number_format($item->promotion_price); ?> đ</p>
			</td>
			<td width="70">
				<input type="hidden" name="id[<?php echo $key; ?>]" value="<?php echo $key; ?>" />
				<input type="text" name="qty[<?php echo $key; ?>]" size="10" class="txtbox" value="<?php echo $item->qty; ?>" />
			</td>
			<td nowrap="nowrap">
				<?php 
				$price = $item->promotion_price * $item->qty;
				
				$total += $price;
				
				echo number_format($price);
				?> đ
			</td>
			<td width="1%"><a href="<?php echo JRoute::_('index.php?option=com_je_product&task=shopping_cart.remove&id=' . $key, false); ?>" class="btn">Xóa</a></td>
		</tr>
		<?php $i ++; endforeach; ?>
		<tr>
			<td colspan="8">
				<span class="fltrgt">Tổng tiền cần thanh toán: <?php echo number_format($total); ?> đ</span>
			</td>
		</tr>
		<tr>
			<td colspan="8">
			
				<input type="hidden" name="option" value="com_je_product" />
				<input type="hidden" name="task" value="shopping_cart.update" />
				
				<a href="#" class="btn update-cart">Cập nhật giỏ hàng</a> 
				<a href="<?php echo JRoute::_('index.php?option=com_je_product&view=order', false); ?>" class="btn">Đặt hàng</a>
			</td>
		</tr>
		<?php else: ?>
		<tr>
			<td colspan="8">
				<span class="fltlft">Chưa có sản phẩm nào trong giỏ hàng</span>
			</td>
		</tr>
		<?php endif; ?>
	</table>
</form>

<div class="clr"></div>

<script type="text/javascript">
<!--
jQuery(function($){
	$('.update-cart').click(function(){
		$('form.user-form').submit();
		return false;
	});
});
//-->
</script>