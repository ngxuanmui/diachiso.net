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
 * View to edit a Info.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_carman
 * @since		1.5
 */
class JE_ProductViewProvider extends JView
{
	protected $form;
	protected $item;
	protected $state;
	protected $addresses;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

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
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo		= JE_ProductHelper::getActions($this->state->get('filter.category_id'));
		
		$session = JFactory::getSession();
		$type = $session->get('filter_type');
		
		JToolBarHelper::title($isNew ? JText::_('Provider Manager: New') : JText::_('Provider Manager: Edit'), 'banners.png');

		

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || $canDo->get('core.create'))) {
			JToolBarHelper::apply('provider.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('provider.save', 'JTOOLBAR_SAVE');

			if ($canDo->get('core.create')) {
				JToolBarHelper::custom('provider.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			}
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::custom('provider.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('provider.cancel','JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('provider.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
