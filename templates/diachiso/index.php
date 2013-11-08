<?php
/**
 * @package                Joomla.Site
 * @subpackage	Templates.beez_20
 * @copyright        Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license                GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');

// Remove Mootools
$this->_script = $this->_scripts = array();

// check modules
// JHtml::_('behavior.framework', true);

// get params
$app				= JFactory::getApplication();
$doc				= JFactory::getDocument();

$doc->addStyleSheet($this->baseurl.'/templates/system/css/system.css');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/position.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/layout.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/template.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/print.css', $type = 'text/css', $media = 'print');

/* jquery */
$doc->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', 'text/javascript');

$bxSliderPath = JURI::root() . 'media/website/jquery.bxslider';

$doc->addStyleSheet($bxSliderPath.'/jquery.bxslider.css');
$doc->addScript($bxSliderPath . '/jquery.bxslider.min.js', 'text/javascript');

$files = JHtml::_('stylesheet', 'templates/'.$this->template.'/css/general.css', null, false, true);
if ($files):
	if (!is_array($files)):
		$files = array($files);
	endif;
	foreach($files as $file):
		$doc->addStyleSheet($file);
	endforeach;
endif;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xml:lang="<?php echo $this->language; ?>"
	lang="<?php echo $this->language; ?>"
	dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />

<!--[if IE 7]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
<![endif]-->

<script type="text/javascript">
<!--
jQuery.noConflict();

var BASE_URL = '<?php echo JURI::base(); ?>';

//-->
</script>

</head>

<body>

	<div class="container">
		<div id="rt-top">
			<div class="rt-container">
				<div class="rt-grid-12 rt-alpha rt-omega">
					<div class="rt-block">
						<ul class="menu-user">
							<li id="item-169" class="firstItem"><a
								href="/joomla_40404/index.php/login"><span>Login</span> </a></li>
							<li id="item-170" class="lastItem"><a
								href="/joomla_40404/index.php/register"><span>Register</span> </a>
							</li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div id="rt-header">
			<div class="rt-container">
				<div class="rt-grid-4 rt-alpha">
					<div class="rt-block">
						<a href="/joomla_40404/" id="rt-logo"></a>
					</div>

				</div>
				
				<jdoc:include type="modules" name="je-top-menu" style="none" />
				
				<div class="clear"></div>
			</div>
		</div>

	<?php if ($this->countModules('featured-banner')): ?>
		<div id="rt-showcase">
			<div class="showcase">
				<div class="rt-container homepage">
					<div class="rt-grid-12 rt-alpha rt-omega">
						<div class="rt-block">
							<jdoc:include type="modules" name="featured-banner" style="none" />
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
		<!--
		jQuery(function($){
			$('ul#featured-banner').bxSlider({
				mode: 'fade',
				auto: true,
				autoControls: false,
				pause: 20000,
				autoHover: true,
				pager: false
			});
		});
		//-->
		</script>
	
	<?php endif; ?>
	
	<?php if ($this->countModules('featured-banner')): ?>
		<jdoc:include type="modules" name="featured-brand" style="none" />
	<?php endif; ?>

		<div id="rt-maintop">
			<div class="rt-container">

				<div id="breadcrumbs">
					<jdoc:include type="modules" name="position-2" />
				</div>

				<jdoc:include type="component" />

				<div class="clear"></div>
			</div>
		</div>
		<div id="rt-breadcrumbs">
			<div class="bread-top-bg">
				<div class="bread-bottom-bg">
					<div class="rt-container">
						<div class="rt-grid-12 rt-alpha rt-omega">
							<div class="jcarousel">
								<div class="rt-block">
									<div class="module-title">
										<h2 class="title">Sản phẩm mới</h2>
									</div>

									<div id="k2ModuleBox93" class="k2ItemsBlock jcarousel">

										<div
											class="jcarousel-container jcarousel-container-horizontal"
											style="position: relative; display: block;">
											<div class="jcarousel-clip jcarousel-clip-horizontal"
												style="position: relative;">
												<ul id="jcarousel"
													class="jcarousel-list jcarousel-list-horizontal"
													style="overflow: hidden; position: relative; top: 0px; margin: 0px; padding: 0px; left: 0px; width: 952px;">

													<li
														class="even firstItem jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal"
														jcarouselindex="1"
														style="float: left; list-style: none; width: 217px;">


														<div class="moduleItemIntrotext relative">
															<a class="moduleItemImage"
																href="/joomla_40404/index.php/component/k2/item/43-workspace"
																title="Continue reading &quot;workspace&quot;"> <img
																src="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/sample/8b6e33345ac8d5ffd9cf0d107a7d9e9d_XS.jpg'; ?>"
																alt="workspace">
															</a>

															<h3 class="CarouselTitle">
																<a class="moduleItemTitle"
																	href="/joomla_40404/index.php/component/k2/item/43-workspace"><span>workspace</span>
																</a>
															</h3>

														</div>
														<div class="clr"></div>
													</li>

													<li
														class="even firstItem jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal"
														jcarouselindex="1"
														style="float: left; list-style: none; width: 217px;">


														<div class="moduleItemIntrotext relative">
															<a class="moduleItemImage"
																href="/joomla_40404/index.php/component/k2/item/43-workspace"
																title="Continue reading &quot;workspace&quot;"> <img
																src="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/sample/8b6e33345ac8d5ffd9cf0d107a7d9e9d_XS.jpg'; ?>"
																alt="workspace">
															</a>

															<h3 class="CarouselTitle">
																<a class="moduleItemTitle"
																	href="/joomla_40404/index.php/component/k2/item/43-workspace"><span>workspace</span>
																</a>
															</h3>

														</div>
														<div class="clr"></div>
													</li>

													<li
														class="even firstItem jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal"
														jcarouselindex="1"
														style="float: left; list-style: none; width: 217px;">


														<div class="moduleItemIntrotext relative">
															<a class="moduleItemImage"
																href="/joomla_40404/index.php/component/k2/item/43-workspace"
																title="Continue reading &quot;workspace&quot;"> <img
																src="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/sample/8b6e33345ac8d5ffd9cf0d107a7d9e9d_XS.jpg'; ?>"
																alt="workspace">
															</a>

															<h3 class="CarouselTitle">
																<a class="moduleItemTitle"
																	href="/joomla_40404/index.php/component/k2/item/43-workspace"><span>workspace</span>
																</a>
															</h3>

														</div>
														<div class="clr"></div>
													</li>

													<li
														class="even firstItem jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal"
														jcarouselindex="1"
														style="float: left; list-style: none; width: 217px;">


														<div class="moduleItemIntrotext relative">
															<a class="moduleItemImage"
																href="/joomla_40404/index.php/component/k2/item/43-workspace"
																title="Continue reading &quot;workspace&quot;"> <img
																src="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/sample/8b6e33345ac8d5ffd9cf0d107a7d9e9d_XS.jpg'; ?>"
																alt="workspace">
															</a>

															<h3 class="CarouselTitle">
																<a class="moduleItemTitle"
																	href="/joomla_40404/index.php/component/k2/item/43-workspace"><span>workspace</span>
																</a>
															</h3>

														</div>
														<div class="clr"></div>
													</li>
												</ul>
											</div>
											<div class="jcarousel-prev jcarousel-prev-horizontal"
												style="display: block;"></div>
											<div class="jcarousel-next jcarousel-next-horizontal"
												style="display: block;"></div>
										</div>


									</div>
								</div>
							</div>

						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>

		<div id="rt-main" class="mb12">
			<div class="rt-container">
				<div class="rt-grid-12 fltlft">
					<div class="rt-block">
						<div id="rt-mainbody">
							<div class="catItemIntroText">
								<ul class="social">
									<li class="firstItem"><a href="#">facebook</a></li>
									<li><a href="#">linkedin</a></li>
									<li class="lastItem"><a href="#">flickr</a></li>
								</ul>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div id="footer">
			<div class="footer-container">
				<div id="rt-copyright">
					<div class="rt-container">
						<div class="rt-grid-12 rt-alpha rt-omega">
							<div class="clear"></div>
							<div class="rt-block">
								<p class="copyright">
									<span class="sitename">MF Modern Furniture </span>©<span
										class="date"> 2013</span><span class="footerText"></span> <a
										href="/joomla_40404/index.php/privacy-policy">Privacy Policy</a>
								</p>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
