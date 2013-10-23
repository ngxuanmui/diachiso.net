<?php
// No direct access
defined('_JEXEC') or die;

$items = $this->items;

JHtml::_('behavior.formvalidation');

$thumbWidth = 100;
$thumbHeight = 800;
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (document.formvalidator.isValid(document.id('order-form'))) {
			Joomla.submitform(task, document.getElementById('order-form'));
		}
	}
</script>

<div class="left fltlft">
	<?php JEUtil::loadModule('position-7');	?>
</div>

<div class="right fltrgt">
	<h2>Đặt hàng</h2>
	
	
	<form action="<?php echo JRoute::_('index.php?option=com_je_product&id=' . JRequest::getInt('id'), false); ?>" method="post" name="order-form" id="order-form" class="form-validate">
		
		<h3>Thông tin giỏ hàng</h3>
		
		<table width="100%" class="tbl-shopping-cart">
			<tr>
				<th>#</th>
				<th colspan="2">Sản phẩm</th>
				<th>Số lượng</th>
				<th width="5%" nowrap="nowrap">Thành tiền</th>
			</tr>
		  <?php 
		  $i = 1;
		  $total = 0;
		  
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
					<?php echo $item->qty; ?>
				</td>
				<td nowrap="nowrap">
					<?php 
					$price = $item->promotion_price * $item->qty;
					
					$total += $price;
					
					echo number_format($price);
					?> đ
				</td>
			</tr>
			<?php $i ++; endforeach; ?>
			<tr>
				<td colspan="8">
					<span class="fltrgt">Tổng tiền cần thanh toán: <?php echo number_format($total); ?> đ</span>
				</td>
			</tr>
		</table>
		
		<div class="clr"></div>
		
		<table cellpadding="5" width="100%">
			<tr>
				<td width="100">Họ tên</td>
				<td><input type="text" name="fullname" value="" class="required" required="false" /></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email" value="" class="required validate-email" /></td>
			</tr>
			<tr>
				<td>Điện thoại</td>
				<td><input type="text" name="mobile" value="" class="required" /></td>
			</tr>
			<tr>
				<td>Ghi chú</td>
				<td><textarea name="comment" cols="60" rows="5"></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<button class="btn" type="button" onclick="Joomla.submitbutton('order.send')">Đặt hàng</button>
					<a href="#" class="btn">Hủy bỏ</a>
					<?php echo JHtml::_('form.token'); ?>
					<input type="hidden" name="id" value="<?php echo JRequest::getInt('id'); ?>" />
					<input type="hidden" name="task" value="" />
				</td>
			</tr>
		</table>
	</form>
</div>

<div class="clr"></div>