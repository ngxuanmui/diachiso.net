<?php

class JE_ProductModelOrder extends JModelLegacy
{
	public function getItems()
	{
		$id = JRequest::getInt('id');
		
		$shoppingCart = new ShoppingBasket();
		
		$cartItems = $shoppingCart->getBasket();
		
		$list = array();
		
		foreach ($cartItems as $id => $qty)
		{
			$list[] = $id;
		}
		
		$db		= $this->getDbo();
		
		$listId = implode(',', $list);
		
		$query = $this->getListQuery($listId);
		
		$db->setQuery($query);
		
		$items = $db->loadObjectList('id');
		
		foreach ($items as $id => & $item)
			$item->qty = $cartItems[$id];
		
		return $items;
	}
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 * @since	1.6
	 */
	protected function getListQuery($listId = '')
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
	
		// Select required fields from the categories.
		$query->select($this->getState('list.select', 'DISTINCT a.id, a.*') . ', c.title AS category_title, '
				. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug, '
				. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END AS catslug ');
		$query->from('`#__je_products` AS a');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
	
		// Filter by category.
		$categoryId = JRequest::getVar('id', null);
	
		if ($categoryId) {
			$query->where('a.catid IN (select c.id from #__categories c, (select * from #__categories where id = '.(int) $categoryId.') as viewa where c.extension = "com_je_product" AND (c.id = '.(int) $categoryId.' OR (c.lft > viewa.lft AND c.rgt < viewa.rgt)))');
		}
	
		$infoId = JRequest::getInt('info_id');
	
		if ($infoId)
		{
			$query->select('i.name AS info_title');
			$query->join('LEFT', '#__je_info i ON a.info_id = i.id');
			$query->where('a.info_id = ' . (int) $infoId);
		}
		
		// Filter by state
		$query->where('a.state = 1');
		
		if ($listId)
			$query->where('a.id IN ('.$listId.')');
	
		// Filter by start and end dates.
		//		$nullDate = $db->Quote($db->getNullDate());
		//		$nowDate = $db->Quote(JFactory::getDate()->toMySQL());
		//
		//		//if ($this->getState('filter.publish_date')){
		//			$query->where('(a.publish_up = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')');
		//			$query->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');
		//		//}
	
		$query->group('a.id');
	
		// Add the list ordering clause.
		$query->order('a.sticky, a.id DESC');
	
		//echo str_replace('#__', 'jos_', $query); //die;
	
		return $query;
	}
}