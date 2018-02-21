<?php /* Smarty version 2.6.18, created on 2017-05-24 22:47:23
         compiled from addon/mpanel/base_row_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'addon/mpanel/base_row_edit.tpl', 2, false),)), $this); ?>
<nobr>
<A href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_edit&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" onclick="
xajax_process_browse_url(this.href); return false;">
<IMG class=action_image border=0 src="/libp/mpanel/images/small/edit.png"
	hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Edit'); ?>
</A>
</nobr>