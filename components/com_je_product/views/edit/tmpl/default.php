<?php
// no direct access
defined('_JEXEC') or die;
?>

<h1>Sửa thông tin</h1>
<p>
	Nhập vào email và mã số đã gửi về email của bạn để sửa lại thông tin
</p>
<form action="<?php echo JRoute::_('index.php?option=com_je_product&task=post.checkEdit'); ?>" method="post">
	<ul>
		<li>
			<label>Email</label>
			<input type="text" name="email">
		</li>
		<li>
			<label>Mã số</label>
			<input type="text" name="code">
		</li>
		<li>
			<label>&nbsp;</label>
			<input type="submit" name="btn-submit" value="Sửa thông tin">
		</li>
	</ul>
	<?php echo JHtml::_('form.token'); ?>
</form>
