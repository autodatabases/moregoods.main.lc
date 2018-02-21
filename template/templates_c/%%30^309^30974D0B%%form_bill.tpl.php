<?php /* Smarty version 2.6.18, created on 2017-05-24 20:40:36
         compiled from finance/form_bill.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'finance/form_bill.tpl', 20, false),)), $this); ?>
<table class="gm-block-order-filter2 no-mobile">
<?php if ($_REQUEST['code_template'] == 'order_bill'): ?>
	<tr>
   		<td><?php echo $this->_tpl_vars['oLanguage']->getMessage('Id cart package'); ?>
:</td>
   		<td><input type=text name=data[id_cart_package] value='<?php echo $this->_tpl_vars['aData']['id_cart_package']; ?>
' style='width:352px'></td>
  	</tr>
<?php endif; ?>

<?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
	<tr>
   		<td width=50%><?php echo $this->_tpl_vars['oLanguage']->getMessage('Login'); ?>
:</td>
   		<td nowrap><input type=text name=data[login] value='<?php echo $this->_tpl_vars['aData']['login']; ?>
' maxlength=50 style='width:352px'></td>
  	</tr>
<?php endif; ?>

  	<tr>
   		<td width=50%><?php echo $this->_tpl_vars['oLanguage']->getMessage('Account'); ?>
: <?php echo $this->_tpl_vars['sZir']; ?>
</td>
   		<td>
   		 <div class="options">
   		<?php echo smarty_function_html_options(array('class' => "js-uniform",'id' => 'menu_select','name' => "data[id_account]",'options' => $this->_tpl_vars['aAccount'],'selected' => $this->_tpl_vars['aData']['id_account']), $this);?>

   		</div>
   		</td>
  	</tr>

	<tr>
   		<td width=50%><?php echo $this->_tpl_vars['oLanguage']->getMessage('Amount'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   		<td nowrap><input type=text name=data[amount]
			value='<?php if ($this->_tpl_vars['aData']['amount']): ?><?php echo $this->_tpl_vars['aData']['amount']; ?>
<?php else: ?><?php echo $_REQUEST['amount']; ?>
<?php endif; ?>'
			maxlength=50 style='width:429px'></td>
  	</tr>
</table>

<input type=hidden name=data[code_template] value='<?php echo $this->_tpl_vars['sCodeTemplate']; ?>
'>