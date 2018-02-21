<table width="99%">
<tr>
	<td width=50%><b>{$oLanguage->getMessage("Provider")} :</b></td>
	<td>{html_options name=data[id_user_provider] options=$aUserProvider selected=$aData.id_user_provider style='width:270px'}</td>
</tr>
<tr>	
	<td width=50%><b>{$oLanguage->getMessage("Pref")}:</b></td>
	<td>{html_options name=data[pref] options=$aPref selected=$aData.pref style='width:270px'}</td>
</tr>
<tr>	
	<td><b>{$oLanguage->getMessage("File to import")}:</b></td>
	<td><input type=file name=import_file></td></td>
</tr>
</table>