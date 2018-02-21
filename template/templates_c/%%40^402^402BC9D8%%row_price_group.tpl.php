<?php /* Smarty version 2.6.18, created on 2018-02-08 12:16:41
         compiled from price_group/row_price_group.tpl */ ?>
<?php $_from = $this->_tpl_vars['oTable']->aColumn; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sKey'] => $this->_tpl_vars['item']):
?>
<?php if ($this->_tpl_vars['sKey'] == 'action'): ?>
<td><a href="/select/<?php echo $this->_tpl_vars['aRow']['code_name']; ?>
/"
	><?php echo $this->_tpl_vars['aRow']['name']; ?>
</a>
</td>
<?php else: ?>
<td><?php echo $this->_tpl_vars['aRow'][$this->_tpl_vars['sKey']]; ?>
</td>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>