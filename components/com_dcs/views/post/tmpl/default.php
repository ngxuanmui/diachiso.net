<?php
// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.modal');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$user = JFactory::getUser();
?>

<style>
<!--
.clr {
	 clear:both;
	 }
-->
</style>


<form method="post" action="<?php echo JRoute::_('index.php?option=com_je_product&task=post.submit'); ?>" class="form-validate" enctype="multipart/form-data">
<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
 <?php if ($fieldset->name == 'contact' && $user->id) continue; ?>
<h1><?php echo $fieldset->label; ?></h1>
	<ul>
          <?php //if ($fieldset->name == 'post'):?>
               <?php $fields = $this->form->getFieldset($fieldset->name);?>
               <?php foreach($fields as $field): ?>
               <?php //var_dump($field); ?>
                    <?php if ($field->hidden): ?>
                         <?php echo $field->input;?>
                    <?php else:?>
                         <li>
                         	<label>
	                            <?php echo $field->label; ?>
                            </label>
                            <?php echo $field->input;?>
                            
                            <?php if($field->fieldname == 'images'): ?>
                            	<?php if($this->item->images): ?>
                            		<div style="float: right;">
                            			<a href="images/je_products/<?php echo $this->item->images; ?>" class="modal">
                            				<img alt="Image" src="images/je_products/<?php echo $this->item->images; ?>" width="100">
                            			</a>
                            			
                            		</div>
                            	<?php endif; ?>
                            <?php endif; ?>
                         </li>
                    <?php endif;?>
               <?php endforeach;?>
          <?php //endif ?>
	</ul>
	<div class="clr"></div>
<?php endforeach;?>

<?php if(!$user->id): ?>
<h1>Xác nhận</h1>
<ul>
	<li>
     	<div class="clr" style="clear:both;"></div>
     	<label><?php echo $this->form->getLabel('scode'); ?></label>
     	<img src="index.php?option=com_kcaptcha&view=kcaptcha&<?php echo session_name()?>=<?php echo session_id(); ?>" border="0" alt="Captcha image" />
     	Refresh
     </li>
     <li>
     	<label>&nbsp;</label>
     	<?php echo $this->form->getInput('scode'); ?>
     </li>
     <li>
     	<label>&nbsp;</label>
     	(Nhập mã xác nhận)
     </li>
</ul>
<?php endif; ?>
	<div>
     	<label>&nbsp;</label>
     	
     	<button type="submit">
     		<?php if($this->item->id): ?>
     		Sửa thông tin
     		<?php else: ?>
     		Đăng thông tin
     		<?php endif; ?>
     	</button>
     	
     	<button type="button" onclick="location.href='<?php echo JRoute::_('index.php?option=com_je_product&task=post.cancel'); ?>'">
     		Hủy
     	</button>
     </div>

	<?php echo JHtml::_('form.token'); ?>

</form>