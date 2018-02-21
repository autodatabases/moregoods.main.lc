<?php /* Smarty version 2.6.18, created on 2018-01-13 20:18:21
         compiled from mpanel/general_constant/row_general_constant.tpl */ ?>
<td><b><?php echo $this->_tpl_vars['aRow']['key_']; ?>
</b></td>
<td><?php if ($this->_tpl_vars['aRow']['type_data'] == 'checkbox'): ?>
		<?php if ($this->_tpl_vars['aRow']['value'] == 1): ?>
			<span style="color:green;font-weight:bold;"><?php echo $this->_tpl_vars['oLanguage']->getMessage('ON'); ?>
</span>
		<?php else: ?>
			<span style="color:red;font-weight:bold;"><?php echo $this->_tpl_vars['oLanguage']->getMessage('OFF'); ?>
</span>
		<?php endif; ?>
	<?php elseif ($this->_tpl_vars['aRow']['key_'] == 'favicon'): ?>
		<img src="<?php echo $this->_tpl_vars['aRow']['value']; ?>
">
	<?php else: ?>
		<?php echo $this->_tpl_vars['aRow']['value']; ?>

	<?php endif; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['description']; ?>
</td>
<td nowrap>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_row_edit.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</td>