<?php
/**
 * @version		$Id: view.html.php 18586 2010-08-22 20:11:14Z ian $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of products.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_products
 * @since		1.6
 */
class je_productViewProducts extends JView
{
	protected $categories;
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$this->categories	= $this->get('CategoryOrders');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/je_product.php';

		$canDo	= je_productHelper::getActions($this->state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_JE_PRODUCT_MANAGER'), 'products.png');
		
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('product.add','JTOOLBAR_NEW');
		}
		
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('product.edit','JTOOLBAR_EDIT');
		}
		
		if ($canDo->get('core.edit.state')) {
			if ($this->state->get('filter.state') != 2){
				JToolBarHelper::divider();
				JToolBarHelper::custom('products.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('products.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			if ($this->state->get('filter.state') != -1 ) {
				JToolBarHelper::divider();
				if ($this->state->get('filter.state') != 2) {
					JToolBarHelper::archiveList('products.archive','JTOOLBAR_ARCHIVE');
				}
				else if ($this->state->get('filter.state') == 2) {
					JToolBarHelper::unarchiveList('products.publish', 'JTOOLBAR_UNARCHIVE');
				}
			}
		}
		
		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::custom('products.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}
		
		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'products.delete','JTOOLBAR_EMPTY_TRASH');
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('products.trash','JTOOLBAR_TRASH');
		}
		
	}
}
