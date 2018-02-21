<table width=700 border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td>{$oLanguage->getMessage("date_from")}:</td>
		<td><input type=text class="date" name=search[date_from] id=datestart value='{$smarty.request.search.date_from}' maxlength=20 style='width:110px'>
		</td>

		<td>{$oLanguage->getMessage("date_to")}:</td>
		<td><input type=text class="date" name=search[date_to] id=dateend value='{$smarty.request.search.date_to}' maxlength=20 style='width:110px'>
		</td>

	

		<td>{$oLanguage->getMessage("method")}:</td>
		<td><select name=search[method] style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''>All</option>
		{foreach from=$aMethod item=aRow key=aKey}
			<option value='{$aRow}' {if $aRow==$smarty.request.search.method}selected{/if}>{$aRow}</option>
		{/foreach}
			</select>
		</td>
	</tr>
	<tr>	
		<td>{$oLanguage->getMessage("id_cart_package")}:</td>
		<td><input type=text  name=search[id_cart_package] value='{$smarty.request.search.id_cart_package}' maxlength=20 style='width:110px'>
		</td>
		<td>{$oLanguage->getMessage("Customer")}:</td>
		<td><input type=text  name=search[name] value='{$smarty.request.search.name}' maxlength=20 style='width:110px'>
		</td>

		<td>{$oLanguage->getMessage("customer_group")}:</td>
		<td><select name=search[customer_group] style='width:130px;padding: 8px 8px 8px 10px;'>
			<option value=''>All</option>
		{foreach from=$aGroup item=aRow key=aKey}
			<option value='{$aRow}' {if $aRow==$smarty.request.search.customer_group}selected{/if}>{$aRow}</option>
		{/foreach}
			</select>
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->getMessage("list_of_customer")}:</td>
		<td>
		<select name=search_list_cust style='width:111px;padding: 8px 8px 8px 10px;'>
			<option value=''>All Users</option>
		{foreach from=$aListManager item=aRow key=aKey}
			<option value='{$aKey}' 
			{if $aKey==$smarty.request.search_list_cust}selected{/if}>{$aRow}</option>
		{/foreach}
			</select>
		</td>
	</tr>
</table>

