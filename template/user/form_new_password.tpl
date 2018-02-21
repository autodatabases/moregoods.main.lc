<table>
	<tr>
		<td ><b>{$oLanguage->getMessage("New password")}:</td>
   		<td > <input type=password name=data[new_password] value="{$smarty.request.data.new_password}"></td>
   	</tr>
	<tr>
		<td ><b>{$oLanguage->getMessage("Retype new password")}:</td>
   		<td > <input type=password name=data[retype_new_password] value="{$smarty.request.data.retype_new_password}"></td>
   	</tr>

</table>
<input type=hidden name='id' value='{$smarty.request.id}'>
<input type=hidden name='restore_code' value='{$smarty.request.restore_code}'>