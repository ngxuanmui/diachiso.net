<?php
// No direct access
defined('_JEXEC') or die;
$items = $this->items;
?>

<div class="box-header"><?php echo $this->categoryInfo->title; ?></div>

<ul class="latest-list-images">
	<?php foreach ($items as $item): ?>
	<li>
		<?php 
		require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';
		
		$file 		= JPATH_ROOT . DS . 'images/je_products/upload/' . $item->images;
		$thumbFile 	= JPATH_ROOT . DS . 'images/je_products/thumbs/160/thumb_' . $item->images;
		
		JEUtil::resizeImage($file, $thumbFile, 160);
		?>
		
		
				
		<a title="<?php echo $item->location_name . ': ' . $item->name; ?>" href="<?php echo JRoute::_('index.php?option=com_je_product&view=detail&id='. $item->id); ?>">
			<img alt="Promotion Image" src="images/je_products/thumbs/160/thumb_<?php echo $item->images; ?>">
			<?php echo $item->location_name; ?>: <?php echo $item->name;?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>

<div class="clr"></div>

<div class="pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>

<div class="clr"></div>