<?php
/**
 * @version		$Id: edit.php 18568 2010-08-21 18:34:12Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_products
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">

	window.addEvent('domready', function() {
		 
	    $$('.location').addEvent('click', function(){
	    	checkLocation = false;
	    	
	    	var location = $$('.location');
	
	    	Array.each(location, function(el){
				if(el.checked)
					checkLocation = true;
			});
	
	    	if(checkLocation)
	    		$('location-container').removeClass('invalid');
	        else
	        	$('location-container').addClass('invalid');
	
	    	
	    });

	    $$('.location').addEvent('click', function(){
			if(this.checked)
			{
				var NewOption = new Option(this.get('text_option'), this.get('value'));
				NewOption.inject($('jform_location'));
			}
			else
			{
				removeOption($('jform_location'), this.get('value'));
			}
		});
	});

	Joomla.submitbutton = function(task)
	{
//		checkLocation = false;
//		
//		var location = $$('.location');
//		
//		Array.each(location, function(el){
//			if(el.checked)
//				checkLocation = true;
//		});
//
//		if(!checkLocation)
//		{
//			$('location-container').addClass('invalid');
//		}
		
		checkLocation = true;

		if (task == 'product.cancel' || ( document.formvalidator.isValid(document.id('product-form')) && checkLocation ) ) {
			Joomla.submitform(task, document.getElementById('product-form'));
		}
	}

	function removeOption(obj, value)
	{
		var selectOptions = obj.getElements('option');
		selectOptions.each(function(option) {
			if (option.get('value') == value) {
				option.dispose();
			}
		});
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_je_product&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="product-form" class="form-validate" enctype="multipart/form-data">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('Add new') : JText::sprintf('Edit Details', $this->item->id); ?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('name'); ?>
				<?php echo $this->form->getInput('name'); ?>
				
					<?php if($this->item->images && JEUtil::is_serialized($this->item->images)): ?>
						<div style="float:right; background: #FAFAFA; padding: 5px;">
							<?php 
								$images = unserialize($this->item->images);
							?>
							<table cellpadding="0" cellspacing="1">
								<tr>
									<th width="120" style="padding-bottom: 10px;">Image Uploaded</th>
									<th style="padding-bottom: 10px;">Del</th>
								</tr>
								<?php foreach ($images as $key => $img): ?>
								<tr>
									<td>
										<a href="../images/je_products/upload/<?php echo $img; ?>" class="modal">
											<img src="../images/je_products/upload/<?php echo $img; ?>" style="width: 100px; margin: 0;" />
										</a>
									</td>
									<td valign="top">
										<input type="checkbox" name="jform[del_image][]" value="<?php echo $img; ?>" />
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
						</div>
					<?php endif; ?>
				
				</li>

				<li><?php echo $this->form->getLabel('alias'); ?>
				<?php echo $this->form->getInput('alias'); ?></li>

				<li><?php echo $this->form->getLabel('catid'); ?>
				<?php echo $this->form->getInput('catid'); ?></li>
				
				<li><?php echo $this->form->getLabel('info_id'); ?>
				<?php echo $this->form->getInput('info_id'); ?></li>
				
				<li><?php echo $this->form->getLabel('product_promotion_state'); ?>
				<?php echo $this->form->getInput('product_promotion_state'); ?></li>
				
				<li><?php echo $this->form->getLabel('product_state'); ?>
				<?php echo $this->form->getInput('product_state'); ?></li>
				
				<li><?php echo $this->form->getLabel('price'); ?>
				<?php echo $this->form->getInput('price'); ?></li>
				
				<li><?php echo $this->form->getLabel('promotion_price'); ?>
				<?php echo $this->form->getInput('promotion_price'); ?></li>
				
				<li><?php echo $this->form->getLabel('images'); ?>
				<?php echo $this->form->getInput('images'); ?>
				</li>
				
				<li><?php echo $this->form->getLabel('note'); ?>
				<?php echo $this->form->getInput('note'); ?></li>

				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
			</ul>
			<div class="clr"> </div>
			<?php echo $this->form->getLabel('description'); ?>
			<div class="clr"> </div>
			<?php echo $this->form->getInput('description'); ?>
			
			<div class="clr"> </div>
			<?php echo $this->form->getLabel('content'); ?>
			<div class="clr"> </div>
			<?php echo $this->form->getInput('content'); ?>

		</fieldset>
	</div>

<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start','product-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
	<?php echo JHtml::_('sliders.panel',JText::_('Publishing Options'), 'publishing-details'); ?>
		<fieldset class="adminform">
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
		

	<?php echo JHtml::_('sliders.panel',JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'metadata'); ?>
		<fieldset class="adminform">
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('metakey'); ?>
				<?php echo $this->form->getInput('metakey'); ?></li>

				<li><?php echo $this->form->getLabel('metadesc'); ?>
				<?php echo $this->form->getInput('metadesc'); ?></li>
			</ul>
		</fieldset>
	<?php echo JHtml::_('sliders.end'); ?>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</div>

<div class="clr"></div>
</form>
