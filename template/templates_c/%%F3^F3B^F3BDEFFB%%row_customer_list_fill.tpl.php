<?php /* Smarty version 2.6.18, created on 2017-07-09 10:57:46
         compiled from manager/row_customer_list_fill.tpl */ ?>
<td class="cell-name" style="padding-left: 10px;width: 36px;font-size: 14px;float: none;"><?php echo $this->_tpl_vars['aRow']['id']; ?>
</td>
<td class="cell-name" style="width:20%;float: none;;"><?php echo $this->_tpl_vars['oLanguage']->AddOldParser('customer',$this->_tpl_vars['aRow']['id_user']); ?>
</td>
<td class="cell-name" style="width:20%;float: none;"><?php echo $this->_tpl_vars['aRow']['name']; ?>

<?php if ($this->_tpl_vars['aRow']['phone']): ?><?php echo $this->_tpl_vars['aRow']['phone']; ?>
<?php endif; ?>
</td>
<td class="cell-name" style="width:10%;float: none;"><?php echo $this->_tpl_vars['aRow']['group_name']; ?>
</td>
<td class="cell-name" style="width:20%;float: none;"><b><?php echo $this->_tpl_vars['aRow']['email']; ?>
</b> <br> <?php echo $this->_tpl_vars['aRow']['post_date']; ?>
</td>
<td class="cell-name" style="width:20%;float: none;">
<nobr>
<?php if ($this->_tpl_vars['aRow']['is_fill'] == 0): ?>
	<a style="font-size: 12px;" href="/?action=manager_customer_list_fill_add&id_list=<?php echo $this->_tpl_vars['aRow']['id_list']; ?>
&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>

	<?php if ($_REQUEST['search']['id_user']): ?>&search[id_user]=<?php echo $_REQUEST['search']['id_user']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['login']): ?>&search[login]=<?php echo $_REQUEST['search']['login']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['name']): ?>&search[name]=<?php echo $_REQUEST['search']['name']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['phone']): ?>&search[phone]=<?php echo $_REQUEST['phone']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['group_id']): ?>&search[group_id]=<?php echo $_REQUEST['search']['group_id']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['inlist']): ?>&search[inlist]=<?php echo $_REQUEST['search']['inlist']; ?>
<?php endif; ?>
	">
	<img src="/image/apply.png" border=0 width=16 align=absmiddle hspace=1/><?php echo $this->_tpl_vars['oLanguage']->getMessage('Add'); ?>
</a>
<?php else: ?>
	<a style="font-size: 12px;"href="/?action=manager_customer_list_fill_delete&id_list=<?php echo $this->_tpl_vars['aRow']['id_list']; ?>
&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>

	<?php if ($_REQUEST['search']['id_user']): ?>&search[id_user]=<?php echo $_REQUEST['search']['id_user']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['login']): ?>&search[login]=<?php echo $_REQUEST['search']['login']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['name']): ?>&search[name]=<?php echo $_REQUEST['search']['name']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['phone']): ?>&search[phone]=<?php echo $_REQUEST['phone']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['group_id']): ?>&search[group_id]=<?php echo $_REQUEST['search']['group_id']; ?>
<?php endif; ?>
	<?php if ($_REQUEST['search']['inlist']): ?>&search[inlist]=<?php echo $_REQUEST['search']['inlist']; ?>
<?php endif; ?>
	"
	onclick="if (!confirm('<?php echo $this->_tpl_vars['oLanguage']->getMessage("Are you sure you want to delete this item?"); ?>
')) return false;">
	<img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/><?php echo $this->_tpl_vars['oLanguage']->getMessage('Delete'); ?>
</a>
<?php endif; ?>
</nobr>
</td>