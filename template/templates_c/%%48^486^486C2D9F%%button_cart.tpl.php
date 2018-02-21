<?php /* Smarty version 2.6.18, created on 2017-05-19 13:02:36
         compiled from cart/button_cart.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'cart/button_cart.tpl', 23, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart/popup_dolg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table border=0 width=99%>
<tr><td width=70%>
<?php if ($this->_tpl_vars['aItem']): ?>
<?php if ($this->_tpl_vars['aAuthUser']['type_'] != 'manager'): ?>
	<?php if ($this->_tpl_vars['aBonus'] < 0): ?>
<a href="javascript:void(0);" onclick="popupOpen('.js-popup-auth2');"><?php endif; ?><input type=button class='btn order-package-btn' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage("Продолжить заказ"); ?>
"
	<?php if ($this->_tpl_vars['aBonus'] < 0): ?> onclick="" <?php else: ?> onclick="javascript: location.href='/?action=cart_onepage_order'"<?php endif; ?> />
	<?php if ($this->_tpl_vars['aBonus'] < 0): ?></a><?php endif; ?>
<?php else: ?>
<input type=button class='btn order-package-btn' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage("Продолжить заказ"); ?>
"
	 onclick="javascript: location.href='/?action=cart_onepage_order_manager'"/>
	<?php endif; ?>
	
	
<?php if ($this->_tpl_vars['bAllowEditOrder']): ?>
<input type=button class='btn order-package-btn' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('add to existing order'); ?>
"
	onclick="javascript: location.href='/pages/cart_add_to_order/?id_order='+document.getElementById('existing_order').options[document.getElementById('existing_order').selectedIndex].value;" />
	
<select name="existing_order" class="js-uniform" id="existing_order">
	<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['aOrderAvailable']), $this);?>

</select>
<?php endif; ?>

<?php endif; ?>


</td>
</tr>
</table>

<br>
<br>