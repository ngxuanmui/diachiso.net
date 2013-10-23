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
class JE_ProductViewShopping_Cart extends JViewLegacy
{
	protected $item;
	
	function display($tpl = null)
	{
		$this->item = $this->get('Item');
		
		if(!$this->item)
			return;
		
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
