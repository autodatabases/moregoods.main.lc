<?php /* Smarty version 2.6.18, created on 2017-07-09 10:30:12
         compiled from manager/form_add_customer_list_manager.tpl */ ?>
<input type='hidden' name='is_post' value='1' >
<table class="gm-block-order-filter2">
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Sort'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td>
			<input type=text name=data[sort] value='<?php echo $this->_tpl_vars['aData']['sort']; ?>
' maxlength=50 style='width:270px'>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Name'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
		<td>
			<input id="name" type=text name=data[name] value='<?php echo $this->_tpl_vars['aData']['name']; ?>
' maxlength=50 style='width:270px'>
		</td>
	</tr>
</table>