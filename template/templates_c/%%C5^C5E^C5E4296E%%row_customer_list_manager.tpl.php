<?php /* Smarty version 2.6.18, created on 2017-07-09 10:32:28
         compiled from manager/row_customer_list_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'manager/row_customer_list_manager.tpl', 2, false),)), $this); ?>
<td class="cell-name2" style="width:5%;padding: 0;">
<a style="padding-left: 10px;font-weight: bold;width:5%;font-size: 16px;" href="/?action=manager_customer_list_fill&id_list=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['sReturn'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
"><?php echo $this->_tpl_vars['aRow']['sort']; ?>
</a>
</td>
<td class="cell-name" style="width:30%;float: none;"><?php echo $this->_tpl_vars['aRow']['name']; ?>
</td>
<td class="cell-name no-mobile" style="width:20%;float: none;" ><?php echo $this->_tpl_vars['aRow']['region']; ?>
</td>
<td class="cell-name no-mobile" style="width:20%;float: none;"><?php echo $this->_tpl_vars['aRow']['post_date']; ?>
</td>
<td class="cell-name" style="width:25%;font-size: 14px;">
	<a href="/?action=manager_customer_list_edit&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
">
	<img src="/image/edit.png" border=0 width=16 align=absmiddle hspace=1/><?php echo $this->_tpl_vars['oLanguage']->getMessage('Edit'); ?>
</a><br>
	<a href="/?action=manager_customer_list_delete&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
"
	onclick="if (!confirm('<?php echo $this->_tpl_vars['oLanguage']->getMessage("Are you sure you want to delete this item?"); ?>
')) return false;">
	<img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/><?php echo $this->_tpl_vars['oLanguage']->getMessage('Delete'); ?>
</a>
</td>