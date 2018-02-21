<?php /* Smarty version 2.6.18, created on 2017-05-24 20:40:46
         compiled from finance/form_bill_search.tpl */ ?>
<table width=100% border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Login'); ?>
:</b></td>
		<td><input type=text name=search[login] value='<?php echo $_REQUEST['search']['login']; ?>
' maxlength=20 style='width:110px'></td>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Fio'); ?>
:</b></td>
		<td><input type=text name=search[fio] value='<?php echo $_REQUEST['search']['fio']; ?>
' maxlength=20 style='width:110px'></td>
	</tr>
	
</table>