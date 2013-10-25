<script type="text/javascript">
<!--
window.addEvent('domready', function(){
	$$('.add-more-address').addEvent('click', function (event, clicked) { 
		event.preventDefault() ;

		var tmpl =  $$('.address-template');

		var htmlContent = tmpl.get('html');

		var myElement  = new Element('li', {html: htmlContent});
		
		myElement.inject($('addresses'));
		
		return false;
	});

	$(document.body).addEvent("click:relay(.remove-address)", function(event, element) {
		var parent = this.getParent();

		parent.destroy();
	});
});
//-->
</script>
<?php
/**
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Bannerclient Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @since		1.6
 */
class JFormFieldAddresses extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Addresses';
	
	public function getInput()
	{
		/* get addresses */
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$str = '<ul class="adminformlist" id="addresses">
					<li>
						<button type="button" class="add-more-address">Add address</button>
					</li>';
		
		$providerId = $this->form->getValue('id');
		
		if (!empty($providerId))
		{		
			$table = '#__je_provider_addresses';
			
			$query->select('*')->from($table)->where('provider_id = ' . $providerId);
			
			$db->setQuery($query);
			
			$rs = $db->loadObjectList();
			
			if ($db->getErrorMsg())
				die ($db->getErrorMsg());
	 				
			foreach ($rs as $address)
			{
	 			$str .=
	 				'<li>
					
						<hr class="clr" style="border: none; border-bottom: 1px solid #CCC;" />
						
						<label id="jform_province_id-lbl" for="jform_province_id" class="">Province</label>					
	 					'.$this->getCategories($address->province_id).'
						
						<label id="jform_address-lbl" for="jform_address" class="">Address</label>					
	 					<input type="text" name="jform[address][]" id="jform_address" value="'.$address->address.'" class="inputbox" size="40"/>					
						<label id="jform_phone-lbl" for="jform_phone" class="">Phone</label>					
	 					<input type="text" name="jform[phone][]" id="jform_phone" value="'.$address->phone.'" class="inputbox" size="40"/>					
						<label id="jform_hotline-lbl" for="jform_hotline" class="">Hotline</label>					
	 					<input type="text" name="jform[hotline][]" id="jform_hotline" value="'.$address->hotline.'" class="inputbox" size="40"/>					
						<label id="jform_nick_yahoo_support-lbl" for="jform_nick_yahoo_support" class="">Nick Yahoo</label>					
	 					<input type="text" name="jform[nick_yahoo_support][]" id="jform_nick_yahoo_support" value="'.$address->nick_yahoo_support.'" class="inputbox" size="40"/>					
						<label id="jform_nick_skype_support-lbl" for="jform_nick_skype_support" class="">Nick Skype</label>					
	 					<input type="text" name="jform[nick_skype_support][]" id="jform_nick_skype_support" value="'.$address->nick_skype_support.'" class="inputbox" size="40"/>					
						<button class="remove-address" type="button">Remove</button>
					</li>
				';
			}
		}
						
		$str .=	'<li class="address-template" style="display: none;">
				
					<hr class="clr" style="border: none; border-bottom: 1px solid #CCC;" />
					
					<label id="jform_province_id-lbl" for="jform_province_id" class="">Province</label>					
 					'.$this->getCategories().'
					
					<label id="jform_address-lbl" for="jform_address" class="">Address</label>					
 					<input type="text" name="jform[address][]" id="jform_address" value="" class="inputbox" size="40"/>					
					<label id="jform_phone-lbl" for="jform_phone" class="">Phone</label>					
 					<input type="text" name="jform[phone][]" id="jform_phone" value="" class="inputbox" size="40"/>					
					<label id="jform_hotline-lbl" for="jform_hotline" class="">Hotline</label>					
 					<input type="text" name="jform[hotline][]" id="jform_hotline" value="" class="inputbox" size="40"/>					
					<label id="jform_nick_yahoo_support-lbl" for="jform_nick_yahoo_support" class="">Nick Yahoo</label>					
 					<input type="text" name="jform[nick_yahoo_support][]" id="jform_nick_yahoo_support" value="" class="inputbox" size="40"/>					
					<label id="jform_nick_skype_support-lbl" for="jform_nick_skype_support" class="">Nick Skype</label>					
 					<input type="text" name="jform[nick_skype_support][]" id="jform_nick_skype_support" value="" class="inputbox" size="40"/>					
					<button class="remove-address" type="button">Remove</button>
				</li>			
			</ul>';
		
		return $str;
	}
	
	protected function getCategories($catId = 0)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select('*')->from('#__categories')
				->where('extension = "com_je_product.province"')
				->order('lft')
		;
		
		$db->setQuery($query);
		$rs = $db->loadObjectList('id');
		
		if ($db->getErrorMsg())
			die ($db->getErrorMsg());
		
		$str = '<select id="jform_province_id" name="jform[province_id][]" class="inputbox" size="1">
					<option value="">- Select Province -</option>';
					foreach ($rs as $id => $category)
					{
						$selected = ($category->id == $catId) ? 'selected="selected"' : null;
						
						$str .= '<option value="'.$id.'" '.$selected.'>'.$category->title.'</option>';
					}
		$str .= '	</select>';
		
		return $str;
	}
}
