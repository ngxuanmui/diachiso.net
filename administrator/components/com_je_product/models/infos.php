<?php
/**
 * @version		$Id: Infos.php 20267 2011-01-11 03:44:44Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Info records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @since		1.6
 */
class JE_ProductModelInfos extends JModelList
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
				'cid', 'a.cid', 'client_name',
				'name', 'a.name',
				'alias', 'a.alias',
				'state', 'a.state',
				'ordering', 'a.ordering',
				'type', 'a.type', 'category_title',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'created', 'a.created',
				'publish_up', 'a.publish_up',
				'publish_down', 'a.publish_down',
				'state',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to get the maximum ordering value for each category.
	 *
	 * @since	1.6
	 */
	function &getCategoryOrders()
	{
		if (!isset($this->cache['typeorders'])) {
			$db		= $this->getDbo();
			$query	= $db->getQuery(true);
			$query->select('MAX(ordering) as `max`, type');
			$query->select('type');
			$query->from('#__cl_diamond_info');
			$query->group('type');
			$db->setQuery($query);
			$this->cache['typeorders'] = $db->loadAssocList('type', '');
		}
		
		return $this->cache['typeorders'];
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Initialise variables.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);
		$query->from('`#__je_info` AS a');

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(a.name LIKE '.$search.' OR a.alias LIKE '.$search.')');
			}
		}
		
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
		
		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = '.(int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		
		$query->order($db->getEscaped($orderCol.' '.$orderDirn));

		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.access');
		$id	.= ':'.$this->getState('filter.state');
		$id	.= ':'.$this->getState('filter.type');

		return parent::getStoreId($id);
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Info', $prefix = 'JE_ProductTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
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
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);

		$categoryId = $this->getUserStateFromRequest($this->context.'.filter.type', 'filter_type', '');
		$this->setState('filter.type', $categoryId);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_je_product');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('ordering', 'asc');
	}
}