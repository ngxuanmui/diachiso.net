<?php
// No direct access
defined('_JEXEC') or die;
$item = $this->item;

define('THUMB_WIDTH', 750);
define('THUMB_HEIGHT', 750);
?>

<?php 
require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';

$file 		= JPATH_ROOT . DS . 'images/je_products/upload/' . $item->images;
$thumbFile 	= JPATH_ROOT . DS . 'images/je_products/detail/' . $item->images;

JEUtil::resizeImage($file, $thumbFile, THUMB_WIDTH, THUMB_HEIGHT);
?>

<div class="box-header">
	<?php echo $item->location_name; ?>: <?php echo $item->name;?>
</div>

<div id="promotion-detail">
	<div class="text-center">
		<img alt="Promotion Image" src="images/je_products/detail/<?php echo $item->images; ?>">
	</div>
	
	<div class="clr"></div>
	
	<div class="description">
		<?php echo $item->description; ?>
	</div>
</div>

<?php 
	$jeComments = JPATH_SITE . DS . 'components' . DS . 'com_je_comment' . DS . 'je_comment.php';

	if(file_exists($jeComments))
	{
		require_once $jeComments;
		Je_Comment::display(JRequest::getVar('id'), 'com_je_product', $item->name);
	}
?>