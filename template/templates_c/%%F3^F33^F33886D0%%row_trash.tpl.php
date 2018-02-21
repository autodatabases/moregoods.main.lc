<?php /* Smarty version 2.6.18, created on 2018-02-07 21:08:17
         compiled from addon/mpanel/trash/row_trash.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'addon/mpanel/trash/row_trash.tpl', 5, false),array('modifier', 'escape', 'addon/mpanel/trash/row_trash.tpl', 8, false),)), $this); ?>
<td><?php echo $this->_tpl_vars['aRow']['id']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['name']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['action']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['id_element']; ?>
</td>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['trashed_timestamp'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d/%m/%Y %H:%M:%S")); ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['size']; ?>
</td>
<td nowrap>
<A href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_restore&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" onclick="if (confirm_delete_glg())
xajax_process_browse_url(this.href);  return false;">
<IMG border=0 class=action_image src="/libp/mpanel/images/small/reload_page.png" hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Restore'); ?>
</A>

<?php if ($this->_tpl_vars['oLanguage']->GetConstant('trash:not_delete',0) == 0): ?>
<A href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_delete&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" onclick="if (confirm_delete_glg())
xajax_process_browse_url(this.href);  return false;">
<IMG border=0 class=action_image src="/libp/mpanel/images/small/del.png" hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Delete'); ?>
</A>
<?php endif; ?>
</td>