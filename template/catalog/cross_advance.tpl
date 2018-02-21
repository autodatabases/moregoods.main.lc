<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->getMessage("Profile")} : </b></td> 
		<td>{html_options name=id_cross_profile options=$aCrossProfile selected="" style='width:120px'}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("File")} : </b></td> 
		<td><input type="file" size=30 name="excel_file" multiple="true" ></td>
	</tr>
	<tr>
		<td colspan="2">{$oLanguage->getText("The maximum size of an uploaded file 8M")}</td> 
	</tr>
</table>