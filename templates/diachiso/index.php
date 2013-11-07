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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />

<!--[if IE 7]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
<![endif]-->

<script type="text/javascript">
<!--
jQuery.noConflict();

var BASE_URL = '<?php echo JURI::base(); ?>';

jQuery(function($){
	
	  $('li.f-mainparent-item').hover(function () {
	     clearTimeout($.data(this, 'timer'));
	     $('ul', this).stop(true, true).slideDown(0);
// 	     $('ul.menutop li').removeClass('active');
// 	     $(this).addClass('active');
	  }, function () {
	    $.data(this, 'timer', setTimeout($.proxy(function() {
	      $('ul', this).stop(true, true).slideUp(0);
// 	      $('ul.menutop li').removeClass('active');
// 	      $('ul.menutop').find('li.current_active').addClass('active');
	      
	    }, this), 200));
	  });
	});

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
			<div class="rt-grid-8 rt-omega">
				<div class="rt-fusionmenu">
					<div class="nopill">
						<div class="rt-menubar">
							<ul class="menutop level1 ">
								<li class="item101 active current_active root firstItem"><a
									class="orphan item bullet"
									href="http://livedemo00.template-help.com/joomla_40404/"
									id="a-1382344374540159"> <span> Home </span>
								</a>
								</li>
								<li class="item116 root"><a class="orphan item bullet"
									href="/joomla_40404/index.php/about" id="a-1382344374542202"> <span>
											About </span>
								</a>
								</li>
								<li class="item118 parent root f-main-parent f-mainparent-item relative">
									<span class="daddy item bullet nolink"
									id="span-1382344374542206"> <span> Danh mục </span>
								</span>
								
									<ul class='show-category absolute'>
										<li>
											Test
										</li>
										<li>
											Test 1
										</li>
									</ul>


								</li>
								<li class="item117 root"><a class="orphan item bullet"
									href="/joomla_40404/index.php/blog" id="a-1382344374548703"> <span>
											Blog </span>
								</a>
								</li>
								<li class="item114 root lastItem"><a class="orphan item bullet"
									href="/joomla_40404/index.php/mail" id="a-1382344374549304"> <span>
											Mail </span>
								</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>

	<?php if ($this->countModules('kfeatured-banner')): ?>
	<div id="rt-showcase">
		<div class="showcase">
			<div class="rt-container homepage">
				<div class="rt-grid-12 rt-alpha rt-omega">
					<div class="rt-block">
						<jdoc:include type="modules" name="featured-banner" style="none"  />
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
			pause: 2000,
			autoHover: true,
			pager: false
		});
	});
	//-->
	</script>
	
	<?php endif; ?>

		<div id="rt-maintop">
			<div class="rt-container">
				<div class="rt-grid-6 rt-alpha">
					<div class="rt-block">

						<div id="k2ModuleBox110" class="k2ItemsBlock">


							<ul class="article">
								<li class="even lastItem firstItem">

									<div class="moduleItemIntrotext">
										<a class="moduleItemImage"
											href="/joomla_40404/index.php/component/k2/item/7-welcome"
											title="Continue reading &quot;Welcome!&quot;"> <img
											src="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/sample/9caa2793658f3cc387f216157300b1ce_M.jpg'; ?>"
											alt="Welcome!">
										</a> <a class="moduleItemTitle"
											href="/joomla_40404/index.php/component/k2/item/7-welcome">Welcome!</a>

										<p class="text">An overflowing portfolio of beautiful
											furnishings for you!</p>

										<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
											sed diam nonummy nibh euismod tincidunt ut laoreet dolore
											magna aliquam erat volutpat. Ut wisi enim ad minim veniam,
											quis nostrud exerci tation ullamcorper suscipit lobortis nisl
											ut aliquip ex ea commodo consequat. Duis autem vel eum iriure
											dolorn hendrerit in vulputate velit esse molestie conse.</p>

									</div>


									<div class="clr"></div>


									<div class="clr"></div> <a class="moduleItemReadMore"
									href="/joomla_40404/index.php/component/k2/item/7-welcome">
										More </a>

									<div class="clr"></div>
								</li>
								<li class="clearList lastItem"></li>
							</ul>



						</div>
					</div>

				</div>
				<div class="rt-grid-6 rt-omega">
					<div class="tabs">
						<div class="rt-block">

							<div id="k2ModuleBox94" class="k2ItemsBlock tabs">



								<div id="tabs"
									class="ui-tabs ui-widget ui-widget-content ui-corner-all"
									style="height: auto; overflow: visible;">

									<ul
										class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
										<li
											class="firstItem ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
											<a class="moduleTabTitle" href="#tab-0">Latest News</a>
										</li>
										<li class="ui-state-default ui-corner-top"><a
											class="moduleTabTitle" href="#tab-1">Recent News</a>
										</li>
										<li class="lastItem ui-state-default ui-corner-top"><a
											class="moduleTabTitle" href="#tab-2">Comments</a>
										</li>
									</ul>



									<div id="tab-0"
										class="even ui-tabs-panel ui-widget-content ui-corner-bottom">


										<div class="moduleItemIntrotext">

											<ul class="news">
												<li class="firstItem"><img
													src="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/sample/page1-img1.jpg'; ?>"
													alt="">
													<div class="overflow">
														<span class="date">12-09-2012</span> <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="title">Nemo enim ipsam voluptatem quia voluptas</a><br>
														Lorem ipsum dolor sit amet, consectetuer adipi ing elit,
														sed diam nonummy. <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="more">Read More</a>
													</div>
												</li>
												<li><img
													src="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/sample/page1-img2.jpg'; ?>"
													alt="">
													<div class="overflow">
														<span class="date">12-09-2012</span> <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="title">Aliquam dapibus tincidunt metu esent justo</a><br>
														Lorem ipsum dolor sit amet, consectetuer adipi ing elit,
														sed diam nonummy. <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="more">Read More</a>
													</div>
												</li>
												<li class="lastItem"><img
													src="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/sample/page1-img3.jpg'; ?>"
													alt="">
													<div class="overflow">
														<span class="date">12-09-2012</span> <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="title">Nemo enim ipsam voluptatem quia voluptas</a><br>
														Lorem ipsum dolor sit amet, consectetuer adipi ing elit,
														sed diam nonummy. <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="more">Read More</a>
													</div>
												</li>
											</ul>

										</div>


										<div class="clr"></div>
									</div>
									<div id="tab-1"
										class="odd ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">



										<div class="moduleItemIntrotext">

											<ul class="news">
												<li class="firstItem"><img
													src="/joomla_40404/images/stories/page1-img3.jpg" alt="">
													<div class="overflow">
														<span class="date">12-09-2012</span> <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="title">Nemo enim ipsam voluptatem quia voluptas</a><br>
														Lorem ipsum dolor sit amet, consectetuer adipi ing elit,
														sed diam nonummy. <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="more">Read More</a>
													</div>
												</li>
												<li><img src="/joomla_40404/images/stories/page1-img1.jpg"
													alt="">
													<div class="overflow">
														<span class="date">12-09-2012</span> <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="title">Aliquam dapibus tincidunt metu esent justo</a><br>
														Lorem ipsum dolor sit amet, consectetuer adipi ing elit,
														sed diam nonummy. <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="more">Read More</a>
													</div>
												</li>
												<li class="lastItem"><img
													src="/joomla_40404/images/stories/page1-img2.jpg" alt="">
													<div class="overflow">
														<span class="date">12-09-2012</span> <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="title">Nemo enim ipsam voluptatem quia voluptas</a><br>
														Lorem ipsum dolor sit amet, consectetuer adipi ing elit,
														sed diam nonummy. <a
															href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
															class="more">Read More</a>
													</div>
												</li>
											</ul>

										</div>


										<div class="clr"></div>


										<div class="moduleItemIntrotext">

											<ul class="news">
												<li class="firstItem">
													<blockquote>
														<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur
															aut odit aut fugit, sed quia consequuntur magni dolores
															eos qui.</p>
													</blockquote> <span class="extra_info_name">John Franklin</span>
													<span class="extra_info_about">Managing Director</span> <span
													class="extra_info_website"><a target="_blank"
														href="http://www.demolink.org">www.demolink.org</a> </span>
												</li>
												<li>
													<blockquote>
														<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur
															aut odit aut fugit, sed quia consequuntur magni dolores
															eos qui.</p>
													</blockquote> <span class="extra_info_name">Mark Jordan</span>
													<span class="extra_info_about">President</span> <span
													class="extra_info_website"><a target="_blank"
														href="http://www.demolink.org">www.demolink.org</a> </span>
												</li>
												<li class="lastItem">
													<blockquote>
														<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur
															aut odit aut fugit, sed quia consequuntur magni dolores
															eos qui.</p>
													</blockquote> <span class="extra_info_name">Emeli Prise</span>
													<span class="extra_info_about">Support Manager</span> <span
													class="extra_info_website"><a target="_blank"
														href="http://www.demolink.org">www.demolink.org</a> </span>
												</li>
											</ul>

										</div>


										<div class="clr"></div>
									</div>

								</div>



							</div>
						</div>
					</div>

				</div>
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
										<h2 class="title">Last added</h2>
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
											<div
												class="jcarousel-prev jcarousel-prev-horizontal"
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
								<p class="copyright"><span class="sitename">MF Modern Furniture </span>©<span class="date"> 2013</span><span class="footerText"></span> 
								<a href="/joomla_40404/index.php/privacy-policy">Privacy Policy</a></p>
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
