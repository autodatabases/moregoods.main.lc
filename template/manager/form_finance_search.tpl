<table width=700 border=0>
	<tr>
		<td><b>{$oLanguage->getMessage("Customer")}:</b></td>
		<td><input type=text name=search[login] value='{$smarty.request.search.login}' maxlength=20 style='width:110px'>
		</td>
		<td><b>{$oLanguage->getMessage("Ual CustomId")}:</b></td>
		<td><input type=text name=search[custom_id] value='{$smarty.request.search.custom_id}' maxlength=20 ></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Account Log Type")}:</b></td>
		<td>
		<select name=search[id_user_account_log_type]  style="width:110px">
			<option value=''>{$oLanguage->GetMessage('All')}</option>
			{html_options options=$aUserAccountLogType selected=$smarty.request.search.id_user_account_log_type }
		</select>
		</td>
		<td><b>{$oLanguage->getMessage("Description")}:</b></td>
		<td><input type=text name=search[description] value='{$smarty.request.search.description}'
			maxlength=40 style='width:110px'></td>
	</tr>
	<tr>
		<td>
		<input type=checkbox name=search[date] value=1 {if $smarty.request.search.date}checked{/if}>
		<b>{$oLanguage->getMessage("DFrom")}:</b></td>
		<td><input id=date_from name=search[date_from]  style='width:100px;'
	readonly value='{if $smarty.request.date_from}{$smarty.request.search.date_from}
					{else}{$smarty.now-30*86400|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, document.getElementById('date_from'), 'dd.mm.yyyy')">
		</td>
		<td><b>{$oLanguage->getMessage("DTo")}:</b></td>
		<td><input id=date_to name=search[date_to]  style='width:100px;'
			readonly value='{if $smarty.request.search.date_to}{$smarty.request.search.date_to}
					{else}{$smarty.now+86400|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, document.getElementById('date_to'), 'dd.mm.yyyy')">
		</td>

	</tr>
</table>