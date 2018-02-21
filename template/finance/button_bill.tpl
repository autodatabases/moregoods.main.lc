<!--input class="btn" value="{$oLanguage->GetMessage("Return to Finance module")}"
			onclick="location.href='/?action=finance'" type="button"-->

<input type=button class='btn' value="{$oLanguage->getMessage("Delete selected")}"
	onclick="if (confirm('{$oLanguage->getMessage("Are you sure you want to delete this items?")}'))
	 mt.ChangeActionSubmit(this.form,'finance_bill_delete');">

<input type=button class='btn' value="{$oLanguage->getMessage("bill add")}"
	onclick="location.href='/?action=finance_bill_add&code_template=simple_bill';">

{if $aAuthUser.type_=='manager'}
<input type=button class='btn' value="{$oLanguage->getMessage("order bill add")}"
	onclick="location.href='/?action=finance_bill_add&code_template=order_bill';">
{/if}