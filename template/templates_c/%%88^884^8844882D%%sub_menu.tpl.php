<?php /* Smarty version 2.6.18, created on 2018-02-07 21:08:17
         compiled from addon/mpanel/trash/sub_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'addon/mpanel/trash/sub_menu.tpl', 1, false),)), $this); ?>
<a href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_restore&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
"
	onclick="if (confirm_delete_glg())
	{
		update_input('main_form','action','<?php echo $this->_tpl_vars['sBaseAction']; ?>
_restore');
		update_input('main_form','return','<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
');
		submit_form();
	}   return false;" class="submenu">
	<img hspace="3" border="0" align="absmiddle" src="/libp/mpanel/images/small/reload_page.png"/
	><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Restore'); ?>
</a>
<?php if ($this->_tpl_vars['oLanguage']->GetConstant('trash:not_delete',0) == 0): ?>	
<a href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_delete&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
"
	onclick="if (confirm_delete_glg())
	{
		update_input('main_form','action','<?php echo $this->_tpl_vars['sBaseAction']; ?>
_delete');
		update_input('main_form','return','<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
');
		submit_form();
	}   return false;" class="submenu">
	<img hspace="3" border="0" align="absmiddle" src="/libp/mpanel/images/small/delete.png"/
	><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Delete'); ?>
</a>
<?php endif; ?>