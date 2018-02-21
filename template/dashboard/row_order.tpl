<td>{$aRow.id}
<br>
<font color=gray>{$aRow.id_cart_package}</font><br>

{if $aRow.id_user!=$aAuthUser.id} - <b>{$aRow.login}</b>{/if}

</td>
<td>{if $aRow.code_visible || $aRow.order_status!='pending'}
		{$aRow.code}
		{if $aRow.code_changed}
			<font color=red>{$aRow.code_changed}</font><br>
		{/if}
	{else}
		<i>{$oLanguage->getMessage("cart_invisible")}</i>
	{/if}
	<br>
	<b {if $aRow.cat_name_changed}style=" text-decoration:line-through;"{/if}>{$aRow.cat_name}</b>
	{if $aRow.cat_name_changed}<br><b>{$aRow.cat_name_changed}</b>{/if}

</td>
<td>{if $aRow.is_archive} <font color=silver>{/if} {$aRow.name}
	<font color=green>{$aRow.russian_name}</font>

	{if $aRow.manager_comment}
		<br><font color=brown><b>{$oLanguage->getMessage("LastManagerComment")}</b>: {$aRow.manager_comment}</font>
	{/if}

{if $aRow.is_private_parsed || $aRow.private_comment}
	<br><font color=blue>{$oLanguage->getMessage("PendingParsed")}:
	{include file='addon/mpanel/yes_no.tpl' bData=$aRow.is_private_parsed}
	</font>
{/if}
</td>
<td>{$aRow.term}<br>
{$oLanguage->getDateTime($aRow.post)}<br>
{$aRow.pr_name} {$aRow.prw_name}
</td>
<td>{$aRow.number}</td>
</td>
<td>{$oCurrency->PrintPrice($aRow.price)}</td>
<td>{$oCurrency->PrintPrice($aRow.total)}</td>