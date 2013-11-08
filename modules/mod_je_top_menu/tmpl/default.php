<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_je_top_menu
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<div class="rt-grid-8 rt-omega">
	<div class="rt-fusionmenu">
		<div class="nopill">
			<div class="rt-menubar">
				<ul class="menutop level1 ">
					<li class="item101 active current_active root firstItem"><a
						class="orphan item bullet"
						href="http://livedemo00.template-help.com/joomla_40404/"
						id="a-1382344374540159"> <span> Home </span>
					</a></li>
					<li class="item116 root"><a class="orphan item bullet"
						href="/joomla_40404/index.php/about" id="a-1382344374542202"> <span>
								About </span>
					</a></li>
					<li
						class="item118 parent root f-main-parent f-mainparent-item relative">
						
						<span class="daddy item bullet nolink" id="span-1382344374542206">
							<span> Danh mục </span>
						</span>
						
						<?php
						echo JEUtil::renderModulesOnPosition(
									'je-categories-menu', 
									array()
								); 
						?>


					</li>
					<li class="item117 root"><a class="orphan item bullet"
						href="/joomla_40404/index.php/blog" id="a-1382344374548703"> <span>
								Blog </span>
					</a></li>
					<li class="item114 root lastItem"><a class="orphan item bullet"
						href="/joomla_40404/index.php/mail" id="a-1382344374549304"> <span>
								Mail </span>
					</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
<!--
jQuery(function($){
	$('li.f-mainparent-item').hover(function () {
			clearTimeout($.data(this, 'timer'));
			$('ul', this).stop(true, true).slideDown(0);
		}, function () {
			$.data(this, 'timer', setTimeout($.proxy(function() {
			$('ul', this).stop(true, true).slideUp(0);
		}, this), 200));
	});
});
//-->
</script>