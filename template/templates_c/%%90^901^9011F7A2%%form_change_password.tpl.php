<?php /* Smarty version 2.6.18, created on 2018-02-19 22:58:03
         compiled from user/form_change_password.tpl */ ?>
<table>
	<tr>
		<td><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Old password'); ?>
:</td>
   		<td > <input type=password name=data[old_password] value="<?php echo $_REQUEST['data']['old_password']; ?>
"></td>
   	</tr>
	<tr>
		<td ><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('New password'); ?>
:</td>
   		<td > <input type=password name=data[new_password] value="<?php echo $_REQUEST['data']['new_password']; ?>
"></td>
   	</tr>
	<tr>
		<td ><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Retype new password'); ?>
:</td>
   		<td > <input type=password name=data[retype_new_password] value="<?php echo $_REQUEST['data']['retype_new_password']; ?>
"></td>
   	</tr>

</table>