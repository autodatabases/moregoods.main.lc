<?php /* Smarty version 2.6.18, created on 2017-05-23 22:15:12
         compiled from manager/row_debt.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'manager/row_debt.tpl', 8, false),)), $this); ?>
<td class="cell-name_m"><?php echo $this->_tpl_vars['aRow']['name']; ?>
</td>
<td class="cell-name_m"><?php echo $this->_tpl_vars['aRow']['addr']; ?>
</td>
<td class="cell-name_m"><?php echo $this->_tpl_vars['aRow']['dist']; ?>
</td>

<td class="cell-name_m"><?php echo $this->_tpl_vars['aRow']['num']; ?>
</td>
<td class="cell-name_m"><nobr><a style="font-weight: 400; text-decoration: underline;" <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?> href="/?action=manager_order_ship&id=<?php echo $this->_tpl_vars['aRow']['move_id']; ?>
"<?php else: ?>
href="/?action=finance_order_ship&id=<?php echo $this->_tpl_vars['aRow']['move_id']; ?>
" <?php endif; ?>><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['summa'],0,2,'span'); ?>
</a></nobr></td>
<td class="cell-name_m"><?php if ($this->_tpl_vars['aRow']['dt'] == '0000-00-00 00:00:00'): ?> &nbsp; <?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['dt'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
<?php endif; ?></td>
<td class="cell-name_m"><?php if ($this->_tpl_vars['aRow']['dt5'] == '0000-00-00 00:00:00'): ?> &nbsp; <?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['dt5'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
<?php endif; ?></td>
<td class="cell-name_m"><a style="font-weight: 400; text-decoration: underline;" <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?> href="/?action=manager_payment_ship&id=<?php echo $this->_tpl_vars['aRow']['move_id']; ?>
"<?php else: ?>
href="/?action=finance_payment_ship&id=<?php echo $this->_tpl_vars['aRow']['move_id']; ?>
" <?php endif; ?>><?php echo $this->_tpl_vars['aRow']['summa_pay']; ?>
</a></td>
<td class="cell-name_m"><?php if ($this->_tpl_vars['aRow']['dt_pay'] == '0000-00-00 00:00:00'): ?> &nbsp; <?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['dt_pay'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
<?php endif; ?></td>

<td class="cell-name_m" style="font-size: 13px;"><b><?php echo $this->_tpl_vars['aRow']['summa_all']; ?>
</b></td>
<td class="cell-name_m" style="font-size: 13px; color: red;"><b><?php echo $this->_tpl_vars['aRow']['summa_dolg']; ?>
</b></td>


