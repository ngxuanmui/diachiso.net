<?php
/**
 * @version		$Id: view.html.php 21677 2011-06-25 20:56:56Z chdemko $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML Contact View class for the Contact component
 *
 * @package		Joomla.Site
 * @subpackage	com_je_product
 * @since 		1.5
 */
class JE_ProductViewPosts extends JView
{
	protected $items;
	protected $pagination;
	
	function display($tpl = null)
	{
		if(!JFactory::getUser()->id)
		{
			JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_users&view=login'), 'Bạn cần phải đăng nhập trước.');
			return false;
		}
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		
	}
}
