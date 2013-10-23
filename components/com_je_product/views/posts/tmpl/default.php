<?php
// no direct access
defined('_JEXEC') or die;

$items = $this->items;
?>

<h1>Thông tin</h1>
<div>
	Nơi quản lý thông tin bạn đã đăng
</div>

<table width="100%" cellpadding="5" cellspacing="0">
	<tr style="background: #F5F5F5; color: #333;">
		<th>#</th>
		<th>Tiêu đề</th>
		<th width="15%">Danh mục</th>
		<th width="15%">Tỉnh / Thành</th>
		<th width="10%" nowrap="nowrap">Từ ngày</th>
		<th width="10%" nowrap="nowrap">Đến ngày</th>
		<th width="5%" nowrap="nowrap">Trạng thái</th>
		<th width="10%" nowrap="nowrap">&nbsp;</th>
	</tr>
	<?php foreach ($items as $key => $item): ?>
	<tr class="<?php if($key % 2):?>even<?php else: ?>odd<?php endif;?>">
		<td align="center"><?php echo $key + 1; ?></td>
		<td align="left"><?php echo $item->name; ?></td>
		<td><?php echo $item->category_title; ?></td>
		<td align="left"><?php echo $item->location_name; ?></td>
		<td align="center"><?php echo date('d/m/Y', strtotime($item->publish_up)); ?></td>
		<td align="center"><?php echo date('d/m/Y', strtotime($item->publish_down)); ?></td>
		<td align="center">
			<?php if($item->state == 1): ?>
				Hiển thị
			<?php else: ?>
				---
			<?php endif; ?>
		</td>
		<td nowrap="nowrap">
			[<a href="<?php echo JRoute::_('index.php?option=com_je_product&task=post.checkEdit&id='.$item->id); ?>">Sửa</a>] 
			[Xóa]
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<div>
	[<a href="">Thêm mới</a>]
</div>

<div class="pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>