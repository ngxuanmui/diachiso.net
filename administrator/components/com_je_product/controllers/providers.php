<?php
/**
 * @version		$Id: Infos.php 20228 2011-01-10 00:52:54Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Infos list controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @since		1.6
 */
class JE_ProductControllerProviders extends JControllerAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_JE_PRODUCT_INFOS';

	/**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

	}

	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Provider', $prefix = 'JE_ProductModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	public function save_provider()
	{
		$jInput = JFactory::getApplication()->input;
		
		$post = $jInput->post;
		
		$model = $this->getModel();
		
		$providerId = $post->get('provider_id', array(), 'array');
		$productId = $jInput->getInt('product_id', 0);
		
		/* use this var to filter providers */
		$categoryId = $jInput->getInt('category_id', 0);
		
		$return = $model->saveProvider($providerId, $productId);
		
		$url = JRoute::_('index.php?option=com_je_product&view=providers&layout=product_providers&tmpl=component&product_id=' . $productId . '&category_id=' . $categoryId, false);
		$msg = 'Save Successful!';
		
		$this->setRedirect($url, $msg);
		
		return $return;
	}
}