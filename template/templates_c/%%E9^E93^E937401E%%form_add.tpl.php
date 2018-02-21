<?php /* Smarty version 2.6.18, created on 2017-05-16 19:39:10
         compiled from mpanel/user/change_password/form_add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/user/change_password/form_add.tpl', 26, false),)), $this); ?>
<FORM id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Change password'); ?>
</th>
	</tr>
	<tr>
		<td>


<table cellspacing=2 cellpadding=1>
	<tr>
   		<td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Password'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   		<td><input type=password name=data[password] value='<?php echo $this->_tpl_vars['aData']['password']; ?>
'></td>
  	</tr>
  	<tr>
   		<td><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Retype Password'); ?>
:<?php echo $this->_tpl_vars['sZir']; ?>
</td>
   		<td><input type=password name=data[retype_password] value='<?php echo $this->_tpl_vars['aData']['retype_password']; ?>
'></td>
  	</tr>
</table>


	</td></tr>
</table>

<input type=hidden name=data[id] value="<?php echo ((is_array($_tmp=$this->_tpl_vars['aData']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_add_button.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<input type=hidden name=action value=user_change_password_apply>
</FORM>