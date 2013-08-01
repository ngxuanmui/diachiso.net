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

require_once JPATH_COMPONENT.'/helpers/route.php';
jimport('joomla.application.component.controller');

$controller = JController::getInstance('JE_Product');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
