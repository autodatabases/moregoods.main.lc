<?php /* Smarty version 2.6.18, created on 2017-05-16 19:38:44
         compiled from mpanel/customer/sub_menu.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_sub_menu.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'],'not_delete' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <a class=submenu href="?action=customer_clear_test_data"
	onclick="if (confirm('Are you sure?')) xajax_process_browse_url(this.href); return false;">
    <img border=0 src="/libp/mpanel/images/small/delete.png" hspace=3 align=absmiddle><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Clear Test Data'); ?>
</a>