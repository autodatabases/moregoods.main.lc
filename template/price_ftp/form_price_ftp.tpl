<table width="99%">
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Provider")} :</b></td>
	<td>{html_options name=search[id_user_provider] options=$aUserProvider selected=$smarty.request.search.id_user_provider style='width:200px'}</td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Pref")}:</b></td>
	<td>{html_options name=search[pref] options=$aPref selected=$smarty.request.search.pref style='width:200px'}</td>
	</tr>
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Code Grp")}:</b></td>
	<td><input type=text name=search[code] value='{$smarty.request.search.code}' maxlength=50 style='width:200px'></td>
	</tr>
</table>
