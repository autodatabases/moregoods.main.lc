<?php /* Smarty version 2.6.18, created on 2018-02-19 23:24:26
         compiled from message/browse_bottom.tpl */ ?>
<table cellpadding="0" cellspacing="10" border="0" width="100%" align="center">
<tr>
	<td><input class=btn type=button value='<?php echo $this->_tpl_vars['oLanguage']->getMessage('Compose'); ?>
'
		onclick="change_form_action('message_form_id','message_compose');"></td>
	<td><!--input class=btn type=button value='<?php echo $this->_tpl_vars['oLanguage']->getMessage('Forward'); ?>
'
		onclick="change_form_action('message_form_id','message_forward');"-->
	&nbsp;&nbsp;&nbsp;
	</td>

	<td><input class=btn type=button value='<?php echo $this->_tpl_vars['oLanguage']->getMessage('To archive'); ?>
'
		onclick="if (confirm('Delete?')) change_form_action('message_form_id','message_delete');"></td>


		<td nowrap width="50%" align="right"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Move to folder'); ?>
</td>
		<td width="99%">
		<select name=move_to_folder>
			<option value=1><?php echo $this->_tpl_vars['oLanguage']->getMessage('Inbox'); ?>
</option>
			<option value=2><?php echo $this->_tpl_vars['oLanguage']->getMessage('Outbox'); ?>
</option>
			<option value=3><?php echo $this->_tpl_vars['oLanguage']->getMessage('Draft'); ?>
</option>
			<option value=4><?php echo $this->_tpl_vars['oLanguage']->getMessage('Archived'); ?>
</option>
		</select>
&nbsp;&nbsp;
		<input class=btn type=button value='<?php echo $this->_tpl_vars['oLanguage']->getMessage('Move'); ?>
'
			onclick="change_form_action('message_form_id','message_move_to_folder');">
		</td>
</tr>
</table>