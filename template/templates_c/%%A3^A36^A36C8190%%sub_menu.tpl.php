<?php /* Smarty version 2.6.18, created on 2018-02-20 12:45:29
         compiled from mpanel/translate/sub_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/translate/sub_menu.tpl', 26, false),)), $this); ?>

<?php $_from = $this->_tpl_vars['aTranslateLanguageList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
<A href="?action=translate_change&amp;content=<?php echo $this->_tpl_vars['aItem']['code']; ?>
" onclick="xajax_process_browse_url(this.href);  return false;">
<IMG border=0 src="<?php echo $this->_tpl_vars['aItem']['image']; ?>
"
		<?php if ($_SESSION['translate']['current_locale'] == $this->_tpl_vars['aItem']['code']): ?>
		width='28' height='20'
		<?php else: ?>
		width='18' height='12'
		<?php endif; ?>

		hspace=3 align=absmiddle>

		<?php if ($_SESSION['translate']['current_locale'] == $this->_tpl_vars['aItem']['code']): ?><font size=+1><?php endif; ?>
			<?php echo $this->_tpl_vars['aItem']['name']; ?>

		<?php if ($_SESSION['translate']['current_locale'] == $this->_tpl_vars['aItem']['code']): ?></font><?php endif; ?>

			</A>
<?php endforeach; endif; unset($_from); ?>



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<a class=submenu href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_trash&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" onclick="
	update_input('main_form','action','<?php echo $this->_tpl_vars['sBaseAction']; ?>
_save');
	update_input('main_form','return','<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
');
	submit_form();
    return false;">

<IMG border=0 src="/libp/mpanel/images/medium/yast_bootmode.png" hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Save'); ?>
</A>


<a class=submenu href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_export_translation"  onclick="
	update_input('main_form','action','<?php echo $this->_tpl_vars['sBaseAction']; ?>
_export_translation');
	submit_form();
    return false;">
	<img border=0 src="/libp/mpanel/images/small/outbox.png"
	hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Export translations'); ?>
</a>

<a href="?action=<?php echo $this->_tpl_vars['sBaseAction']; ?>
_import_translation&amp;return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
"
	onclick="xajax_process_browse_url(this.href); return false;" class="submenu">
	<img hspace="3" border="0" align="absmiddle" src="/libp/mpanel/images/small/inbox.png"/
	><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('Import tranlsations'); ?>
</a>