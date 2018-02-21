<?php /* Smarty version 2.6.18, created on 2017-07-09 10:30:06
         compiled from manager/button_customer_list_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'manager/button_customer_list_manager.tpl', 2, false),)), $this); ?>
<input type=button class='ar-submit' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Create List'); ?>
" 
	onclick="location.href='/?action=manager_customer_list_add&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
';">