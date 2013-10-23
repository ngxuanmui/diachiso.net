<link href="<?php echo JURI::base(); ?>components/com_je_content/helpers/ajaxupload/style/style.css" rel="stylesheet" type="text/css" />

<?php
/**
 * @version		$Id: images2content.php 21097 2011-04-07 15:38:03Z dextercowley $
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
 * @subpackage	com_banners
 * @since		1.6
 */
class JFormFieldImages2Content extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Images2Content';
	
	public function getInput()
	{
		$rel = $this->element['rel'] ? $this->element['rel'] : 'content';
		
		$html  = '<div>';
		
		$html .= '<p id="f1_upload_process"><span>Loading...</span><img src="'.JURI::base().'components/com_je_content/helpers/ajaxupload/loader.gif" /><br/></p>
                     <p id="f1_upload_form" align="center">
						<br />
						<span style="float: left; font-size: 0.8em;">Upload images to content</span>
						<br/>
                        <input name="myfile" type="file" size="30" />
      					<input type="hidden" name="path_2_upload" value="'.base64_encode(JPATH_ROOT . DS . 'tmp' . DS . session_id() . DS) .'" />
      					<input type="hidden" name="link_2_upload" value="'.base64_encode(JURI::root() . 'tmp/' . session_id() . '/') .'" />
                        <input type="button" name="submitBtn" id="submitBtn" class="sbtn" value="Upload" />
                     </p>
                     <iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>
      				<span id="element_content_id" rel="'.$rel.'"></span>
                 ';
		
		$html .= '</div>';
		
		return $html;
	}
}

?>

<script type="text/javascript">
<!--
function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success, msg, src){
      var result = '';
      if (success == 1){
         result = '<span class="msg" style="font-size: 0.8em;">The file was uploaded successfully!<\/span>';

         var ed = tinyMCE.get('jform_' + $('element_content_id').get('rel'));                // get editor instance
         var newNode = ed.getDoc().createElement ( "img" );  // create img node
         newNode.src = src;                           // add src attribute
         ed.execCommand('mceInsertContent', false, newNode.outerHTML);
      }
      else {
         result = '<span class="emsg" style="font-size: 0.8em;">There was an error during file upload!<\/span>';
      }

      result += '<input type="hidden" name="path_2_upload" value="<?php echo base64_encode(JPATH_ROOT . DS . 'tmp' . DS . session_id() . DS); ?>" />';
      result += '<input type="hidden" name="link_2_upload" value="<?php echo base64_encode(JURI::root() . 'tmp/' . session_id() .'/'); ?>" />';
      
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<input name="myfile" type="file" size="30" /><input type="button" name="submitBtn" id="submitBtn" class="sbtn" value="Upload" />';
      
      document.getElementById('f1_upload_form').style.visibility = 'visible';
        
      return true;   
}

window.addEvent('domready', function(){
	// $$('#submitBtn').addEvent('click', function(e){
	document.body.addEvent('click:relay(#submitBtn)', function(e){

		var formAction = $$('form[name="adminForm"]').get('action');
		
		var action = '<?php echo JURI::base(); ?>components/com_je_content/helpers/ajaxupload/upload.php';
		$$('form[name="adminForm"]').set('target', 'upload_target').set('action', action);
		
		startUpload();

		document.adminForm.submit();

		// resset form action
		$$('form[name="adminForm"]').set('target', '').set('action', formAction);
	});
});
//-->
</script>