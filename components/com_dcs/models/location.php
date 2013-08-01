<?php
/**
 * @version		$Id: category.php 21593 2011-06-21 02:45:51Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * @package		Joomla.Site
 * @subpackage	com_je_product
 */
class JE_ProductModelCategory extends JModelList
{

	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'name', 'a.name',
				'con_position', 'a.con_position',
				'suburb', 'a.suburb',
				'state', 'a.state',
				'country', 'a.country',
				'ordering', 'a.ordering',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select required fields from the categories.
		$query->select($this->getState('list.select', 'DISTINCT a.id, a.*') . ', c.title AS category_title, IF(a.location = "*", "all-location", i.name) AS location_name, '
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug, '
		. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END AS catslug ');
		$query->from('`#__je_products` AS a');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
		$query->join('LEFT', '#__je_product_info pi ON pi.product_id = a.id');
		$query->join('LEFT', '#__je_info i ON i.id = a.location');
		
		// Filter by category.
		$categoryId = JRequest::getVar('id', null);
		if ($categoryId) {
			$query->where('a.catid IN (select c.id from #__categories c, (select * from #__categories where id = '.(int) $categoryId.') as viewa where c.extension = "com_je_product" AND (c.id = '.(int) $categoryId.' OR (c.lft > viewa.lft AND c.rgt < viewa.rgt)))');
		}
		
		// Filter by location.
		$locationId = JRequest::getVar('location', null);
		
		// If filter by session
		$session = JFactory::getSession();
		$location = $session->get('location', null);
		
		if(!$locationId)
			$locationId = $location;
		
		if ($locationId) {
			$query->where('( pi.info_id = '.(int) $locationId.' OR pi.info_id = "*" )');
		}

		// Filter by state
		$query->where('a.state = 1');
		
		// Filter by start and end dates.
		$nullDate = $db->Quote($db->getNullDate());
		$nowDate = $db->Quote(JFactory::getDate()->toMySQL());

		//if ($this->getState('filter.publish_date')){
			$query->where('(a.publish_up = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')');
			$query->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');
		//}
		
		$query->group('a.id');

		// Add the list ordering clause.
		$query->order('a.sticky, a.id DESC');

		#echo str_replace('#__', 'jos_', $query); die;

		return $query;
	}

	/**
	 * Function to get category info
	 */
	function getCategoryInfo($catId = 0)
	{
		$db = JFactory::getDbo();
		if(!$catId) $catId = JRequest::getVar('id');
		
		$query = "SELECT * FROM #__categories c WHERE id = '$catId'";
		$db->setQuery($query);
		
		return $db->loadObject();
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();
		$params	= JComponentHelper::getParams('com_je_product');
		$db		= $this->getDbo();
		// List state information		
		/*
		if ($format=='feed') {
			$limit = $app->getCfg('feed_limit');
		}
		else {
			$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		}
		*/
		$limit = 40;
		$this->setState('list.limit', $limit);

		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		$this->setState('list.start', $limitstart);

		$orderCol	= JRequest::getCmd('filter_order', 'ordering');
		if (!in_array($orderCol, $this->filter_fields)) {
			$orderCol = 'ordering';
		}
		$this->setState('list.ordering', $orderCol);

		$listOrder	=  JRequest::getCmd('filter_order_Dir', 'ASC');
		if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', ''))) {
			$listOrder = 'ASC';
		}
		$this->setState('list.direction', $listOrder);

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setState('category.id', $id);

		// Load the parameters.
		$this->setState('params', $params);
	}
}
