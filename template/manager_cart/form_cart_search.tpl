<table width=100% border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td>{$oLanguage->getMessage("Customer")}:</td>
		<td><input type=text name=search_login value='{$smarty.request.search_login}' maxlength=20 style='width:170px'>

		<td>{$oLanguage->getMessage("Changes For")}:</td>
		<td><select name='search_changes' style='width:170px;padding: 8px 8px 8px 10px;'>
			<option value='' {if $smarty.request.search_changes==''}selected{/if}
				>{$oLanguage->getMessage("All Periods")}</option>
			<option value='1' {if $smarty.request.search_changes=='1'}selected{/if}
				>{$oLanguage->getMessage("Yestarday")}</option>
			<option value='7' {if $smarty.request.search_changes=='7'}selected{/if}
				>{$oLanguage->getMessage("Week")}</option>
			<option value='30' {if $smarty.request.search_changes=='30'}selected{/if}
				>{$oLanguage->getMessage("Month")}</option>
			</select></td>
		<td>{$oLanguage->getMessage("Group")}:</td>
		<td>
		<select name='group_id' style='width:130px;padding: 8px 8px 8px 10px;'>
			{html_options options=$aGroupsG  selected=$smarty.request.group_id}
			</select>
</td>

	</tr>
		<tr>
		<td>{$oLanguage->getMessage("cart #")}:</td>
		<td><input type=text name=search_id value='{$smarty.request.search_id}' maxlength=20 style='width:170px'></td>
		<td>{$oLanguage->getMessage("Name")}:</td>
		<td><input type=text name=search_name value='{$smarty.request.search_name}' maxlength=20 style='width:170px'></td>

		<td>{$oLanguage->getMessage("Autor")}:</td>
		<td>
		<select name=id_autor style='width:130px;padding: 8px 8px 8px 10px;'>
		{foreach from=$aAutors item=aRow}
			<option value='{$aRow.id_autor}' {if $aRow.id_autor==$smarty.request.id_autor}selected{/if}>{$aRow.login} &nbsp;&nbsp; {$aRow.name}</option>
		{/foreach}
		</select>
		</td>

	</tr>
	<tr>
		<td>По дате</td>
                <td><input class="date" style='width:170px' name=search[datestart] id=datestart type="text" value="{$smarty.request.search.datestart}"></td>
                <td>&nbsp; -</td>
                <td><input class="date" style='width:170px' name=search[dateend] id=dateend type="text" value="{$smarty.request.search.dateend}"></td>
                <input class="js-date" type="text" name="search[date]" value="" style="display: none;">
                <td>{$oLanguage->getMessage("list_of_customer")}:</td>
		<td style='width:130px;'>
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