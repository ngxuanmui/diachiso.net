<?php
// No direct access
defined('_JEXEC') or die;
$items = $this->items;
$category = $this->category;

$children = $category->getChildren();

//var_dump($category);
?>

<div id="category">
	<div class="left fltlft span2">
		<div class="box-header">
			<h2>
				<?php 
				if ($category->id == 'root')
					echo $items[0]->manu_title;
				else
					echo $category->title;
				?>
			</h2>
		</div>
		<div class="seperator"></div>
		<div class="left-info">
			<h2>GIAO HÀNG</h2>
			<img src="<?php echo JURI::base()?>images/freeship.jpg" />
		</div>
		<div class="seperator"></div>
		<div class="left-info">
			<h2>ĐIỆN HOA HOATHUYANH.VN</h2>
			<ul>
				<li>- Thiết kế hoa sảnh, hoa hội nghị, chúc mừng, khai trương, định
					kỳ, ...</li>
				<li>- Thiết kế hoa theo sự kiện, các dịp lễ hội, ...</li>
				<li>- Có dịch vụ giao quà tận nơi & nhiều ưu đãi cho khách hàng thân
					thiết</li>
				<li>- Cung cấp các loại hoa tươi sỉ và lẻ</li>
			</ul>
		</div>
	</div>

	<div class="right fltrgt span10">
		
	
		<?php if (!empty($children) && $category->id != 'root'): ?>
	
		<ul class="list-category">
			<?php 
			foreach ($children as $key => $child): 
				$link = JRoute::_(JE_ProductHelperRoute::getCategoryRoute($child->id));
			?>
			<li <?php if ( ($key + 1) % 3 == 0) echo 'class="last"'?>>
				<div class="home-text">
					<a class="images" href="<?php echo $link; ?>">
						
						<?php
							$params = $child->getParams();
							$image = $params->get('image');
			
							if ($image):
						?>
							<img src="<?php echo $image; ?>" />
						<?php endif; ?>
						
						<?php echo $child->title; ?>
					</a>
				</div>
				
				<div class="clr"></div>
				
			</li>
			<?php endforeach; ?>
		</ul>
		
		<div class="clr"></div>
	
		<?php else: ?>
		
		<ul class="latest-list-images list-items fltlft">
			<?php foreach ($items as $key => $item): ?>
			<li <?php if ( ($key + 1) % 3 == 0) echo 'class="last"'?>>
				<div class="padding-10">
					<?php 
					require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';
	
					$pathUpload = JPATH_ROOT . DS . PATH_TO_IMAGE;
					$pathThumb = JPATH_ROOT . DS . 'images/je_products/thumbs/' . THUMB_WIDTH_LIST . DS;
	
					$thumb = JEUtil::thumb($item->images, $pathUpload, $pathThumb, THUMB_WIDTH_LIST, THUMB_HEIGHT_LIST);
					
					$link = JRoute::_(JE_ProductHelperRoute::getDetailRoute($item->id, $item->catid, $item->alias));
					?>
					<h3>
						<a title="<?php echo $item->name; ?>" href="<?php echo $link; ?>">
							<?php echo $item->name; ?>
						</a>
					</h3>

					<a title="<?php echo $item->name; ?>" href="<?php echo $link; ?>">
						<span class="img"> <img alt="<?php echo $item->alias; ?>"
							src="images/je_products/thumbs/<?php echo THUMB_WIDTH_LIST . '/' . @$thumb[0]; ?>">
					</span>
					</a>
					<p>Giá bán: <?php echo number_format($item->promotion_price); ?> đ</p>
					<a class="btn fancybox fancybox.iframe" href="<?php echo JRoute::_('index.php?option=com_je_product&task=shopping_cart.add&id=' . $item->id, false); ?>">Mua ngay</a>
				</div>
			</li>
			<?php endforeach; ?>
			<?php if (empty($items)): ?>
			<li>Danh sách sản phẩm đang được cập nhật!</li>
			<?php endif; ?>
		</ul>
		
		<div class="clr"></div>

		<div class="pagination">
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
		
		<?php endif; ?>
	</div>
</div>
<div class="clr"></div>