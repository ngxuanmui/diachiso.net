<?php

class Je_ProductModelHome extends JModel
{
	public function getItems($promotion = false)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select('*')
				->from('#__je_products')
				->where('state = 1')
				->order('id DESC');
		
		if ($promotion)
			$query->where('product_promotion_state = "promotion"');
		else 
			$query->where('sticky = 1');
		
		$db->setQuery($query);
		
		
		
		$rs = $db->loadObjectList();
		
		if ($db->getErrorMsg())
			die($db->getErrorMsg ());
				
		return $rs;
	}
}