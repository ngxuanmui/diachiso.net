<?php

class JE_ProductModelShopping_Cart extends JModelLegacy
{
	public function getItem()
	{
		$id = JRequest::getInt('id');
		
// 		$shoppingCart = new ShoppingBasket();
		
// 		$item = $shoppingCart->getBasket($id);
		
		$itemModel = JModel::getInstance('Detail', 'JE_ProductModel');
		
		$item = $itemModel->getItem($id);
		
		return $item;
	}
}