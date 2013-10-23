<?php
// No direct access
defined('_JEXEC') or die;

class JE_ProductModelDetail extends JModel
{
	function getItem($id = 0)
	{
		$db = JFactory::getDbo();
		
		if (!$id)
			$id = JRequest::getVar('id');
		
		//update hits
		$this->updateHits();
		
		$query = $this->_query();
		$query .= ' AND a.id = '. (int) $id;
		
//		echo str_replace('#__', 'jos_', $query);
		
		$db->setQuery($query);
		$result = $db->loadObject();
		
//		var_dump($result);
		
		if(is_object($result))
		{
			$result->is_expired = false;
			
			$nowDate = $db->Quote(JFactory::getDate()->toMySQL());
			
			if( strtotime($result->publish_down) < time())
				$result->is_expired = true;
			
			$result->locs = $this->getLocations($id);
		}
		else 
			return false;
		
		return $result;
	}
	
	/**
	 * Function to get locations
	 * @param Int $productId
	 * 
	 * @return Object List Locations
	 */
	public function getLocations($productId)
	{
		$db = JFactory::getDbo();
		
		$productInfo = $this->getProductInfo($productId);
		
		$result = $allLocation = $location = array();
		$objLocation = new stdClass();
		
		foreach ($productInfo as $info)
		{
			if($info == '*')
			{
				$objLocation->id = '*';
				$objLocation->name = 'Toàn quốc';
				
				$allLocation[] = $objLocation;
			}
			else 
				$location[] = $info;
		}
		
		if(!empty($location))
		{
			$location = implode(',', $location);
			$query = "	SELECT i.*
						FROM #__je_info i 
						WHERE i.id IN ($location)
						ORDER BY i.ordering";
			$db->setQuery($query);
			$result = $db->loadObjectList();
		}
		
		if(!empty($allLocation))
			$result = array_merge($allLocation, $result);
		
		return $result;
	}
	
	function getProductInfo($productId)
	{
		$db = JFactory::getDbo();
		
		$query = "SELECT info_id FROM #__je_product_info pi WHERE pi.product_id = '$productId'";
		$db->setQuery($query);
		
		$result = $db->loadResultArray();
		
		return $result;
	}
	
	function getOtherProducts()
	{
		$db = JFactory::getDbo();
		$id = JRequest::getVar('id');
		
		$nullDate = $db->Quote($db->getNullDate());
		$nowDate = $db->Quote(JFactory::getDate()->toMySQL());
		
		$query = $this->_query();
		$query .= ' AND (a.publish_down = '.$nullDate.' OR a.publish_down >= '.$nowDate.')';
		$query .= " AND a.id != '$id' AND catid = (SELECT catid FROM #__je_products WHERE id = '$id' )";		
		
		$session = JFactory::getSession();
		$location = $session->get('location');
		
		if($location)
			$query .= " AND (pi.id = '$location' OR pi.info_id = '*') ";
		
		$query .= " ORDER BY RAND() ";
		$query .= " LIMIT 5 ";
		
		#echo str_replace('#__', 'jos_', $query);
		
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		return $result;
	}
	
	private function _query()
	{
		$db = JFactory::getDbo();
		
		// Filter by start and end dates.
		$nullDate = $db->Quote($db->getNullDate());
		$nowDate = $db->Quote(JFactory::getDate()->toMySQL());
		
		$query  = ' SELECT DISTINCT a.id, a.*, c.title AS category_title, IF(a.location = "*", "all-location", i.name) AS location_name FROM #__je_products a ';
		$query .= " LEFT JOIN #__je_product_info pi ON a.id = pi.product_id ";
		$query .= " LEFT JOIN #__je_info i ON ( i.id = a.location ) "; 		
		$query .= " INNER JOIN #__categories c ON (a.catid = c.id)";
		$query .= " WHERE a.state = 1 ";
		$query .= ' AND (a.publish_up = '.$nullDate.' OR a.publish_up <= '.$nowDate.')';
		//$query .= ' AND (a.publish_down = '.$nullDate.' OR a.publish_down >= '.$nowDate.')';
		
		return $query;
	}
	
	private function updateHits()
	{
		$db = JFactory::getDbo();
		$id = JRequest::getVar('id');
		
		$query = "UPDATE #__je_products SET hits = IFNULL(hits,0) + 1 WHERE id = '$id'";
		$db->setQuery($query);
		
		$db->query();
	}
}