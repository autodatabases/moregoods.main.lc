<?php /* Smarty version 2.6.18, created on 2018-02-07 21:07:42
         compiled from mpanel/log_admin/search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/log_admin/search.tpl', 13, false),)), $this); ?>
<form id="filter_form" name="filter_form" action="javascript:void(null)" onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th>Filter</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1 width=850>
			<tr>
				<td><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Admin'); ?>
:</td>
				<td><input type=text name=search[login] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aSearch']['login'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" maxlength=20
					style='width: 110px'></td>

				<td><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Date from'); ?>
:</td>
				<td><input id=date_from name=search[date_from] style='width: 80px;'
					readonly="readonly" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aSearch']['date_from'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
					onclick="popUpCalendar(this, this, 'dd.mm.yyyy');"></td>
				<td><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Date To'); ?>
:</td>
				<td><input id=date_to name=search[date_to] style='width: 80px;'
					readonly="readonly" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aSearch']['date_to'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
					onclick="popUpCalendar(this, this, 'dd.mm.yyyy');"></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Action'); ?>
:</td>
				<td><input type=text name=search[action] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aSearch']['action'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" maxlength=20
					style='width: 110px'></td>
				<td><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('TableName'); ?>
:</td>
				<td><input type=text name=search[table_name] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aSearch']['table_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" maxlength=20
					style='width: 110px'></td>
				<td><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('IP'); ?>
:</td>
				<td><input type=text name=search[ip] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aSearch']['ip'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" maxlength=20
					style='width: 110px'></td>
			</tr>
		</table>

		</td>
	</tr>
</table>

<input type=button class='bttn' value="<?php echo $this->_tpl_vars['oLanguage']->getDMessage('Clear'); ?>
"
	onclick="xajax_process_browse_url('?<?php echo ((is_array($_tmp=$this->_tpl_vars['sSearchReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
')">
<input type=submit value='Search' class='bttn'>

<input type=hidden name=action value=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_search>
<input type=hidden name=return value="<?php echo ((is_array($_tmp=$this->_tpl_vars['sSearchReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">

</form>