<?php /* Smarty version 2.6.18, created on 2017-05-23 22:13:01
         compiled from manager/row_order_ship.tpl */ ?>
<?php $_from = $this->_tpl_vars['oTable']->aColumn; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sKey'] => $this->_tpl_vars['item']):
?>
<?php if ($this->_tpl_vars['sKey'] == 'action'): ?>

<?php elseif ($this->_tpl_vars['sKey'] == 'total'): ?>
<td><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['aRow']['total']); ?>
</td>

<?php else: ?><td><?php echo $this->_tpl_vars['aRow'][$this->_tpl_vars['sKey']]; ?>
</td>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>