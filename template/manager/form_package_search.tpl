<table style="width:100%;" border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td>{$oLanguage->getMessage("CartPackage #")}:</td>
		<td><input type=text name=search[id] value='{$smarty.request.search.id}' maxlength=20 style='width:130px'></td>

		<td>{$oLanguage->getMessage("Customer")}:</td>
		<td><input type=text name=search_login value='{$smarty.request.search_login}' maxlength=20 style='width:130px;padding: 8px 8px 8px 10px;'></td>
		
		<td>{$oLanguage->getMessage("Group")}:</td>
		<td>
		<select name='group_id' style='width:130px;padding: 8px 8px 8px 10px;'>
			{html_options options=$aGroupsG  selected=$smarty.request.group_id}
			</select>
</td>
{*
		<td>{$oLanguage->getMessage("Zip")}:</td>
		<td><input type=text name=search_zip value='{$smarty.request.search_zip}' maxlength=6 style='width:110px'>
		<select name=search_id_user style='width:110px'>
			<option value=''>All Users</option>
		{foreach from=$aCustomer item=aRow}
			<option value='{$aRow.id}' {if $aRow.id==$smarty.request.search_id_user}selected{/if}>{$aRow.login} - {$aRow.name}</option>
		{/foreach}
			</select>*}
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->getMessage("Status")}:</td>
		<td><select name='search_order_status' style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''>{$oLanguage->getMessage("All")}</option>
			<option value='new' {if $smarty.request.search_order_status=='new'}selected{/if}
				>{$oLanguage->getMessage("new")}</option>
			<option value='pending' {if $smarty.request.search_order_status=='pending'}selected{/if}
				>{$oLanguage->getMessage("pending")}</option>
			<option value='work' {if $smarty.request.search_order_status=='work'}selected{/if}
				>{$oLanguage->getMessage("work")}</option>
			<option value='end' {if $smarty.request.search_order_status=='end'}selected{/if}
				>{$oLanguage->getMessage("end")}</option>
			<option value='refused' {if $smarty.request.search_order_status=='refused'}selected{/if}
				>{$oLanguage->getMessage("refused")}</option>
			</select></td>
		{*<td>{$oLanguage->getMessage("Brand")}:</td>
		<td><select name='search[pref]' style='width:110px'>
		{html_options options=$aPref selected=$smarty.request.search.pref}
		</select>
		</td>
		<td>{$oLanguage->getMessage("CartCode")}:</td>
		<td><input type=text name=search_code value='{$smarty.request.search_code}' maxlength=20 style='width:110px'></td>
*}
		{*<td>{$oLanguage->getMessage("InList")}:</td>
		<td >
			<select name=search[id_list] style='width:130px;padding: 8px 8px 8px 10px;'>
			{html_options options=$aList  selected=$smarty.request.search.id_list}
			</select>
		</td>*}
		
		<td>{$oLanguage->getMessage("is_payed")}:</td>
		<td><select name='status_liq' style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''>{$oLanguage->getMessage("All")}</option>
			<option value='1' {if $smarty.request.status_liq=='1'}selected{/if}
				>{$oLanguage->getMessage("is_payed")}</option>
			<option value='0' {if $smarty.request.status_liq=='0'}selected{/if}
				>{$oLanguage->getMessage("not_payed")}</option>
			</select></td>

		<td>{$oLanguage->getMessage("Autor")}:</td>
		<td>
		<select name=id_autor style='width:130px;padding: 8px 8px 8px 10px;'>
		{foreach from=$aAutors item=aRow}
			<option value='{$aRow.id_autor}' {if $aRow.id_autor==$smarty.request.id_autor}selected{/if}>{$aRow.login} &nbsp;&nbsp; {$aRow.name}</option>
		{/foreach}
		</select>
		</td>
	</tr>
{*	<tr>
	<td colspan=2> <input type=checkbox name=search[is_viewed] value='1' {if $smarty.request.search.is_viewed}checked{/if}>
		{$oLanguage->getMessage("Only is_viewed")}</td>
	</tr>
	*}
	<tr>
		<td>{$oLanguage->getMessage("list_of_customer")}:</td>
		<td>
		<select name=search_list_cust style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''>All Users</option>
		{foreach from=$aListManager item=aRow key=aKey}
			<option value='{$aKey}' 
			{if $aKey==$smarty.request.search_list_cust}selected{/if}>{$aRow}</option>
		{/foreach}
			</select>
		</td>
	</tr>
</table>