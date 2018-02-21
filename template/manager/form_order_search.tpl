<table width=100% border=0>
	<tr>
		<td colspan="2"><b>{$oLanguage->getMessage("man_Order #")}:</b>
		<input type=text name=search[id] value='{$smarty.request.search.id}' maxlength=20 style='width:110px'></td>

		<td><b>{$oLanguage->getMessage("Order ID list")}:</b></td>
		<td><input type=text name=search[id_cart_package] value='{$smarty.request.search.id_cart_package}'
				maxlength=20 style='width:110px'></td>
	</tr>
	
	<tr>
		<td colspan=2><b>{$oLanguage->getMessage("Customer")}:</b>
		&nbsp;&nbsp;<input type=text name=search[login] value='{$smarty.request.search.login}' maxlength=20 style='width:80px'>
		</td>
		<td>
		<b>{$oLanguage->getMessage("Provider")}:</b></td>
		<td><select name='search[id_provider]' style='width:120px'>
			<option value='0'>{$oLanguage->getMessage("Show All")}</option>
			{foreach from=$aProvider item=aItem}
			<option value='{$aItem.id}' {if $smarty.request.search.id_provider==$aItem.id}selected{/if}
				>{if $aAuthUser.is_super_manager || $aAuthUser.is_sub_manager_partner}{$aItem.name}
					{else}{$aItem.code_name}{/if}</option>
			{/foreach}
			</select>
		</td>
	</tr>
	<tr>
		<td colspan=2><b>{$oLanguage->getMessage("brand")}:</b>
		<select name='search[pref]' style='width:100px'>
		{html_options options=$aPref selected=$smarty.request.search.pref}
		</select>
		&nbsp;&nbsp;<b>{$oLanguage->getMessage("№")}:</b>
		<input type=text name=search[code] value='{$smarty.request.search.code}' maxlength=20 style='width:110px'>
		
		
		</td>
		<td>
		<b>{$oLanguage->getMessage("Name")}:</b></td>
		<td><input type=text name=search_name value='{$smarty.request.search_name}' maxlength=20 style='width:110px'>
		</td>
	</tr>
	<tr>
	</tr>
	<tr>
		<td colspan="4">
		<select name=search[date_type] style='width:80px'>
			<option value='cart'>{$oLanguage->getMessage("CartDate")}</option>
			<option value='status' {if $smarty.request.search.date_type=='status'}selected{/if}
					>{$oLanguage->getMessage("StatusDate")}</option>
		</select>

		<input type=checkbox name=search_date value=1 checked>&nbsp;&nbsp;
		<b>{$oLanguage->getMessage("DFrom")}:</b>
		<input id=date_from name=search[date_from]  style='width:100px;'
				readonly value='{if $smarty.request.search.date_from}{$smarty.request.search.date_from}{else
					}{$smarty.now-120*86400|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, document.getElementById('date_from'), 'dd.mm.yyyy')">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<b>{$oLanguage->getMessage("DTo")}:</b>
		<input id=date_to name=search[date_to]  style='width:100px;'
				readonly value='{if $smarty.request.search.date_to}{$smarty.request.search.date_to}{else
					}{$smarty.now+86400|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, document.getElementById('date_to'), 'dd.mm.yyyy')">
		</td>

	</tr>
	<tr>
		<td nowrap colspan=2><b>{$oLanguage->getMessage("Status")}:</b>
			<select name='search_order_status' style='width:110px' onchange="">
			<option value='notend' {if $smarty.request.search_order_status=='notend'}selected{/if}
				>{$oLanguage->getMessage("notend")}</option>
			<option value='0' {if $smarty.request.search_order_status=='0'}selected{/if}
			    >{$oLanguage->getMessage("All")}</option>
			<option value='new' {if $smarty.request.search_order_status=='new'}selected{/if}
				>{$oLanguage->getMessage("new")}</option>
			<option value='work' {if $smarty.request.search_order_status=='work'}selected{/if}
				>{$oLanguage->getMessage("work")}</option>
			<option value='confirmed' {if $smarty.request.search_order_status=='confirmed'}selected{/if}
				>{$oLanguage->getMessage("confirmed")}</option>
			<option value='road' {if $smarty.request.search_order_status=='road'}selected{/if}
				>{$oLanguage->getMessage("road")}</option>
			<option value='store' {if $smarty.request.search_order_status=='store'}selected{/if}
				>{$oLanguage->getMessage("store")}</option>
			<option value='end' {if $smarty.request.search_order_status=='end'}selected{/if}
				>{$oLanguage->getMessage("end")}</option>
			<option value='reclamation' {if $smarty.request.search_order_status=='reclamation'}selected{/if}
				>{$oLanguage->getMessage("reclamation")}</option>
			<option value='refused' {if $smarty.request.search_order_status=='refused'}selected{/if}
				>{$oLanguage->getMessage("refused")}</option>
			<option value='pending' {if $smarty.request.search_order_status=='pending'}selected{/if}
				>{$oLanguage->getMessage("pending")}</option>

			</select>
			{html_options name=search_id_user_manager options=$aUserManager selected=$smarty.request.search_id_user_manager
				style='width:80px'}

			<select name=search[order_status_type] style='width:60px'>
				<option value='who'>{$oLanguage->getMessage("Who")}</option>
				<option value='whose' {if $smarty.request.search.order_status_type=='whose'}selected{/if}
						>{$oLanguage->getMessage("Whose")}</option>
			</select>
			</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>