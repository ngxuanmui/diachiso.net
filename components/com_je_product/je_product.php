<?php
/**
 * @version		$Id: contact.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

define('PATH_TO_IMAGE', 'images/je_products/upload/');
define('THUMB_WIDTH_LIST', 230);
define('THUMB_HEIGHT_LIST', 230);
define('THUMB_WIDTH', 400);

define('NEW_THUMB_WIDTH', 50);

require_once JPATH_COMPONENT.'/helpers/route.php';
jimport('joomla.application.component.controller');

// add cart helper
require_once JPATH_ROOT . DS . 'jelibs' . DS . 'classes' . DS . 'shopping_basket.class.php';

$controller = JController::getInstance('JE_Product');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
