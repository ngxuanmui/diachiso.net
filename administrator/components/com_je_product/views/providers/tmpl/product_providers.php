<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHTML::_('script','system/multiselect.js',false,true);

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_je_product.category');
$saveOrder	= $listOrder=='ordering';

$session = JFactory::getSession();
$filterType = $session->get('filter_type');
?>

<form action="<?php echo JRoute::_('index.php?option=com_je_product&view=providers'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('com_je_product_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">

			<select name="filter_state" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
			
			
		</div>
	</fieldset>
	<div class="clr"> </div>
	
	<div class="width-70 fltlft">

		<table class="adminlist">
			<thead>
				<tr>
					<th width="1%">
						Action
					</th>
					<th>
						<?php echo JHtml::_('grid.sort', 'Title', 'name', $listDirn, $listOrder); ?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'state', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap">
						<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="12">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach ($this->items as $i => $item) :
				$ordering	= ($listOrder == 'ordering');
				$canCreate	= $user->authorise('core.create');
				$canEdit	= $user->authorise('core.edit');
				$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
				$canChange	= false;
				?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="center">
						<a href="#" class="selected" rel="<?php echo $item->id . ',' . $item->name; ?>">Select</a>
					</td>
					<td>
						<strong><?php echo $this->escape($item->name); ?></strong>
					</td>
					<td class="center">
						<?php echo JHtml::_('jgrid.published', $item->state, $i, 'Infos.', $canChange, 'cb', null, null); ?>
					</td>
					<td class="center">
						<?php echo $item->id; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	
		<div>
			<input type="hidden" name="task" value="providers.save_provider" />
			<input type="hidden" name="product_id" value="<?php echo JRequest::getInt('product_id'); ?>" />
			<input type="hidden" name="category_id" value="<?php echo JRequest::getInt('category_id'); ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
	
	<div class="width-30 fltlft">
		<div>
			<div class="title">Providers</div>
			
			<ul class="list-providers-selected">
				<?php foreach ($this->providers as $provider): ?>
				<li>
					[<a href="#" title="Remove this provider" class="removed">x</a>] <?php echo $provider->name; ?> (ID: <?php echo $provider->id; ?>)
					<input type="hidden" name="provider_id[]" value="<?php echo $provider->id; ?>" />
				</li>
				<?php endforeach; ?>
			</ul>
			
		</div>
	</div>
	
	<div id="toolbar-button">
		<div>
			<a href="#" class="btn" id="btn-save">Save</a>
			<a href="#" class="btn" id="btn-close">Close</a>
		</div>
	</div>
	
</form>



<style>
<!--
.width-30 > div { padding: 0px 10px 10px 20px; height: 280px; border: 0px solid #CCC; overflow: auto; }
.width-30 > div div.title { font-size: 14px; font-weight: bold; padding-bottom: 10px; }
ul.list-providers-selected { list-style: none; margin: 0; padding: 0; }
ul.list-providers-selected li { margin: 5px 0; }

div#toolbar-button { position: absolute; bottom: 0; height: 30px; background: #FFF; width: 100%; border-top: 1px solid #CCC; }
div#toolbar-button > div { padding: 5px 20px 0 0px; }
div#toolbar-button > div > a { border-radius: 5px; display: inline-block; background: #333; color: #FFF; padding: 3px 20px; margin-right: 2px; }
-->
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script type="text/javascript">
<!--
jQuery.noConflict();

jQuery(function($){
	$('.selected').click(function(){
		var obj = $('.list-providers-selected');

		var tmp = $(this).attr('rel').split(',');
		
		var html = '<li>';

		html += '[<a href="#" title="Remove this provider" class="removed">x</a>] ' + tmp[1] + ' (ID: ' + tmp[0] +')';

		html += '<input type="hidden" name="provider_id[]" value="' + tmp[0] +'" />';
		
		html += '</li>';

		$(html).appendTo(obj);
	});

	$( document ).on( "click", "a.removed", function() {
		if (confirm ('Are you sure to remove this provider?'))
			$(this).parent().remove();
	} );

	$('#btn-save').click(function(){
		$('form[name="adminForm"]').submit();
	});

	$('#btn-close').click(function(){
		parent.SqueezeBox.close();
	});
});
//-->
</script>
