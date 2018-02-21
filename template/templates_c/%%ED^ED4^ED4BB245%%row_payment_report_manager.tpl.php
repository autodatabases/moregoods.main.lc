<?php /* Smarty version 2.6.18, created on 2017-07-09 12:52:50
         compiled from payment_report/row_payment_report_manager.tpl */ ?>
<?php $_from = $this->_tpl_vars['oTable']->aColumn; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sKey'] => $this->_tpl_vars['item']):
?>
<td class="cell-name2">
<?php if (( $this->_tpl_vars['sKey'] == 'action' )): ?>

<a href="/?action=manager_export_bill&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
">Export</a>
<?php elseif (( $this->_tpl_vars['sKey'] == 'payment_date' )): ?>
	<nobr><?php echo $this->_tpl_vars['aRow'][$this->_tpl_vars['sKey']]; ?>
</nobr>
<?php else: ?>
    <?php if ($this->_tpl_vars['sKey'] == 'user'): ?>
	<?php echo $this->_tpl_vars['oLanguage']->AddOldParser('customer',$this->_tpl_vars['aRow']['id_user']); ?>

    <?php else: ?>
	<?php echo $this->_tpl_vars['aRow'][$this->_tpl_vars['sKey']]; ?>

    <?php endif; ?>
<?php endif; ?>
</td>
<?php endforeach; endif; unset($_from); ?>