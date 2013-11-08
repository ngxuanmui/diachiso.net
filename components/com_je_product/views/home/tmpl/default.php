<?php
// no direct access
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.application.module.helper' );

$items = $this->items;
$promotion_items = $this->promotion_items;

// always load modal
?>

<div class="rt-grid-6 rt-alpha">
	<div class="rt-block">

		<div class="k2ItemsBlock">

			<ul class="article">
				<li class="even lastItem firstItem">

					<div class="moduleItemIntrotext">
						<a class="moduleItemImage"
							href="/joomla_40404/index.php/component/k2/item/7-welcome"
							title="Continue reading &quot;Welcome!&quot;"> <img
							src="<?php echo JURI::base().'/templates/diachiso/images/sample/9caa2793658f3cc387f216157300b1ce_M.jpg'; ?>"
							alt="Welcome!">
						</a> <a class="moduleItemTitle"
							href="/joomla_40404/index.php/component/k2/item/7-welcome">Welcome!</a>

						<p class="text">An overflowing portfolio of beautiful furnishings
							for you!</p>

						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed
							diam nonummy nibh euismod tincidunt ut laoreet dolore magna
							aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud
							exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea
							commodo consequat. Duis autem vel eum iriure dolorn hendrerit in
							vulputate velit esse molestie conse.</p>

					</div>


					<div class="clr"></div>


					<div class="clr"></div> <a class="moduleItemReadMore"
					href="/joomla_40404/index.php/component/k2/item/7-welcome"> Chi tiết </a>

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

			<div class="k2ItemsBlock tabs">



				<div id="tabs"
					class="ui-tabs ui-widget ui-widget-content ui-corner-all"
					style="height: auto; overflow: visible;">

					<ul
						class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
						<li
							class="firstItem ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
							<a class="moduleTabTitle" href="#tab-0">Thông tin</a>
						</li>
						<li class="lastItem ui-state-default ui-corner-top"><a
							class="moduleTabTitle" href="#tab-2">Thương hiệu</a></li>
					</ul>



					<div id="tab-0"
						class="even ui-tabs-panel ui-widget-content ui-corner-bottom">


						<div class="moduleItemIntrotext">

							<ul class="news">
								<li class="firstItem"><img
									src="<?php echo JURI::base().'/templates/diachiso/images/sample/page1-img1.jpg'; ?>"
									alt="">
									<div class="overflow">
										<span class="date">12-09-2012</span> <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="title">Nemo enim ipsam voluptatem quia voluptas</a><br>
										Lorem ipsum dolor sit amet, consectetuer adipi ing elit, sed
										diam nonummy. <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="more">Read More</a>
									</div></li>
								<li><img
									src="<?php echo JURI::base().'/templates/diachiso/images/sample/page1-img2.jpg'; ?>"
									alt="">
									<div class="overflow">
										<span class="date">12-09-2012</span> <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="title">Aliquam dapibus tincidunt metu esent justo</a><br>
										Lorem ipsum dolor sit amet, consectetuer adipi ing elit, sed
										diam nonummy. <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="more">Read More</a>
									</div></li>
								<li class="lastItem"><img
									src="<?php echo JURI::base().'/templates/diachiso/images/sample/page1-img3.jpg'; ?>"
									alt="">
									<div class="overflow">
										<span class="date">12-09-2012</span> <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="title">Nemo enim ipsam voluptatem quia voluptas</a><br>
										Lorem ipsum dolor sit amet, consectetuer adipi ing elit, sed
										diam nonummy. <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="more">Read More</a>
									</div></li>
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
										Lorem ipsum dolor sit amet, consectetuer adipi ing elit, sed
										diam nonummy. <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="more">Read More</a>
									</div></li>
								<li><img src="/joomla_40404/images/stories/page1-img1.jpg"
									alt="">
									<div class="overflow">
										<span class="date">12-09-2012</span> <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="title">Aliquam dapibus tincidunt metu esent justo</a><br>
										Lorem ipsum dolor sit amet, consectetuer adipi ing elit, sed
										diam nonummy. <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="more">Read More</a>
									</div></li>
								<li class="lastItem"><img
									src="/joomla_40404/images/stories/page1-img2.jpg" alt="">
									<div class="overflow">
										<span class="date">12-09-2012</span> <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="title">Nemo enim ipsam voluptatem quia voluptas</a><br>
										Lorem ipsum dolor sit amet, consectetuer adipi ing elit, sed
										diam nonummy. <a
											href="/joomla_40404/index.php/blog/item/67-lorem-ipsum-dolor-sit-amet"
											class="more">Read More</a>
									</div></li>
							</ul>

						</div>


						<div class="clr"></div>


						<div class="moduleItemIntrotext">

							<ul class="news">
								<li class="firstItem">
									<blockquote>
										<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut
											odit aut fugit, sed quia consequuntur magni dolores eos qui.</p>
									</blockquote> <span class="extra_info_name">John Franklin</span>
									<span class="extra_info_about">Managing Director</span> <span
									class="extra_info_website"><a target="_blank"
										href="http://www.demolink.org">www.demolink.org</a> </span>
								</li>
								<li>
									<blockquote>
										<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut
											odit aut fugit, sed quia consequuntur magni dolores eos qui.</p>
									</blockquote> <span class="extra_info_name">Mark Jordan</span>
									<span class="extra_info_about">President</span> <span
									class="extra_info_website"><a target="_blank"
										href="http://www.demolink.org">www.demolink.org</a> </span>
								</li>
								<li class="lastItem">
									<blockquote>
										<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut
											odit aut fugit, sed quia consequuntur magni dolores eos qui.</p>
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


<div class="clr"></div>
