<table width=100%>

<tr>
	<td width=50% colspan=2><b>{$oLanguage->GetMessage("Account money")}:</b></td>
	<td colspan=2><nobr>{$aUserAccount.amount}

	</nobr>
	</td>
	</tr>
{if $aAuthUser.type_=='customer'}
	{if $aAuthUser.price_type=='discount'}
<tr>
	<td colspan=2><b>{$oLanguage->getMessage("Discount")}:</b> {$oLanguage->getContextHint("customer_finance_discount")}</td>
	<td colspan=2>{$sDiscount} % </td>
</tr>
	{/if}
{/if}
<tr>
		<td colspan="2">
		<input type=checkbox name=search[date] value=1 {if $smarty.request.search.date}checked{/if}>&nbsp;
		<b>{$oLanguage->getMessage("DFrom")}:</b> <input id=date_from name=date_from  style='width:100px;'
				readonly value='{if $smarty.request.date_from}{$smarty.request.date_from}
					{else}{$smarty.now-30*86400|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, this, 'dd.mm.yyyy')">&nbsp;
		</td>
		<td colspan="2">
		<b>{$oLanguage->getMessage("DTo")}:</b> <input id=date_to name=date_to  style='width:100px;'
				readonly value='{if $smarty.request.date_to}{$smarty.request.date_to}
					{else}{$smarty.now+86400|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, this, 'dd.mm.yyyy')">
		</td>

</tr>
</table>