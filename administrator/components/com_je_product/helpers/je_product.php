<?php
/**
 * @version		$Id: banners.php 17244 2010-05-25 01:07:44Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class je_productHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
		$ext = JRequest::getString('extension');
		
		JSubMenuHelper::addEntry(
			JText::_('COM_JE_PRODUCT_SUBMENU_PRODUCTS'),
			'index.php?option=com_je_product&view=products',
			($vName == 'products')
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_JE_PRODUCT_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_je_product',
			$vName == 'categories'
		);
		
		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE',JText::_('Products Categories')),
				'banners-categories');
		}
		
		JSubMenuHelper::addEntry(
			JText::_('Brands'),
			'index.php?option=com_je_product&view=brands',
			($vName == 'brands')
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Providers'),
			'index.php?option=com_je_product&view=providers',
			($vName == 'providers')
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Nationals'),
			'index.php?option=com_categories&extension=com_je_product.national',
			$ext == 'com_je_product.national'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('Provinces'),
			'index.php?option=com_categories&extension=com_je_product.province',
			$ext == 'com_je_product.province'
		);
	}
	
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_je_product';
		} else {
			$assetName = 'com_je_product.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}