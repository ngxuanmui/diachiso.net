<?php
$brandId = JRequest::getInt('brand_id');
$subBrandId = JRequest::getInt('sub_brand_id');
$categoryId = JRequest::getInt('category_id');
?>

<?php if (!empty($brandId)): ?>
	<?php if (!empty($this->subBrands)): ?>
	<select id="jform_sub_brand_id" name="jform[sub_brand_id]">
		<option value="">- Select Sub Brand -</option>
		<?php 
		foreach ($this->subBrands as $i => $item) : 
			$selected = ($item->id == $subBrandId) ? 'selected="selected"' : '';
		?>
		<option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->title; ?></option>
		<?php endforeach; ?>
	</select>
	<?php else:?>
	<span style="line-height: 28px;">No sub brand found!</span>
	<?php endif;?>
<?php else: ?>
	<span style="line-height: 28px;">Select brand first!</span>
<?php endif; ?>