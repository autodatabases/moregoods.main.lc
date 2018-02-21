<?php /* Smarty version 2.6.18, created on 2017-07-09 10:38:28
         compiled from manager_cart/row_cart.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'manager_cart/row_cart.tpl', 5, false),)), $this); ?>
<td class="cell-name2" style="width:5%;padding: 0;"><a style="padding-left: 10px;font-weight: bold;font-size: 12px;"><?php echo $this->_tpl_vars['aRow']['id']; ?>
</a></td>
<td class="cell-name" style="width:25%;float: none;">
<?php $this->assign('Id', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['aRow']['id_user'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['aRow']['id']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['aRow']['id']))); ?>
<?php echo $this->_tpl_vars['oLanguage']->AddOldParser('customer_uniq',$this->_tpl_vars['Id']); ?>

</td>

<td class="cell-name" style="width:45%;float: none;">
	<?php if ($this->_tpl_vars['aRow']['is_archive']): ?> <font color=silver><?php endif; ?>
<a target="_blank" href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"><?php echo $this->_tpl_vars['aRow']['name_translate']; ?>
&nbsp;&nbsp; <?php echo $this->_tpl_vars['aRow']['post_date']; ?>
</a>
<span>(ID: <?php echo $this->_tpl_vars['aRow']['id_product']; ?>
)&nbsp;(Apt: <?php echo $this->_tpl_vars['aRow']['code']; ?>
) (Barcod: <?php echo $this->_tpl_vars['aRow']['barcode']; ?>
)   &nbsp;&nbsp; <?php echo $this->_tpl_vars['aRow']['cat_name']; ?>
</span>
</td>

<td class="cell-name" style="padding-left: 10px;width:5%;"><b><?php echo $this->_tpl_vars['aRow']['number']; ?>
</b></td>
<td class="cell-name" style="width:12%;float: none;"><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
</td>

<td class="cell-name" style="width:8%;font-size: 14px;white-space:nowrap;">
<a href="/?action=manager_cart_delete&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
"
	onclick="if (!confirm('<?php echo $this->_tpl_vars['oLanguage']->getMessage("Are you sure you want to delete this item?"); ?>
')) return false;"
	><img src="/image/delete.png" border=0  width=16 align=absmiddle /><?php echo $this->_tpl_vars['oLanguage']->getMessage('Delete'); ?>
</a>
</td>