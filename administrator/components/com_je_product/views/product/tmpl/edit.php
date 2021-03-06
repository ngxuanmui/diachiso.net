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

$brandId = (!empty($this->item->brand_id)) ? $this->item->brand_id : 0;
$subBrandId = (!empty($this->item->sub_brand_id)) ? $this->item->sub_brand_id : 0;
?>

<style>
<!--
.list-brand,.sub-brand {
	float: left;
}

.button2-left {
	margin-top: 5px;
}
-->
</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script type="text/javascript">

jQuery.noConflict();

select_brand();

jQuery(function($) {
    $( "#tabs" ).tabs({ active: 0 });
});

function changeBrand(brandContainer, brandId, subBrandId)
{
	jQuery.post(
		'index.php?option=com_je_product&view=brands&layout=sub_brand&format=raw', 
		{ 	
			'brand_id' : brandId,
			'sub_brand_id' : subBrandId
		}, 
		function(res){
			jQuery('.sub-brand').remove();
			
			var html = '<div class="sub-brand">';

			html += res;
			
			html += '</div>';
			
			jQuery(html).insertAfter(jQuery(brandContainer));
		}
	);
}

function select_brand()
{
	jQuery(function($){
		
		var t = $('#jform_catid');

		if (t.val() == '')
			$('.brand').remove();

		$('.brand').remove();

		var html = '<label class="brand">&nbsp;</label><div class="brand list-brand">Waiting ...</div>';

		$(html).insertAfter(t);

		$.post(
				'index.php?option=com_je_product&view=brands&layout=list_brand&format=raw', 
				{ 'category_id': t.val(), 'brand_id' : '<?php echo $brandId; ?>', 'sub_brand_id' : '<?php echo $subBrandId; ?>' }, 
				function(res){
					$('.brand').remove();
					
					var html = '<label class="brand">&nbsp;</label><div class="brand list-brand">';

					html += res;
					
					html += '</div>';
					
					$(html).insertAfter(t);

					var brandId = $(this);

					var html = '<div class="sub-brand">Waiting ...</div>';

					$(html).insertAfter(brandId);
					
					$('#jform_brand_id').change(function(){
						changeBrand('#jform_brand_id',  $(this).val(), <?php echo $subBrandId; ?>);
					});
					
				}
		);
	});
}

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

<form
	action="<?php echo JRoute::_('index.php?option=com_je_product&layout=edit&id='.(int) $this->item->id); ?>"
	method="post" name="adminForm" id="product-form" class="form-validate"
	enctype="multipart/form-data">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('Add new') : JText::sprintf('Edit Details', $this->item->id); ?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('name'); ?>
				<?php echo $this->form->getInput('name'); ?>
				
					<?php if($this->item->images && JEUtil::is_serialized($this->item->images)): ?>
						<div style="float: right; background: #FAFAFA; padding: 5px;">
							<?php 
								$images = unserialize($this->item->images);
							?>
							<table cellpadding="0" cellspacing="5">
							<tr>
								<th width="120" style="padding-bottom: 10px;">Image Uploaded</th>
								<th style="padding-bottom: 10px;">Del</th>
							</tr>
								<?php foreach ($images as $key => $img): ?>
								<tr>
								<td><a href="../images/products/upload/<?php echo $img; ?>"
									class="modal"> <img
										src="../images/products/upload/<?php echo $img; ?>"
										style="width: 100px; margin: 0;" />
								</a></td>
								<td valign="top"><input type="checkbox"
									name="jform[del_image][]" value="<?php echo $img; ?>" /></td>
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
				
				<?php /*?>
				<li><?php echo $this->form->getLabel('product_state'); ?>
				<?php echo $this->form->getInput('product_state'); ?></li>
				
				<li><?php echo $this->form->getLabel('price'); ?>
				<?php echo $this->form->getInput('price'); ?></li>
				
				<li><?php echo $this->form->getLabel('promotion_price'); ?>
				<?php echo $this->form->getInput('promotion_price'); ?></li>
				*/ ?>
				
				<li><?php echo $this->form->getLabel('images'); ?>
				<?php echo $this->form->getInput('images'); ?>
				</li>

				<li><?php echo $this->form->getLabel('note'); ?>
				<?php echo $this->form->getInput('note'); ?></li>

				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
			</ul>
			
			<div class="clr"></div>
			
			<label>Product Content</label>
			
			<div class="clr"></div>

			<div id="tabs">
				<ul>
					<li><a href="#fragment-1"><span>Description</span></a></li>
					<li><a href="#fragment-2"><span>Featured Content</span></a></li>
					<li><a href="#fragment-3"><span>Tech Content</span></a></li>
				</ul>
				<div id="fragment-1">
					<?php echo $this->form->getInput('description'); ?>
					<div class="clr"></div>
					<?php echo $this->form->getInput('images2content'); ?>
					<div class="clr"></div>
				</div>
				<div id="fragment-2">
					<?php echo $this->form->getInput('featured_content'); ?>
					<div class="clr"></div>
				</div>
				<div id="fragment-3">
					<?php echo $this->form->getInput('tech_content'); ?>
					<div class="clr"></div>
				</div>
			</div>
			
			<div class="clr"></div>

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
