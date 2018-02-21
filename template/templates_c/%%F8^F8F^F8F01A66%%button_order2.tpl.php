<?php /* Smarty version 2.6.18, created on 2017-05-19 09:37:33
         compiled from cart/button_order2.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/popup_dolg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



<?php if ($this->_tpl_vars['aBonus'] < 0): ?><span style="padding:5px 0 0 0;" 
	onclick="popupOpen('.js-popup-auth2');"><?php endif; ?>
	<input type="hidden" name="action" value="cart_onepage_order_manager">
	<?php if ($this->_tpl_vars['aBonus'] > 0): ?><input type=button class='btn' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Update and pay'); ?>
"  onclick="this.form.submit();"><?php endif; ?>
<?php if ($this->_tpl_vars['aBonus'] < 0): ?></span><?php endif; ?>