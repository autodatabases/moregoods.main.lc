<?php /* Smarty version 2.6.18, created on 2017-05-24 20:40:46
         compiled from finance/button_bill.tpl */ ?>
<!--input class="btn" value="<?php echo $this->_tpl_vars['oLanguage']->GetMessage('Return to Finance module'); ?>
"
			onclick="location.href='/?action=finance'" type="button"-->

<input type=button class='btn' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('Delete selected'); ?>
"
	onclick="if (confirm('<?php echo $this->_tpl_vars['oLanguage']->getMessage("Are you sure you want to delete this items?"); ?>
'))
	 mt.ChangeActionSubmit(this.form,'finance_bill_delete');">

<input type=button class='btn' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('bill add'); ?>
"
	onclick="location.href='/?action=finance_bill_add&code_template=simple_bill';">

<?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
<input type=button class='btn' value="<?php echo $this->_tpl_vars['oLanguage']->getMessage('order bill add'); ?>
"
	onclick="location.href='/?action=finance_bill_add&code_template=order_bill';">
<?php endif; ?>