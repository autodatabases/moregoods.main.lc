<?php /* Smarty version 2.6.18, created on 2017-05-24 20:40:46
         compiled from finance/row_bill.tpl */ ?>
<td><?php echo $this->_tpl_vars['aRow']['id']; ?>

<?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?><b><?php echo $this->_tpl_vars['aRow']['login']; ?>
</b>
	<?php if ($this->_tpl_vars['aRow']['name']): ?><br><?php echo $this->_tpl_vars['aRow']['name']; ?>
<?php endif; ?><?php endif; ?>
</td>
<td><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['amount']); ?>
</td>
<td><?php echo $this->_tpl_vars['oLanguage']->GetMessage($this->_tpl_vars['aRow']['code_template']); ?>

<?php if ($this->_tpl_vars['aRow']['id_cart_package']): ?>
	<br><br><?php echo $this->_tpl_vars['oLanguage']->GetMessage('bill_cart_package'); ?>
: <b><?php echo $this->_tpl_vars['aRow']['id_cart_package']; ?>
</b>
<?php endif; ?>

<br>
<i><?php echo $this->_tpl_vars['aRow']['account_name']; ?>
</i>
</td>
<td><?php echo $this->_tpl_vars['aRow']['post_date']; ?>
</td>
<td nowrap>

<a href="/?action=finance_bill_print&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
" target=_blank
	><img src="/image/fileprint.png" border=0 width=16 align=absmiddle hspace=1/><?php echo $this->_tpl_vars['oLanguage']->getMessage('Print'); ?>
</a>
<br>

<a href="/?action=finance_bill_print&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&send_file=1" target=_blank
	><img src="/image/disk_blue.png" border=0 width=16 align=absmiddle hspace=1/><?php echo $this->_tpl_vars['oLanguage']->getMessage('Download'); ?>
</a>
<br>


<a href="/?action=finance_bill_edit&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle hspace=1/><?php echo $this->_tpl_vars['oLanguage']->getMessage('Account Edit'); ?>
</a>
<br>

<a href="/?action=finance_bill_delete&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
"
	onclick="if (!confirm('<?php echo $this->_tpl_vars['oLanguage']->getMessage("Are you sure you want to delete this item?"); ?>
')) return false;"
	><img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/><?php echo $this->_tpl_vars['oLanguage']->getMessage('Delete'); ?>
</a>
</td>