<?php

class Je_ProductControllerShopping_Cart extends JControllerLegacy
{
	protected $shoppingCart;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->shoppingCart = new ShoppingBasket();
	}
	public function add()
	{
		$jInput = JFactory::getApplication()->input;
		
		$id = $jInput->getInt('id', 0);
		
		if (!$id)
			return false;
		
		// add to cart
		$this->shoppingCart->addToBasket($id);
		
		$url = JRoute::_('index.php?option=com_je_product&view=shopping_cart&tmpl=component&id=' . $id, false);
		
		$this->setRedirect($url);
		
		return true;
	}
	
	public function update()
	{
		$jInput = JFactory::getApplication()->input;
		
		$ids = $jInput->get('id', array(), 'array');
		$qties = $jInput->get('qty', array(), 'array');
		
		foreach ($ids as $id)
		{
			if (isset($qties[$id]) && $qties[$id] > 0)
				$this->shoppingCart->updateBasket($id, $qties[$id]);
		}
		
		$url = JRoute::_('index.php?option=com_je_product&view=shopping_carts', false);
		
		$this->setRedirect($url);
		
		return true;
	}
	
	public function remove()
	{
		$jInput = JFactory::getApplication()->input;
		
		$id = $jInput->getInt('id', 0);
		
		if (!$id)
			return false;
		
		// add to cart
		$this->shoppingCart->removeFromBasket($id, 0, false);
		
		$url = JRoute::_('index.php?option=com_je_product&view=shopping_carts', false);
		
		$this->setRedirect($url);
		
		return true;
	}
}