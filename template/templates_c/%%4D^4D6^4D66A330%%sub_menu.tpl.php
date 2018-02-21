<?php /* Smarty version 2.6.18, created on 2018-02-19 23:04:32
         compiled from addon/mpanel/drop_down_item/sub_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'addon/mpanel/drop_down_item/sub_menu.tpl', 4, false),)), $this); ?>
<a class=submenu href="?action=drop_down" onclick="xajax_process_browse_url(this.href); return false;">
<img border=0 height=32 src="/libp/mpanel/images/small/restore_f2.png" width=32 hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Back'); ?>
</a>

<a href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_add&amp;id_parent=<?php echo $this->_tpl_vars['aRequest']['id_parent']; ?>
&amp;return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
"
	onclick="xajax_process_browse_url(this.href); return false;" class="submenu">
	<img hspace="3" border="0" align="absmiddle" src="/libp/mpanel/images/small/new.png"/
	><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Add new'); ?>
</a>

<a href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_delete&id_parent=<?php echo $this->_tpl_vars['aRequest']['id_parent']; ?>
&amp;return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
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

<a class=submenu href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_trash&id_parent=<?php echo $this->_tpl_vars['aRequest']['id_parent']; ?>
&amp;return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" onclick="

if (confirm_delete_glg())
{
	update_input('main_form','action','<?php echo $this->_tpl_vars['sBaseAction']; ?>
_trash');
	update_input('main_form','return','<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
');
	submit_form();
}  return false;">

<IMG border=0 height=32 src="/libp/mpanel/images/small/trashcan_empty.png" width=32 hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Move to Trash'); ?>
</A>