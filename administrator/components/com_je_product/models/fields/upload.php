<script type="text/javascript">
<!--
window.addEvent('domready', function(){
	$('btn-add-upload-file').addEvent('click', function(){
		var html = $('tmpl-row').get('html');

		var tableRowObject = new Element('tr', { html: html });
		tableRowObject.inject($('tmpl-row'), 'before');

		return false;
	});

	$('div-upload').addEvent('click:relay(button.del-upload-file)', function(){
		this.getParent().getParent().destroy();
	});
});
//-->
</script>
<?php
/**
 * @version		$Id: upload.php $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Bannerclient Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_je_product
 * @since		1.6
 */
class JFormFieldUpload extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Upload';
	
	public function getInput()
	{
		$html  = '<div style="float: left; width: 300px;" id="div-upload">';
		$html .= '<input type="hidden" name="old-upload-file" value="'.addslashes($this->value).'" />';
		
		$html .= '<div>
					<button type="button" id="btn-add-upload-file" style="padding: 2px 10px; cursor: pointer; font-weight: bold; font-size: 11px;">
						Thêm file upload
					</button>
				</div>';
		$html .= '<table>
					<tr>
						<th>Lựa chọn file</th>
						<th>Thứ tự</th>
						<th>&nbsp;</th>
					</tr>';
		$html .= '	<tr>	
						<td><input type="file" name="'.$this->name.'[]" /></td>
						<td><input type="text" size="5" name="'.$this->name.'[order][]" />
						<td>&nbsp;</td>
					</tr>';
		$html .= '	<tr id="tmpl-row" style="display: none;">	
						<td><input type="file" name="'.$this->name.'[]" /></td>
						<td><input type="text" size="5" name="'.$this->name.'[order][]" />
						<td><button type="button" class="del-upload-file" style="font-size: 10px;">xóa</button></td>
					</tr>';
		$html .= '</table>';
		$html .= '</div>';
		
		return $html;
	}
}
