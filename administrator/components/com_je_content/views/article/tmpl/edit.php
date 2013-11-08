<?php
/**
 * @version		$Id: edit.php $
 * @package		Joomla.Administrator
 * @subpackage	com_je_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		muinx
 * This component was generated by http://joomlavietnam.net/ - 2012
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'article.cancel' || document.formvalidator.isValid(document.id('article-form'))) {
			Joomla.submitform(task, document.getElementById('article-form'));
		}
	}
</script>

<style>
<!--
.button2-left { margin-top: 5px; }
#jform_title, #jform_alias, #jform_shortdesc { width: 400px; }
-->
</style>

<form action="<?php echo JRoute::_('index.php?option=com_je_content&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="article-form" class="form-validate" enctype="multipart/form-data">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_JE_CONTENT_NEW_ARTICLE') : JText::sprintf('COM_JE_CONTENT_ARTICLE_DETAILS', $this->item->id); ?></legend>
			<ul class="adminformlist">
				
				<li><?php echo $this->form->getLabel('title'); ?>
				<?php echo $this->form->getInput('title'); ?></li>
				
				<li><?php echo $this->form->getLabel('alias'); ?>
				<?php echo $this->form->getInput('alias'); ?></li>
				
				<li><?php echo $this->form->getLabel('shortdesc'); ?>
				<?php echo $this->form->getInput('shortdesc'); ?></li>
				
				<li><?php echo $this->form->getLabel('catid'); ?>
				<?php echo $this->form->getInput('catid'); ?></li>
				
				<li><?php echo $this->form->getLabel('images'); ?>
				<?php echo $this->form->getInput('images'); ?></li>
				
				<?php if ($this->item->images): ?>
				<li>
					<label>&nbsp;</label>
					<a href="<?php echo JURI::root() . $this->item->images; ?>" class="modal">
						<img src="<?php echo JURI::root() . $this->item->images; ?>" style="float: left; width: 100px;" />
					</a>
					<?php echo $this->form->getInput('del_image'); ?>
					<?php echo $this->form->getInput('hidden_image'); ?>
					<span style="float: left; line-height: 23px;">Delete Image</span>
				</li>
				<?php endif; ?>
				
				<li><?php echo $this->form->getLabel('featured_images'); ?>
				<?php echo $this->form->getInput('featured_images'); ?></li>
				
				<?php if ($this->item->featured_images): ?>
				<li>
					<label>&nbsp;</label>
					<a href="<?php echo JURI::root() . $this->item->featured_images; ?>" class="modal">
						<img src="<?php echo JURI::root() . $this->item->featured_images; ?>" style="float: left; width: 100px;" />
					</a>
					<?php echo $this->form->getInput('del_featured_image'); ?>
					<?php echo $this->form->getInput('hidden_featured_image'); ?>
					<span style="float: left; line-height: 23px;">Delete Featured Image</span>
				</li>
				<?php endif; ?>
				
				<li><?php echo $this->form->getLabel('related_brand_id'); ?>
				<?php echo $this->form->getInput('related_brand_id'); ?></li>
				
				<li><?php echo $this->form->getLabel('link_to_product'); ?>
				<?php echo $this->form->getInput('link_to_product'); ?></li>
				
				<li><?php echo $this->form->getLabel('product_id'); ?>
				<?php echo $this->form->getInput('product_id'); ?></li>
				
				<li><?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?></li>
				
				<li><?php echo $this->form->getLabel('featured'); ?>
				<?php echo $this->form->getInput('featured'); ?></li>

				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
			</ul>
			<div class="clr"> </div>
			<?php echo $this->form->getLabel('introtext'); ?>
			<div class="clr"> </div>
			<?php echo $this->form->getInput('introtext'); ?>
			<div class="clr"> </div>
			<?php echo $this->form->getLabel('fulltext'); ?>
			<div class="clr"> </div>
			<?php echo $this->form->getInput('fulltext'); ?>
			<div class="clr"></div>
			<?php echo $this->form->getInput('images2content'); ?>
			<div class="clr"> </div>
		</fieldset>
	</div>

<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start','article-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

	<?php echo JHtml::_('sliders.panel',JText::_('COM_JE_CONTENT_GROUP_LABEL_PUBLISHING_DETAILS'), 'publishing-details'); ?>
		<fieldset class="panelform">
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('publish') as $field): ?>
				<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
			<?php endforeach; ?>
			</ul>
		</fieldset>

	<?php echo JHtml::_('sliders.panel',JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'metadata'); ?>
		<fieldset class="panelform">
			<ul class="adminformlist">
				<?php foreach($this->form->getFieldset('metadata') as $field): ?>
					<li><?php echo $field->label; ?>
						<?php echo $field->input; ?></li>
				<?php endforeach; ?>
			</ul>
		</fieldset>

	<?php echo JHtml::_('sliders.end'); ?>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</div>

<div class="clr"></div>
</form>
