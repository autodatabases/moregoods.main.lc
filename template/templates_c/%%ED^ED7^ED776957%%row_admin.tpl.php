<?php /* Smarty version 2.6.18, created on 2018-02-07 19:49:47
         compiled from addon/mpanel/admin/row_admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'addon/mpanel/admin/row_admin.tpl', 14, false),)), $this); ?>
<td><?php echo $this->_tpl_vars['aRow']['id']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['login']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['name']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['last_login']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['now_login']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['last_referer']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['now_referer']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['type_']; ?>
</td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/yes_no.tpl', 'smarty_include_vars' => array('bData' => $this->_tpl_vars['aRow']['is_base_denied'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_row_action.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ('4.5.1' == $this->_tpl_vars['oLanguage']->GetConstant('module_version:aadmin')): ?>
<a href="<?php echo '?action=admin_change_password&id='; ?><?php echo $this->_tpl_vars['aRow']['id']; ?><?php echo '&return='; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?><?php echo ''; ?>
"
	onclick="xajax_process_browse_url(this.href); return false;">
	<img border=0 src="/libp/mpanel/images/small/copy.png"  hspace=3 align=absmiddle
		/><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Change password'); ?>
</a>
<?php endif; ?>
</td>