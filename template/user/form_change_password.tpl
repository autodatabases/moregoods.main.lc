<table>
	<tr>
		<td><b>{$oLanguage->getMessage("Old password")}:</td>
   		<td > <input type=password name=data[old_password] value="{$smarty.request.data.old_password}"></td>
   	</tr>
	<tr>
		<td ><b>{$oLanguage->getMessage("New password")}:</td>
   		<td > <input type=password name=data[new_password] value="{$smarty.request.data.new_password}"></td>
   	</tr>
	<tr>
		<td ><b>{$oLanguage->getMessage("Retype new password")}:</td>
   		<td > <input type=password name=data[retype_new_password] value="{$smarty.request.data.retype_new_password}"></td>
   	</tr>

</table>