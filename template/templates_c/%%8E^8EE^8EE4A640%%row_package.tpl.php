<?php /* Smarty version 2.6.18, created on 2017-05-24 22:16:47
         compiled from manager/row_package.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'manager/row_package.tpl', 1, false),array('modifier', 'cat', 'manager/row_package.tpl', 20, false),array('modifier', 'debug_print_var', 'manager/row_package.tpl', 40, false),)), $this); ?>
<td class="cell-name2"><nobr><a href="/?action=manager_package_edit&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
"><?php echo $this->_tpl_vars['aRow']['id']; ?>
</a>
</nobr></td>
<td class="cell-name_new"><b><a href="/?action=manager_package_list&search_login=<?php echo $this->_tpl_vars['aRow']['login']; ?>
'><img src="/image/info.png" /></a></b>
<?php $this->assign('Id', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['aRow']['id_user'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['aRow']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['aRow']['id']))); ?>
<?php echo $this->_tpl_vars['oLanguage']->AddOldParser('customer_uniq',$this->_tpl_vars['Id']); ?>

<?php if ($this->_tpl_vars['aRow']['date_delivery']): ?> На: <?php echo $this->_tpl_vars['aRow']['date_delivery']; ?>
 <br> <?php echo $this->_tpl_vars['aRow']['time_delivery']; ?>
 <?php endif; ?>
<?php if ($this->_tpl_vars['aRow']['delivery_point']): ?><br>Адрес:&nbsp;<?php echo $this->_tpl_vars['aRow']['delivery_point']; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['aRow']['city_address_delivery']): ?><br><?php echo $this->_tpl_vars['aRow']['city_address_delivery']; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['aRow']['address_delivery']): ?><br><?php echo $this->_tpl_vars['aRow']['address_delivery']; ?>
<?php endif; ?>
</td>
<td class="cell-name_new"><b>
<?php echo $this->_tpl_vars['aRow']['id_autor']; ?>
<br>
<?php echo $this->_tpl_vars['oLanguage']->getPostDateTime($this->_tpl_vars['aRow']['post_date']); ?>

</b>
</td>
<td class="cell-name_new"><b>
<?php $this->assign('Id_G', $this->_tpl_vars['aRow']['id_customer_group']); ?>
<?php echo smarty_modifier_debug_print_var($this->_tpl_vars['aGroupsG'][$this->_tpl_vars['Id_G']]); ?>
</b>
</td>
<td class="cell-name_new"><b><?php echo $this->_tpl_vars['oLanguage']->getOrderStatus($this->_tpl_vars['aRow']['order_status']); ?>
 </b>
</td>
<?php if ($this->_tpl_vars['aRow']['is_payed'] == 1): ?>
<td class="cell-name_new"><font color=green><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('is_payed'); ?>
 </b></font></td>
<?php else: ?>
<td class="cell-name_new"><font color=red><b><?php echo $this->_tpl_vars['oLanguage']->getMessage('not_payed'); ?>
 </b></font></td>
<?php endif; ?>
<td class="cell-name"> <b><nobr><?php if ($this->_tpl_vars['aRow']['summa_fact'] != 0): ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['summa_fact']-$this->_tpl_vars['aRow']['bonus']); ?>

	<?php else: ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price_total']-$this->_tpl_vars['aRow']['bonus']); ?>
<?php endif; ?></nobr></b>
</td>
 
