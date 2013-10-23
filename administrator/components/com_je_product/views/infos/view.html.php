<?php
/**
 * @version		$Id: view.html.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of infos.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @since		1.6
 */
class JE_ProductViewInfos extends JView
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

		$canDo	= JE_ProductHelper::getActions($this->state->get('filter.category_id'));

		$session = JFactory::getSession();
		
		$type = $session->get('filter_type');
		
		JToolBarHelper::title(JText::_('Manager Location'), 'Infos.png');
			
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('info.add','JTOOLBAR_NEW');
		}

		if (($canDo->get('core.edit'))) {
			JToolBarHelper::editList('info.edit','JTOOLBAR_EDIT');
		}

		if ($canDo->get('core.edit.state')) {
			if ($this->state->get('filter.state') != 2){
				JToolBarHelper::divider();
				JToolBarHelper::custom('infos.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('infos.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}

			if ($this->state->get('filter.state') != -1 ) {
				JToolBarHelper::divider();
				if ($this->state->get('filter.state') != 2) {
					JToolBarHelper::archiveList('infos.archive','JTOOLBAR_ARCHIVE');
				}
				else if ($this->state->get('filter.state') == 2) {
					JToolBarHelper::unarchiveList('infos.publish', 'JTOOLBAR_UNARCHIVE');
				}
			}
		}

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::custom('infos.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
		}

		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'infos.delete','JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('infos.trash','JTOOLBAR_TRASH');
			JToolBarHelper::divider();
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_je_product');
		}
	}
}
