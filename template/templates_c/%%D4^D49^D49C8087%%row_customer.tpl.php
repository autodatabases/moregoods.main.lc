<?php /* Smarty version 2.6.18, created on 2017-05-16 19:38:45
         compiled from mpanel/customer/row_customer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'mpanel/customer/row_customer.tpl', 26, false),)), $this); ?>
<td><?php echo $this->_tpl_vars['aRow']['login']; ?>

<br><font color='grey'><?php echo $this->_tpl_vars['oLanguage']->GetDMessage('tm'); ?>
:<?php echo $this->_tpl_vars['aRow']['manager_login']; ?>
</font>
</td>
<td><?php echo $this->_tpl_vars['aRow']['id']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['customer_name']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['phone']; ?>
</td>
<td>
<?php echo $this->_tpl_vars['aRow']['customer_group_name']; ?>

</td>
<td>
<?php echo $this->_tpl_vars['aRow']['customer_type_name']; ?>

</td>
<td><?php echo $this->_tpl_vars['aRow']['email']; ?>
<br><font color='grey'><?php echo $this->_tpl_vars['aRow']['post_date']; ?>
</font>
<br><font color='green'><?php echo $this->_tpl_vars['aRow']['post_date']; ?>
</font> </td>
<td><?php echo $this->_tpl_vars['aRow']['region']; ?>
</td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/visible.tpl', 'smarty_include_vars' => array('aRow' => $this->_tpl_vars['aRow'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/yes_no.tpl', 'smarty_include_vars' => array('bData' => $this->_tpl_vars['aRow']['approved'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>

<td nowrap>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_row_action.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'],'not_delete' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<br>

<a href="<?php echo '?action=user_change_password&id='; ?><?php echo $this->_tpl_vars['aRow']['id']; ?><?php echo '&return='; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?><?php echo ''; ?>
"
	onclick="xajax_process_browse_url(this.href); return false;">
	<img border=0 src="/libp/mpanel/images/small/copy.png"  hspace=3 align=absmiddle
		/><?php echo $this->_tpl_vars['oLanguage']->getDMessage('Change password'); ?>
</a>
</td>