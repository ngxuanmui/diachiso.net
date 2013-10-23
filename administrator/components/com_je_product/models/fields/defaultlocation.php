<?php
/**
 * @version		$Id: defaultlocation.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Bannerclient Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @since		1.6
 */
class JFormFieldDefaultLocation extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'DefaultLocation';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getOptions()
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		
		$id = JRequest::getVar('id');
		
		if(!$id)
		{
			//check if session item id exist (front)
			$session 	= JFactory::getSession();
			$id 	= $session->get('je_product.post.id', 		null);
			
			//get value
			$query = "SELECT * FROM #__je_products WHERE id = '$id'";
			$db->setQuery($query);
			
			$item = $db->loadObject();
			
			if(is_object($item))
				$this->value = $item->location;
		}
		
		$query = "	SELECT i.info_id As value, IF(i.info_id = '*', 'Toàn quốc', info.name) As text 
					FROM #__je_product_info i 
					LEFT JOIN #__je_info info ON info.id = i.info_id
					JOIN #__je_products p ON i.product_id = p.id
					WHERE i.product_id = '$id'";
		
		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();
		
		//array_unshift($options, JHtml::_('select.option', '*', JText::_('Toàn quốc')));

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		// Merge any additional options in the XML definition.
		//$options = array_merge(parent::getOptions(), $options);

		array_unshift($options, JHtml::_('select.option', '', JText::_('-- Lựa chọn --')));

		return $options;
	}
}
