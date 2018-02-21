<?php /* Smarty version 2.6.18, created on 2018-02-19 17:13:32
         compiled from user/restore_password.tpl */ ?>
<table>
	<tr>
		<td valign=top width=170><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Login'); ?>
:</td>
   		<td valign=center width=200> <input type=text name=login value="<?php echo $_REQUEST['login']; ?>
"></td>
   	</tr>
   	<tr>
		<td valign=top width=370 align=left colspan=2><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('OR'); ?>
</td>
	</tr>
   	<tr>
		<td valign=top width=170><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('Your email'); ?>
:</td>
   		<td valign=center width=200> <input type=text name=email value="<?php echo $_REQUEST['email']; ?>
"></td>
	</tr>
</table>