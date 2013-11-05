<?php
/**
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Sub Brand Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @since		1.6
 */
class JFormFieldSubBrand extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'SubBrand';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getInput()
	{
		// get form value of field: ID
		$id = $this->form->getValue('id');
		
		// get sub brands
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		$query->select('*')->from('#__je_sub_brands')->where('brand_id = ' . (int) $id);
		
		$db->setQuery($query);
		
		$rs = $db->loadObjectList();
		
		$html = array();
		
		$html[] = '<div id="sub-brand">';
		$html[] = '		<button type="button" id="add-sub-brand">Add sub brand</button>';
		
		foreach ($rs as $subBrand)
		{
			$html[] = '		<div class="sub-brand-tmpl">';
			$html[] = '			<div class="removed"><a href="#" class="remove-sub-brand">Remove this sub brand</a></div>';
			$html[] = '			<div class="sub-brand-logo">';	
			
			if ($subBrand->logo)
			{
				$html[] = '			<img src="'. JURI::root() .$subBrand->logo.'" />';
				$html[] = '			<input type="hidden" name="sub_brand_logo_uploaded[]" value="'. base64_encode($subBrand->logo) .'" />';
			}
			
			$html[] = '			</div>';		
			$html[] = '			<ul>';
			$html[] = '				<li><span>Title :</span> <input type="text" name="sub_brand_title[]" value="'.$subBrand->title.'" /></li>';		
			$html[] = '				<li><span>Desc :</span> <textarea name="sub_brand_desc[]">'.$subBrand->description.'</textarea></li>';		
			$html[] = '				<li><span>File :</span> <input type="file" name="jform[sub_brand_logo][]" /></li>';	
			$html[] = '			</ul>';		
			$html[] = '		</div>';
		}
		
		$html[] = '		<div id="list-sub-brand-tmpl" class="sub-brand-tmpl">';
		$html[] = '			<div class="removed"><a href="#" class="remove-sub-brand">Remove this sub brand</a></div>';
		$html[] = '			<div class="sub-brand-logo">';
		$html[] = '			</div>';
		$html[] = '			<ul>';
		$html[] = '				<li><span>Title :</span> <input type="text" name="sub_brand_title[]" /></li>';
		$html[] = '				<li><span>Desc :</span> <textarea name="sub_brand_desc[]"></textarea></li>';
		$html[] = '				<li><span>File :</span> <input type="file" name="jform[sub_brand_logo][]" /></li>';
		$html[] = '				<li><a href="#" class="remove-sub-brand">Remove</a></li>';
		$html[] = '			</ul>';
		$html[] = '		</div>';
			
		$html[] = '</div>';
		
		$strHtml = implode("\r\n", $html);
		
		return $strHtml;
	}
}

?>

<style>
<!--
.removed { padding: 5px; margin-bottom: 0px; background: #333; }
.removed a { color: #FFF; }

#list-sub-brand-tmpl { display: none; }
#sub-brand { float: left; border: 0px solid #CCC; padding: 0; }
.sub-brand-tmpl { clear: both; display-none; margin-bottom: 10px; float: left; border-bottom: 1px solid #CCC; padding-bottom: 10px; }
.sub-brand-tmpl span { float: left; line-height: 23px; width: 40px; }
.sub-brand-tmpl input { width: 200px !important; }
.sub-brand-tmpl textarea { width: 196px !important; }
.sub-brand-tmpl ul { float: left; width: 300px; }
.sub-brand-tmpl ul li { width: 100%; float: left; margin-bottom: 0px; }
.sub-brand-logo img { width: 100px; margin: 0; }
.sub-brand-tmpl .sub-brand-logo { float: left; width: 100px; height: 100px; border: 0px solid #CCC; overflow: hidden; margin-right: 10px; }
-->
</style>

<script type="text/javascript">
<!--
window.addEvent('domready', function(){
	$('add-sub-brand').addEvent('click', function(){
		var html = $('list-sub-brand-tmpl').get('html');

		var myElement  = new Element('div', {'html': html, 'class': 'sub-brand-tmpl'});

		myElement.inject($('sub-brand'));

		return false;
	});

	$(document.body).addEvent('click:relay(.remove-sub-brand)', function(){
		this.getParent().getParent().destroy();
		return false;
	});
});
//-->
</script>
