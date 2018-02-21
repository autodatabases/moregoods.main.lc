<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->getMessage("Customer")}:</b></td>
		<td>
		<input type=text name=search[login] value='{$smarty.request.search.login}' maxlength=20 style='width:110px'>
		<!--select name=search_id_user style='width:110px'>
			<option value=''>All Users</option>
		{foreach from=$aCustomer item=aRow}
			<option value='{$aRow.id}' {if $aRow.id==$smarty.request.search_id_user}selected{/if}>{$aRow.login} - {$aRow.name}</option>
		{/foreach}
			</select-->
		</td>
		<td><b>{$oLanguage->getMessage("Request #")}:</b></td>
		<td><input type=text name=search[id] value='{$smarty.request.search.id}' maxlength=20 style='width:110px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Phone")}:</b></td>
		<td>
		<input type=text name=search[phone] value='{$smarty.request.search.phone}' maxlength=20 style='width:110px'>
		</td>
		<td colspan=2> <input type=checkbox name=search[is_remember] value='1' {if $smarty.request.search.is_remember}checked{/if}>
		<b>{$oLanguage->getMessage("Only Is Remember")}</b></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Status")}:</b></td>
		<td><select name=search[order_status] style='width:110px'>
			<option value=''>{$oLanguage->getMessage("All")}</option>
			<option value='new' {if $smarty.request.search.order_status=='new'}selected{/if}
				>{$oLanguage->getOrderStatus('new')}</option>
			<option value='work' {if $smarty.request.search.order_status=='work'}selected{/if}
				>{$oLanguage->getOrderStatus('work')}</option>
			<option value='refused' {if $smarty.request.search.order_status=='refused'}selected{/if}
				>{$oLanguage->getOrderStatus('refused')}</option>
			<option value='parsed' {if $smarty.request.search.order_status=='parsed'}selected{/if}
				>{$oLanguage->getOrderStatus('parsed')}</option>
			</select></td>
		<td><b>{$oLanguage->getMessage("Marka")}:</b></td>
		<td><input type=text name=search[marka] value='{$smarty.request.search.marka}' maxlength=20 style='width:110px'></td>
	</tr>
</table>