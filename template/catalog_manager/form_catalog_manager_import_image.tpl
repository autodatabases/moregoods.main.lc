<table width="99%">
{*<tr>	
	<td width=50%><b>{$oLanguage->getMessage("Pref")}:</b></td>
	<td>{html_options name=data[pref] options=$aPref selected=$aData.pref style='width:270px'}</td>
</tr>*}
<tr>	
	<td><b>{$oLanguage->getMessage("File to import")}:</b></td>
	<td><input type=file name=import_file[] multiple>
	<input type=hidden name=id_cat_part value={$aData.id}>
	<input type=hidden name=data[item_code] value={$aData.item_code}></td></td>
	
</tr>
</table>