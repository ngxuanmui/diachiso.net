<?php
$brandId = JRequest::getInt('brand_id');
$categoryId = JRequest::getInt('category_id');
?>

<?php if (!empty($categoryId)): ?>
	<?php if (!empty($this->items)): ?>
	<select id="jform_brand_id" name="jform[brand_id]">
		<option value="">- Select Brand -</option>
		<?php 
		foreach ($this->items as $i => $item) : 
			$selected = ($item->id == $brandId) ? 'selected="selected"' : '';
		?>
		<option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
		<?php endforeach; ?>
	</select>
	<?php else:?>
	<span style="line-height: 23px;">No Brand found!</span>
	<?php endif;?>
<?php else: ?>
	<span style="line-height: 23px;">Select category first!</span>
<?php endif; ?>