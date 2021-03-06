<?php
/**
 * @version		$Id: controller.php $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		muinx
 * This component was generated by http://joomlavietnam.net/ - 2012
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * JE_Content master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_content
 * @since		1.6
 */
class JE_ContentController extends JControllerLegacy
{
	public $default_view = 'articles';
	
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/je_content.php';

		// Load the submenu.
		JE_ContentHelper::addSubmenu(JRequest::getCmd('view', 'articles'));

		parent::display();

		return $this;
	}
}
