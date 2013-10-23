<?php
/**
 * @version		$Id: location.php 2011-08-19 02:23:00$
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
 * @subpackage	com_carman
 * @since		1.6
 */
class JFormFieldLocation extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Group';

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
		$query	= $db->getQuery(true);

		$query = "SELECT id As value, name As text FROM #__je_info AS a WHERE state = 1 ORDER BY a.ordering, a.name";

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		// Merge any additional options in the XML definition.
		//$options = array_merge(parent::getOptions(), $options);

		array_unshift($options, JHtml::_('select.option', '*', JText::_('Toàn quốc')));

		return $options;
	}
	
	public function getInput()
	{
		$html = '<div style="border: 1px solid #CCC; padding: 5px; float: left; width: 330px; height: 195px; overflow: auto;" id="location-container">';
		$html .= '<ul>';
		
		$options = $this->getOptions();
		
		$values = $this->getValues();
		$style = 'style="float: left; width: 150px; padding-bottom: 2px; line-height: 22px;"';
		
		foreach ($options as $option)
		{
			$checked = (is_array($values) && in_array($option->value, $values)) ? 'checked="checked"' : null;
			
			$html .= '<li '.$style.'>';
			$html .= '<input name="'.$this->name.'[]" type="checkbox" class="location" value="'.$option->value.'" '.$checked.' text_option="'.$option->text.'" /> '.$option->text;
			$html .= '</li>';
		}
		
		$html .= '</ul>';
		$html .= '<div style="clear:both;">';
		$html .= '</div>';
		
		return $html;
	}
	
	function getValues()
	{
		$itemId = JRequest::getVar('id', 0);
		
		if(!$itemId)
		{
			//check if session item id exist (front)
			$session 	= JFactory::getSession();
			$itemId 	= $session->get('je_product.post.id', 		null);
		}
		
		$db = JFactory::getDbo();
		$query = "SELECT info_id FROM #__je_product_info WHERE product_id = '$itemId'";
		
		$db->setQuery($query);
		$result = $db->loadResultArray();
		
		return $result;
	}
}
