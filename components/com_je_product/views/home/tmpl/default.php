<?php
// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.module.helper');

$items = $this->items;
$promotion_items = $this->promotion_items;

// always load modal
?>

<img src="<?php echo JURI::base()?>/images/slider.png" />

<h1 class="box-title">
	<span>SẢN PHẨM MỚI</span>
</h1>

<ul class="list-items home-list-items">
<?php 
foreach ($items as $key => $item): 
	$images = unserialize($item->images);

	$firstImage = '';

	if (!empty($images))
	{
		$firstImage = $images[0];
	}
?>
	<li <?php if ( ($key + 1) % 4 == 0) echo 'class="last"'?>>
		<h3><?php echo $item->name; ?></h3>
		<?php 
		require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';
		
		$pathUpload = JPATH_ROOT . DS . PATH_TO_IMAGE;
		$pathThumb = JPATH_ROOT . DS . 'images/je_products/thumbs/' . THUMB_WIDTH_LIST . DS;
		
		$thumb = JEUtil::thumb($item->images, $pathUpload, $pathThumb, THUMB_WIDTH_LIST, THUMB_HEIGHT_LIST);
		?>
		
		<a title="<?php echo $item->name; ?>" href="<?php echo JRoute::_(JE_ProductHelperRoute::getDetailRoute($item->id, $item->catid, $item->alias)); ?>">
			<span class="img home-img">
				<img alt="<?php echo $item->alias; ?>" src="images/je_products/thumbs/<?php echo THUMB_WIDTH_LIST . '/' . $thumb[0]; ?>">
			</span>
		</a>
		
		<?php /*
		<p class="price">Giá cũ: <strike><?php echo number_format($item->price); ?></strike> vnđ</p>
		*/ ?>
		<p>Giá bán: <?php echo number_format($item->promotion_price); ?> đ</p>
		<a class="btn fancybox fancybox.iframe" href="<?php echo JRoute::_('index.php?option=com_je_product&task=shopping_cart.add&id=' . $item->id, false); ?>">Mua ngay</a>
	</li>
<?php endforeach; ?>
</ul>
<div class="clr"></div>
<h1 class="box-title">
	<span>SẢN PHẨM GIẢM GIÁ</span>
</h1>
<ul class="list-items home-list-items">
<?php 
foreach ($promotion_items as $key => $item): 
	$images = unserialize($item->images);

	$firstImage = '';

	if (!empty($images))
	{
		$firstImage = $images[0];
	}
?>
	<li <?php if ( ($key + 1) % 4 == 0) echo 'class="last"'?>>
		<h3><?php echo $item->name; ?></h3>
		<?php 
		require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';
		
		$pathUpload = JPATH_ROOT . DS . PATH_TO_IMAGE;
		$pathThumb = JPATH_ROOT . DS . 'images/je_products/thumbs/' . THUMB_WIDTH_LIST . DS;
		
		$thumb = JEUtil::thumb($item->images, $pathUpload, $pathThumb, THUMB_WIDTH_LIST, THUMB_HEIGHT_LIST);
		?>
		
		<a title="<?php echo $item->name; ?>" href="<?php echo JRoute::_(JE_ProductHelperRoute::getDetailRoute($item->id, $item->catid, $item->alias)); ?>">
			<span class="img home-img">
				<img alt="<?php echo $item->alias; ?>" src="images/je_products/thumbs/<?php echo THUMB_WIDTH_LIST . '/' . $thumb[0]; ?>">
			</span>
		</a>
		
		<p>Giá cũ: <strike><?php echo number_format($item->price); ?></strike> đ</p>
		<p>Giá bán: <?php echo number_format($item->promotion_price); ?> đ</p>
		<a class="btn fancybox fancybox.iframe" href="<?php echo JRoute::_('index.php?option=com_je_product&task=shopping_cart.add&id=' . $item->id, false); ?>">Mua ngay</a>
	</li>
<?php endforeach; ?>
</ul>
<div class="clr"></div>
