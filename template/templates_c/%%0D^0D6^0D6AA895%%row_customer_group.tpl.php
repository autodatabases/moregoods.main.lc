<?php /* Smarty version 2.6.18, created on 2017-05-24 22:47:23
         compiled from mpanel/customer_group/row_customer_group.tpl */ ?>
<td><?php echo $this->_tpl_vars['aRow']['id']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['cg_name']; ?>
</td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/visible.tpl', 'smarty_include_vars' => array('aRow' => $this->_tpl_vars['aRow'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td><?php echo $this->_tpl_vars['aRow']['group_discount']; ?>
</td>
<!--td><?php echo $this->_tpl_vars['aRow']['group_debt']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['group_debt_percent']; ?>
</td-->
<!--td><?php echo $this->_tpl_vars['aRow']['price_type']; ?>

<?php if ($this->_tpl_vars['aRow']['price_type'] == 'margin'): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/yes_no.tpl', 'smarty_include_vars' => array('bData' => $this->_tpl_vars['aRow']['has_subcustomer'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
</td-->
<td><?php echo $this->_tpl_vars['aRow']['hours_expired_cart']; ?>
</td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_row_edit.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'],'not_delete' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>