<table width=100% border=0 class="gm-block-order-filter ">
	<tr>
		<td>ID:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'><input type=text name=search[id_user] value='{$smarty.request.search.id_user}' maxlength=20 ></td>

		<td>{$oLanguage->getMessage("CustName")}:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'><input type=text name=search[name] value='{$smarty.request.search.name}' maxlength=20 ></td>

		<td>{$oLanguage->getMessage("Group")}:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'>
			<select name=search[group_id] style='width:130px;padding: 8px 8px 8px 10px;'>
			{html_options options=$aGroupsG  selected=$smarty.request.search.group_id}
			</select>
		</td>

	</tr>
	<tr>
		<td>{$oLanguage->getMessage("Login")}:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'><input type=text name=search[login] value='{$smarty.request.search.login}' maxlength=20 ></td>

		<td>{$oLanguage->getMessage("Phone")}:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'><input type=text name=search[phone] value='{$smarty.request.search.phone}' maxlength=20 ></td>

		<td nowrap>{$oLanguage->getMessage("InList")}:</td>
		<td style='width:130px;padding: 8px 8px 8px 10px;'>
			<select name=search[inlist] style='width:130px;padding: 8px 8px 8px 10px;'>
			{html_options options=$aInList  selected=$smarty.request.search.inlist}
			</select>
		</td>
	</tr>
</table>