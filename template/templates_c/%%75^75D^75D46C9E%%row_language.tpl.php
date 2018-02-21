<?php /* Smarty version 2.6.18, created on 2018-02-19 09:50:13
         compiled from addon/mpanel/language/row_language.tpl */ ?>
<td><?php echo $this->_tpl_vars['aRow']['id']; ?>
</td>
<td><?php echo $this->_tpl_vars['aRow']['name']; ?>
 <br />
<font color=blue><?php echo $this->_tpl_vars['aRow']['domain']; ?>
</font></td>
<td><?php echo $this->_tpl_vars['aRow']['code']; ?>
</td>
<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/visible.tpl', 'smarty_include_vars' => array('aRow' => $this->_tpl_vars['aRow'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td><?php if ($this->_tpl_vars['aRow']['image']): ?><img src='<?php echo $this->_tpl_vars['aRow']['image']; ?>
' width='32'><?php endif; ?></td>
<td><?php echo $this->_tpl_vars['aRow']['num']; ?>
</td>
<td nowrap><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_lang_select.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
<td nowrap>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'addon/mpanel/base_row_action.tpl', 'smarty_include_vars' => array('sBaseAction' => $this->_tpl_vars['sBaseAction'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</td>