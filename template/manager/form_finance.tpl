<table width=100%>
	<tr>
   		<td><b>{$oLanguage->getMessage("Deposit to customer")}:</b>
   			<font color=blue size=+1><b>{$smarty.request.login}</b></font> </td>
   		<td>
   		{if $smarty.request.custom_id}
   			<b>{$oLanguage->getMessage("Deposit to cart package")}:</b> {$smarty.request.custom_id}
   		{/if}
   		</td>
  	</tr>

	<tr>
   		<td colspan=2><hr></td>
  	</tr>

	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Amount")}:</b> {$sZir}</td>
   		<td width=50%><input type=text name=data[amount] value='{$aData.amount}' maxlength=20 ></td>
  	</tr>
	<tr>
   		<td><b>{$oLanguage->getMessage("Account Log Type")}:</b> {$sZir}</td>
   		<td>{html_options name=data[id_user_account_log_type] options=$aUserAccountLogType}</td>
  	</tr>
	<tr>
   		<td><b>{$oLanguage->getMessage("Pay Type")}:</b> {$sZir}</td>
   		<td>{html_options name=data[pay_type] values=$aPayTypeId output=$aPayTypeValue}</td>
  	</tr>
	<tr>
   		<td><b>{$oLanguage->getMessage("Custom ID")}:</b> </td>
   		<td><input type=text name=data[custom_id]
				value='{if $aData.custom_id}{$aData.custom_id}{else}{$smarty.request.custom_id}{/if}' maxlength=20
			></td>
  	</tr>
	<tr>
   		<td><b>{$oLanguage->getMessage("Description")}:</b> </td>
   		<td><textarea name=data[description] rows=4></textarea></td>
  	</tr>

</table>

<input type=hidden name=data[id_user] value='{$smarty.request.id_user}'>
<input type=hidden name=data[return] value='{$smarty.request.return|escape:"url"}'>