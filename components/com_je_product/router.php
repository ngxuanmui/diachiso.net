<?php
/**
 * @version		$Id: router.php 21321 2011-05-11 01:05:59Z dextercowley $
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.categories');

/**
 * Build the route for the com_content component
 *
 * @param	array	An array of URL arguments
 * @return	array	The URL arguments to use to assemble the subsequent URL.
 * @since	1.5
 */
function JE_ProductBuildRoute(&$query)
{
	$segments	= array();

	// get a menu item based on Itemid or currently active
	$app		= JFactory::getApplication();
	$menu		= $app->getMenu();
	$params		= JComponentHelper::getParams('com_je_product');
	$advanced	= $params->get('sef_advanced_link', 0);
	
	if(isset($query['view']) && $query['view'] == 'post') $query['Itemid'] = 147;
	
	if(isset($query['view']) && $query['view'] == 'posts') $query['Itemid'] = 139;
	
	if(isset($query['view']) && $query['view'] == 'search') $query['Itemid'] = 146;

	// we need a menu item.  Either the one specified in the query, or the current active one if none specified
	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
		$menuItemGiven = false;
	}
	else {
		$menuItem = $menu->getItem($query['Itemid']);
		$menuItemGiven = true;
	}
	//echo '<pre>';
	//print_r($menu);
	if (isset($query['view'])) {
		$view = $query['view'];
	}
	else {
		// we need to have a view in the query or it is an invalid URL
		return $segments;
	}

	// are we dealing with an article or category that is attached to a menu item?
	if (($menuItem instanceof stdClass) && $menuItem->query['view'] == $query['view'] && isset($query['id']) && $menuItem->query['id'] == intval($query['id'])) {
		unset($query['view']);

		if (isset($query['catid'])) {
			unset($query['catid']);
		}

		unset($query['id']);

		return $segments;
	}
	

	if ($view == 'category' || $view == 'detail' || $view == 'post' || $view == 'posts' || $view == 'search')
	{
		
		if (!$menuItemGiven) {
			$segments[] = $view;
		}
		unset($query['view']);

		if ($view == 'detail') {
			if (isset($query['id'])) {
				$id = $query['id'];
			} else {
				// we should have these two set for this view.  If we don't, it is an error
				return $segments;
			}
			
		}
		elseif($view != 'category') {
			if (isset($query['id'])) {
				$catid = $query['id'];
			} else {
				// we should have id set for this view.  If we don't, it is an error
				return $segments;
			}
		}

		if ($menuItemGiven && isset($menuItem->query['id'])) {
			$mCatid = $menuItem->query['id'];
		} else {
			$mCatid = 0;
		}

		if ($view == 'detail') {
			if ($advanced) {
				list($tmp, $id) = explode(':', $query['id'], 2);
			}
			else {
				$id = $query['id'];
			}
			$segments[] = $id;
		}
		
		unset($query['id']);
		unset($query['catid']);
	}

	// if the layout is specified and it is the same as the layout in the menu item, we
	// unset it so it doesn't go into the query string.
	if (isset($query['layout'])) {
		if ($menuItemGiven && isset($menuItem->query['layout'])) {
			if ($query['layout'] == $menuItem->query['layout']) {

				unset($query['layout']);
			}
		}
		else {
			if ($query['layout'] == 'default') {
				unset($query['layout']);
			}
		}
	}

	return $segments;
}



/**
 * Parse the segments of a URL.
 *
 * @param	array	The segments of the URL to parse.
 *
 * @return	array	The URL attributes to be used by the application.
 * @since	1.5
 */
function JE_ProductParseRoute($segments)
{
	$vars = array();

	//Get the active menu item.
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$item	= $menu->getActive();
	$params = JComponentHelper::getParams('com_je_product');
	$advanced = $params->get('sef_advanced_link', 0);
	$db = JFactory::getDBO();

	// Count route segments
	$count = count($segments);

	// Standard routing for articles.  If we don't pick up an Itemid then we get the view from the segments
	// the first segment is the view and the last segment is the id of the article or category.
	if (!isset($item)) {
		$vars['view']	= $segments[0];
		$vars['id']		= $segments[$count - 1];

		return $vars;
	}

	// if there is only one segment, then it points to either an article or a category
	// we test it first to see if it is a category.  If the id and alias match a category
	// then we assume it is a category.  If they don't we assume it is an article
	if ($count == 1) {
		// we check to see if an alias is given.  If not, we assume it is an article
		if (strpos($segments[0], ':') === false) {
			$vars['view'] = 'detail';
			$vars['id'] = (int)$segments[0];
			return $vars;
		}

		list($id, $alias) = explode(':', $segments[0], 2);

		// first we check if it is a category
		$category = JCategories::getInstance('Content')->get($id);

		if ($category && $category->alias == $alias) {
			$vars['view'] = 'category';
			$vars['id'] = $id;

			return $vars;
		} else {
			$query = 'SELECT alias, catid FROM #__je_product WHERE id = '.(int)$id;
			$db->setQuery($query);
			$article = $db->loadObject();

			if ($article) {
				if ($article->alias == $alias) {
					$vars['view'] = 'detail';
					$vars['id'] = (int)$id;

					return $vars;
				}
			}
		}
	}

	// if there was more than one segment, then we can determine where the URL points to
	// because the first segment will have the target category id prepended to it.  If the
	// last segment has a number prepended, it is an article, otherwise, it is a category.
	if (!$advanced) {
		$cat_id = (int)$segments[0];

		$article_id = (int)$segments[$count - 1];

		if ($article_id > 0) {
			$vars['view'] = 'detail';
			$vars['catid'] = $cat_id;
			$vars['id'] = $article_id;
		} else {
			$vars['view'] = 'category';
			$vars['id'] = $cat_id;
		}

		return $vars;
	}

	// we get the category id from the menu item and search from there
	$id = $item->query['id'];
	
	$vars['id'] = $id;

	return $vars;
}
