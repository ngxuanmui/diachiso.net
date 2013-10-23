<style type="text/css">
<!--
.msg {
	text-align:left;
	color: blue;
	display: block;
	padding: 5px 0;
}

.emsg {
	text-align:left;
	color: red;
	display: block;
	padding: 5px 0;
}

#loader{
   visibility:hidden;
}

#f1_error{
   font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
   font-weight:bold;
   color:#FF0000;
}

#f1_ok{
   font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
   font-weight:bold;
   color:#00FF00;

}

#f1_upload_process {
   z-index:100;
   visibility:hidden;
   position:absolute;
   margin: 10px 0 0;
   width:220px;
}

#f1_upload_process span { display: block; padding-left: 7px; }
-->
</style>
<script language="javascript" type="text/javascript">
<!--
function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success, msg, src){
      var result = '';
      if (success == 1){
         result = '<span class="msg">The file was uploaded successfully!<\/span>';

         var ed = tinyMCE.get('jform_content');                // get editor instance
         var newNode = ed.getDoc().createElement ( "img" );  // create img node
         newNode.src = src;                           // add src attribute
         ed.execCommand('mceInsertContent', false, newNode.outerHTML);
      }
      else {
         result = '<span class="emsg">There was an error during file upload!<\/span>';
      }

      result += '<input type="hidden" name="path_2_upload" value="<?php echo base64_encode(JPATH_ROOT . DS . 'tmp' . DS . session_id() . DS); ?>" />';
      result += '<input type="hidden" name="link_2_upload" value="<?php echo base64_encode(JURI::root() . 'tmp/' . session_id() .'/'); ?>" />';
      
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<input name="myfile" type="file" size="30" style="float:left;" /><input type="button" name="submitBtn" id="submitBtn" class="sbtn" value="Upload" style="float: left;" />';
      
      document.getElementById('f1_upload_form').style.visibility = 'visible';
        
      return true;   
}

window.addEvent('domready', function(){
	// $$('#submitBtn').addEvent('click', function(e){
	document.body.addEvent('click:relay(#submitBtn)', function(e){
		var action = '<?php echo JURI::base(); ?>jelibs/ajaxupload/upload.php';
		var formAction = $$('form[name="userForm"]').get('action');
		$$('form[name="userForm"]').set('target', 'upload_target').set('action', action);
		
		startUpload();

		document.userForm.submit();
		$$('form[name="userForm"]').set('target', '').set('action', formAction);
	});
});
//-->
</script>

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
class JFormFieldFront_Images2Content extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Front_Images2Content';
	
	public function getInput()
	{
		$html  = '<div>';
		
		$html .= '<p id="f1_upload_process"><span>Loading...</span><img src="'.JURI::base().'jelibs/ajaxupload/loader.gif" /><br/></p>
                     <p id="f1_upload_form" align="center">
						<br />
						<span style="float: left;">Upload images to content</span>
						<br/>
                        <input name="myfile" type="file" size="30" style="float: left;" />
      					<input type="hidden" name="path_2_upload" value="'.base64_encode(JPATH_ROOT . DS . 'tmp' . DS . session_id() . DS) .'" />
      					<input type="hidden" name="link_2_upload" value="'.base64_encode(JURI::root() . 'tmp/' . session_id() . '/') .'" />
                        <input type="button" name="submitBtn" id="submitBtn" class="sbtn" value="Upload" style="float: left;" />
      					
                     </p>
                     <iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>
                 ';
		
		$html .= '<div class="clr"></div></div>';
		
		return $html;
	}
}
