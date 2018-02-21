<?php /* Smarty version 2.6.18, created on 2017-05-15 18:53:00
         compiled from cart/cart_onepage_check_new_user.tpl */ ?>
<div class="block-form">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/cart_onepage_delivery.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/cart_onepage_payment.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<button class='gm-button' type='submit' id='end_cart' style='display:none'><?php echo $this->_tpl_vars['oLanguage']->getMessage("Завершить оформление"); ?>
</button>
	</div>
	<div class="block-info">
                <div class="head"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Личные данные"); ?>
</div>
                <div class="gm-block-form">
					<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Phone'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
<span id='check_login_image_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
			    	<input type=text name=data[phone] value='<?php if ($this->_tpl_vars['aUser']['name']): ?><?php echo $this->_tpl_vars['aUser']['phone']; ?>
<?php else: ?><?php echo $_REQUEST['data']['phone']; ?>
<?php endif; ?>' style='width:100%' class='phone'
    	onblur="javascript: xajax_process_browse_url('?action=user_check_login&login='+this.value); return false;">
    	
					</div>
					
					<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Password'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
		<input type=password name=data[password] value='<?php echo $_REQUEST['data']['password']; ?>
'
			 maxlength=50 style='width:100%'>
					</div>

<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Retype Password'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
	<input type=password name=data[verify_password] value='<?php echo $_REQUEST['data']['verify_password']; ?>
'
		 maxlength=50 style='width:100%'>
</div>
	
	<div class="form-element">
					<div class="element-name"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Email'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</div>
		<input type=text name=data[email] value='<?php echo $_REQUEST['data']['email']; ?>
' style='width:100%'>
</div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user/new_account_delivery_info.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="form-element">
		<input type=checkbox name=data[user_agreement] value='1' style="-webkit-appearance: checkbox;"
			<?php if ($_REQUEST['data']['user_agreement']): ?> checked<?php endif; ?>>
		<?php echo $this->_tpl_vars['oLanguage']->getMessage('I agree to'); ?>
 <a href='/pages/agreement' target=_blank
			><?php echo $this->_tpl_vars['oLanguage']->getMessage('User agreement'); ?>
</a>
</div>

 
</div>

</div>