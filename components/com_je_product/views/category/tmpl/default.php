<?php
// No direct access
defined('_JEXEC') or die;
$items = $this->items;
$category = $this->category;

$children = $category->getChildren();

//var_dump($category);
?>

<div id="rt-main" class="mb12">
    <div class="rt-container">
	<div class="rt-grid-12 ">
	    <div class="rt-block">
		<div id="rt-mainbody">
		    <div class="component-content">

			<!-- Start K2 Category Layout -->
			<div class="TagCloudBlock">
			    <div id="portfoliosorting"
				 style="opacity: 1; visibility: visible;">
				<div class="sortbytype">
				    <a href="#" id="consulting" class="">consulting</a><a href="#"
											  id="technology" class="">technology</a><a href="#"
											  id="marketing" class="">marketing</a><a href="#" id="services"
											  class="">services</a> <a href="#" id="all"
											  class=" active_sort">All</a>
				</div>
			    </div>
			</div>
			<div id="container"
			     class="itemListView portfolio port" style="height: 988px;">

			    <!-- Page title -->
			    <div class="componentheading port">
				<h2>Services Overview</h2>
			    </div>

			    <!-- Item list -->
			    <div class="itemList portfolio-content">
				
				<?php foreach ($items as $key => $item): ?>
				
				<?php
				require_once JPATH_ROOT . DS . 'jelibs/classes/util.class.php';

				$pathUpload = JPATH_ROOT . DS . PATH_TO_IMAGE;
				$pathThumb = JPATH_ROOT . DS . 'images/je_products/thumbs/' . THUMB_WIDTH_LIST . DS;
				
				$thumb = '';

				//$thumb = JEUtil::thumb($item->images, $pathUpload, $pathThumb, THUMB_WIDTH_LIST, THUMB_HEIGHT_LIST);

				$link = JRoute::_(JE_ProductHelperRoute::getDetailRoute($item->id, @$item->catid, $item->alias));
				?>

				<div id="itemListSecondary" class="rows_4 fltleft <?php if (($key + 1) % 3 == 0) echo 'last' ?>">
				    <div class="portfolio-row rows_4">

					<div class="id-4 all one_third marketing technology rows_4 itemContainer itemContainerLast size_235">

					    <div class="catItemView groupSecondary port">
						<div class="catItemBody">

						    <!-- Item Image -->
						    <div class="catItemImageBlock">
							<span class="catItemImage"> 
							    <a title="<?php echo $item->name; ?>" href="<?php echo $link; ?>">
								<img alt="<?php echo $item->alias; ?>" src="images/je_products/thumbs/<?php echo THUMB_WIDTH_LIST . '/' . @$thumb[0]; ?>">
							    </a>
							</span>
							<div class="clr"></div>
						    </div>

						    <div class="overflow">
							<div class="catItemHeader">
							    <!-- Item title -->
							    <h3 class="catItemTitle"><?php echo $item->name; ?></h3>
							</div>

							<!-- Item introtext -->
							<div class="catItemIntroText">
							    <p>Ullam corporis suscipit laboriosam, nisi ut aliquid ex
								ea commodi consequatur. Quis autem vel eum iure
								reprehenderit qui in ea voluptate.</p>
							</div>
							<div class="clr"></div>
						    </div>
						</div>
						<div class="clr"></div>

					    </div>

					</div>
				    </div>
				</div>
				
				<?php endforeach; ?>
			    </div>

			</div>
			
			<div class="clear"></div>
			
		    </div>
		</div>
	    </div>
	</div>

	<div class="clear"></div>
    </div>
</div>

<div class="clr"></div>