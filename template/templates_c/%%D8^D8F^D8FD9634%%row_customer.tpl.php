<?php /* Smarty version 2.6.18, created on 2017-05-18 17:02:28
         compiled from manager/row_customer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'manager/row_customer.tpl', 1, false),)), $this); ?>
<td class="cell-price"><nobr><a href="/?action=manager_customer_edit&id_user=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
"><?php echo $this->_tpl_vars['aRow']['id']; ?>
</a>
<td class="cell-name"><?php echo $this->_tpl_vars['oLanguage']->AddOldParser('customer',$this->_tpl_vars['aRow']['id_user']); ?>
</td>
<td class="cell-name"><?php echo $this->_tpl_vars['aRow']['name']; ?>

<?php if ($this->_tpl_vars['aRow']['phone']): ?><?php echo $this->_tpl_vars['aRow']['phone']; ?>
<?php endif; ?>
</td>
<td class="cell-name"><?php echo $this->_tpl_vars['aRow']['group_name']; ?>
&nbsp;</td>
<td class="cell-name"><b><?php echo $this->_tpl_vars['aRow']['email']; ?>
</b> <br> <?php echo $this->_tpl_vars['aRow']['post_date']; ?>
</td>
<td class="cell-name" style="white-space:nowrap;">
</td>