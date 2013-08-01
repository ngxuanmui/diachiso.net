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
		
		$session = JFactory::getSession();
		$location = $session->get('location', null);
		
		// Filter by location.
		if(!$location)
			$location = JRequest::getVar('location', null);
		
		if ($location) {
			$loc = $this->getLocation($location);
			
			if($loc->id)
			{
				$session->set('location_name', $loc->name);
				$query->where('( pi.info_id = '.(int) $location.' OR pi.info_id = "*" )');
			}
			else 
			{
				$session->set('location_name', null);
			}
				
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

		//echo str_replace('#__', 'jos_', $query); //die;

		return $query;
	}

	/**
	 * Function to get category info
	 */
	function getCategoryInfo($catId = 0)
	{
		$db = JFactory::getDbo();
		if(!$catId) $catId = JRequest::getVar('id');
		
		if(!$catId)
		{
			$obj = new stdClass();
			$obj->id = null;
			
			$locationId = JRequest::getVar('location');
			
			$loc = new stdClass();
			
			if(intval($locationId) > 0)
				$loc = $this->getLocation($locationId);
			else 
				$loc->name = 'Toàn quốc';
			
			$obj->title = $loc->name;
			$obj->metadesc = 'Tìm thông tin khuyến mại trong cả nước';
			$obj->metakey = 'Thông tin, Khuyến mại, đồ điện tử, tiêu dùng, cả nước, tỉnh thành, lựa chọn';
			
			return $obj;
		}
		
		$query = "SELECT * FROM #__categories c WHERE id = '$catId'";
		$db->setQuery($query);
		
		return $db->loadObject();
	}
	
	function getLocation($locationId)
	{
		$db = JFactory::getDbo();
		
		$loc = new stdClass();
		
		if($locationId == '*')
		{
			$loc->id=null;
			$loc->alias='toan-quoc';
			$loc->name='Toàn quốc';
		}
		else
		{
			$query = "SELECT * FROM #__je_info WHERE id = '$locationId'";
			$db->setQuery($query);
			
			$obj = $db->loadObject();
			
			$loc->id = $obj->id;
			$loc->alias = $obj->alias;
			$loc->name = $obj->name;
		}
		
		return $loc;
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
