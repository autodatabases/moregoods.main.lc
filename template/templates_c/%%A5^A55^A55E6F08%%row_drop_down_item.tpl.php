<?php /* Smarty version 2.6.18, created on 2018-02-19 23:04:32
         compiled from addon/mpanel/drop_down_item/row_drop_down_item.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'addon/mpanel/drop_down_item/row_drop_down_item.tpl', 14, false),)), $this); ?>
<td nowrap><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/drop_down/id.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td><?php echo $this->_tpl_vars['aRow']['name']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['code']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['num']; ?>
</td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/visible.tpl', 'smarty_include_vars' => array('aRow' => $this->_tpl_vars['aRow'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td nowrap><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_lang_select.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<?php if ($this->_tpl_vars['oLanguage']->GetConstant('user_role:is_available')): ?>
<td>
	<?php echo $this->_tpl_vars['oADropDownItem']->GetRoleCheckbox($this->_tpl_vars['aRow']['id']); ?>

</td>
<?php endif; ?>
<td>
<nobr>
<A href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_edit&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&amp;id_parent=<?php echo $this->_tpl_vars['aRequest']['id_parent']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" onclick="
xajax_process_browse_url(this.href); return false;">
<IMG class=action_image border=0 src="/libp/mpanel/images/small/edit.png"  hspace=3 align=absmiddle
	><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Edit'); ?>
</A>
</nobr>

<nobr>
<A href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_delete&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&amp;id_parent=<?php echo $this->_tpl_vars['aRequest']['id_parent']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
"
	onclick="if (confirm_delete_glg())
	xajax_process_browse_url(this.href);  return false;">
	<IMG border=0 class=action_image src="/libp/mpanel/images/small/del.png" hspace=3 align=absmiddle
	><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Delete'); ?>
</A></nobr>
</td>