<td>{$aRow.id}
{if $aAuthUser.type_=='manager'}<b>{$aRow.login}</b>
	{if $aRow.name}<br>{$aRow.name}{/if}{/if}
</td>
<td>{$oCurrency->PrintPrice($aRow.amount)}</td>
<td>{$oLanguage->GetMessage($aRow.code_template)}
{if $aRow.id_cart_package}
	<br><br>{$oLanguage->GetMessage('bill_cart_package')}: <b>{$aRow.id_cart_package}</b>
{/if}

<br>
<i>{$aRow.account_name}</i>
</td>
<td>{$aRow.post_date}</td>
<td nowrap>

<a href="/?action=finance_bill_print&id={$aRow.id}" target=_blank
	><img src="/image/fileprint.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Print")}</a>
<br>

<a href="/?action=finance_bill_print&id={$aRow.id}&send_file=1" target=_blank
	><img src="/image/disk_blue.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Download")}</a>
<br>


<a href="/?action=finance_bill_edit&id={$aRow.id}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Account Edit")}</a>
<br>

<a href="/?action=finance_bill_delete&id={$aRow.id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	><img src="/image/delete.png" border=0  width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Delete")}</a>
</td>
