<?php
// No direct access
defined('_JEXEC') or die;
$item = $this->item;
?>

<?php 
require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';

/*
$file 		= JPATH_ROOT . DS . 'images/je_products/upload/' . $item->images;
$thumbFile 	= JPATH_ROOT . DS . 'images/je_products/detail/' . $item->images;

JEUtil::resizeImage($file, $thumbFile, THUMB_WIDTH, null, false);
*/
$pathUpload = JPATH_ROOT . DS . 'images/je_products/upload/';
$pathThumb = JPATH_ROOT . DS . 'images/je_products/thumbs/';
$pathDetailThumb = JPATH_ROOT . DS . 'images/je_products/detail/';

$thumb = JEUtil::thumb($item->images, $pathUpload, $pathThumb . DS . NEW_THUMB_WIDTH . DS, NEW_THUMB_WIDTH, null, false);

//make image detail
$detailImages = JEUtil::thumb($item->images, $pathUpload, $pathDetailThumb . DS . THUMB_WIDTH . DS, THUMB_WIDTH, null, false);

// var_dump($thumb);
?>

<script type="text/javascript">
<!--
jQuery(function($){
	$('.thumb').click(function(){
		var rel = $(this).attr('rel');

		$('.img-detail').addClass('display-none');

		var imgDetail = rel.replace('thumb', 'detail');

		$('img[rel="'+imgDetail+'"]').removeClass('display-none');
	});
});
//-->
</script>

<div class="view-product">
	<div class="left fltlft span5">
		<div class="detail-image">
			<div id="product-image">
				<?php foreach ($detailImages as $key => $img): ?>
				<img rel="detail-<?php echo $key; ?>" alt="<?php echo $item->alias; ?>" src="images/je_products/detail/<?php echo THUMB_WIDTH . '/' . $img; ?>" class="img-detail <?php if ($key > 0) echo 'display-none'; ?>" />
				<?php endforeach; ?>
			</div>
			
			<?php foreach ($thumb as $key => $img): ?>
			<img rel="thumb-<?php echo $key; ?>" class="thumb border" alt="<?php echo $item->alias; ?>" src="images/je_products/thumbs/<?php echo NEW_THUMB_WIDTH . '/' . $img; ?>" />
			<?php endforeach; ?>
		</div>
	</div>
	
	<div class="right fltrgt span7">
		
		<div class="content">
		
			<h1><?php echo $item->name;?></h1>
			
			<p><strong>Giá cũ</strong>: <strike><?php echo number_format($item->price); ?></strike> đ</p>
			<p class="price"><?php echo number_format($item->promotion_price); ?> đ</p>
			
			<p>Chủ đề: <?php echo $item->category_title; ?></p>
			
			<div class="note-active">
				<?php if($item->note): ?>
				<?php echo nl2br($item->note); ?>
				<?php endif; ?>
			</div>
			
			<a href="#" class="btn">Mua ngay</a>
			
		</div>
	</div>
	
	<div class="clr"></div>
	
	<div class="content">
		<div class="description">
			<?php echo $item->description; ?>
		</div>
		
		<div class="note">
			<h3>Ghi chú</h3>

			<ul>
				<li>
					- Giá chưa gồm VAT, phí chuyển phát ngoài khu vực miễn phí.
				</li>
				<li>
					- Cộng thêm phụ phí cho đơn hàng hoa giao ngoài Hà Nội. 
				</li>
				<li>
					- Hình ảnh mẫu trên website có sự khác biệt chút ít về màu sắc và cảm nhận so với 
					sản phẩm được giao thực tế, do đặc thù hoa tươi phụ thuộc vào mùa, 
					khí hậu và thời tiết. Khi không có loại hoa, hoặc bình theo mẫu vào lúc thực hiện đơn hàng, 
					hoathuyanh.vn sẽ liên lạc với quý khách để thông báo và tư vấn giải pháp; trường hợp 
					không liên lạc được, hoặc do thời gian không cho phép, hoathuyanh.vn sẽ chủ động thay thể 
					bằng một loại hoa khác có ý nghĩa và màu sắc tương tự.
				</li>
			</ul>
		</div>
	</div>
	
	<div class="grid_6 last">
		
		<?php /*if(!empty($this->otherProducts)): ?>
		<div class="box-header">Thông tin khác</div>
		
		<ul class="other-product">
			<?php foreach ($this->otherProducts as $i => $item): ?>
			<li>
				<?php 
				require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';
				
				$file 		= JPATH_ROOT . DS . 'images/je_products/upload/' . $item->images;
				$thumbFile 	= JPATH_ROOT . DS . 'images/je_products/thumbs/thumb_' . $item->images;
				
				JEUtil::resizeImage($file, $thumbFile);
				
				$pathUpload = JPATH_ROOT . DS . 'images/je_products/upload/';
				$pathThumb = JPATH_ROOT . DS . 'images/je_products/thumbs/';
				
				$thumb = JEUtil::thumb($item->images, $pathUpload, $pathThumb, 220, 60);
				
				?>
				
				<a title="<?php echo $item->name; ?>" href="<?php echo JRoute::_('index.php?option=com_je_product&view=detail&id='. $item->id.':'.$item->alias); ?>">
					<img alt="<?php echo $item->alias; ?>" src="images/je_products/thumbs/<?php echo @$thumb[0]; ?>">
					<?php echo $item->name;?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		
		<?php endif;*/ ?>
	</div>
</div>

<div class="clr"></div>