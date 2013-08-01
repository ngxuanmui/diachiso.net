<?php
// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.module.helper');
?>

<div class="box-header margin-top-20 margin-bottom-10">Mới khuyến mại</div>

<div id="lastest-slider">
	<?php 
	$modules = JModuleHelper::getModules('latest-home-1'); 
	foreach($modules as $module)
		echo JModuleHelper::renderModule($module);
	?>
</div>

<div class="clr"></div>

<div class="box-header margin-top-20 margin-bottom-10">Đang khuyến mại</div>

<div id="lastest-list-image">
	<?php 
	$modules = JModuleHelper::getModules('latest-home-2'); 
	foreach($modules as $module)
		echo JModuleHelper::renderModule($module);
	?>
</div>

<div id="lastest-list-title">
	<?php 
	$modules = JModuleHelper::getModules('latest-home-3'); 
	foreach($modules as $module)
		echo JModuleHelper::renderModule($module);
	?>
</div>