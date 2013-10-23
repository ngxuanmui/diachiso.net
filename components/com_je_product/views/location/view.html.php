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
class JE_ProductViewCategory extends JView
{
	protected $items;
	protected $pagination;
	protected $categoryInfo;
	
	function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->categoryInfo= $this->get('CategoryInfo');
		
		if(!$this->items)
			return;
		
		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$category = $this->categoryInfo;
		
		$document = JFactory::getDocument();
		
		$document->setDescription($category->metadesc);
		$document->setMetaData('keywords', $category->metakey);
	}
}
