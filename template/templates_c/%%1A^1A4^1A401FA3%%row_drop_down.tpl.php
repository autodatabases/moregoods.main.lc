<?php /* Smarty version 2.6.18, created on 2018-02-07 16:30:19
         compiled from addon/mpanel/drop_down/row_drop_down.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'addon/mpanel/drop_down/row_drop_down.tpl', 15, false),)), $this); ?>
<td style="padding-left:<?php echo $this->_tpl_vars['aRow']['level']*12-12; ?>
px" nowrap>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/drop_down/id.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</td>
<td style="padding-left:<?php echo $this->_tpl_vars['aRow']['level']*12-12; ?>
px"><b><?php echo $this->_tpl_vars['aRow']['name']; ?>
</b></td>
<td><?php echo $this->_tpl_vars['aRow']['code']; ?>
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
<td>
<?php if ($this->_tpl_vars['aRow']['level'] > 1): ?>
	<A href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_item&id_parent=<?php echo $this->_tpl_vars['aRow']['id']; ?>
" onclick="
	xajax_process_browse_url(this.href); return false;">
	<img class=action_image border=0 src="/libp/mpanel/images/small/list.png"  hspace=3
		align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Browse Items'); ?>
</a>
<?php else: ?>
	<A href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_add&add_sub=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" onclick="
	xajax_process_browse_url(this.href); return false;">
	<IMG class=action_image border=0 src="/libp/mpanel/images/small/view_sidetree.png"
			hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Add Sub'); ?>
</A>
<?php endif; ?>

<A href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_add&add_after=<?php echo $this->_tpl_vars['aRow']['id_parent']; ?>
&num=<?php echo $this->_tpl_vars['aRow']['num']+1; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" onclick="
xajax_process_browse_url(this.href); return false;">
<IMG class=action_image border=0 src="/libp/mpanel/images/small/view_right.png"
		hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Add After'); ?>
</A>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_row_action.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</td>