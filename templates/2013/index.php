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

// check modules

JHtml::_('behavior.framework', true);

// get params
$app				= JFactory::getApplication();
$doc				= JFactory::getDocument();

$doc->addStyleSheet($this->baseurl.'/templates/system/css/system.css');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/position.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/layout.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/template.css', $type = 'text/css', $media = 'screen,projection');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/print.css', $type = 'text/css', $media = 'print');

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

</head>

<body>
	<div class="container margin-auto relative">
		<div id="header" class="span12">
			<a id="logo" class="absolute" href="<?php echo JURI::base(); ?>" title="Diachiso.net"></a>
		</div>
		
		<div class="clr"></div>
		
		<div class="span12">
			<ul class="top-menu sf-container sf-menu">
				<li><a href="#">Du lịch trong nước<em></em></a></li>
				<li><a href="#">Làng nghề</a></li>
				<li><a href="#">Điểm đến hấp dẫn</a></li>
			</ul>
		</div>
		
		<jdoc:include type="message" />
		<jdoc:include type="component" />
		<jdoc:include type="modules" name="debug" />
		
		<div class="clr"></div>
	</div>
	
	<div class="sf-main-bg"></div>
		
</body>
</html>
