<td>{$aRow.id}</td>
<td align=center> {$oLanguage->getOrderStatus($aRow.order_status)}</td>
<td>{$aRow.vin}</td>
<td>{$oLanguage->getDateTime($aRow.post)}</td>
<td>{$aRow.marka}</td>
<td>{$aRow.manager_comment}&nbsp;</td>
<td nowrap align=left>
{if $aRow.order_status=='new' || $aRow.order_status=='refused'}
<a href="./?action=vin_request_delete&id={$aRow.id}"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;"
	><img src="/image/delete.png" border=0  width=16 align=absmiddle />{$oLanguage->getMessage("Delete")}</a>
{/if}

{if $aRow.order_status=='parsed'}
<a href="./?action=vin_request_preview&id={$aRow.id}"
	><img src="/image/kviewshell.png" border=0  width=16 align=absmiddle />{$oLanguage->getMessage("Preview")}</a>

<!--br>

<a href="./?action=cart_cart&search_id_vin_request={$aRow.id}"
	><img src="/image/tooloptions.png" border=0  width=16 align=absmiddle />{$oLanguage->getMessage("View vin cart")}</a-->
{/if}
&nbsp;

<a href="./?action=vin_request_copy&id={$aRow.id}"
	><img src="/image/redo.png" border=0  width=16 align=absmiddle />{$oLanguage->getMessage("Copy as new")}</a>
</td>
