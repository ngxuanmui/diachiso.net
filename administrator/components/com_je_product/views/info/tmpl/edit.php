<?php
/**
 * @version		$Id: edit.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$session = JFactory::getSession();
$filterType = $session->get('filter_type');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'info.cancel' || document.formvalidator.isValid(document.id('info-form'))) {
			Joomla.submitform(task, document.getElementById('info-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_je_product&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="info-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend>Details</legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('name'); ?>
				<?php echo $this->form->getInput('name'); ?></li>
				
				<li><?php echo $this->form->getLabel('alias'); ?>
				<?php echo $this->form->getInput('alias'); ?></li>
				
				<li><?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?></li>				

				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
			</ul>
			<div class="clr"> </div>

		</fieldset>
	</div>

<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start','info-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

	<?php echo JHtml::_('sliders.panel',JText::_('COM_JE_PRODUCT_GROUP_LABEL_PUBLISHING_DETAILS'), 'publishing-details'); ?>
		<fieldset class="panelform">
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('publish') as $field): ?>
				<li>
					<?php if (!$field->hidden): ?>
						<?php echo $field->label; ?>
					<?php endif; ?>
					<?php echo $field->input; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</fieldset>

	<?php echo JHtml::_('sliders.end'); ?>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="filter_type" value="<?php echo $filterType; ?>">
	<?php echo JHtml::_('form.token'); ?>
</div>

<div class="clr"></div>
</form>
