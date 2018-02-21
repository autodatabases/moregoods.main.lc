<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->getMessage("name_profile")}: </b></td> 
		<td><input type=text name=name_profile value='' maxlength=20 style='width:150px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("File price")} : </b></td> 
		<td><input type="file" size=30 name="price_file"></td>
	</tr>
	<tr>
		<td colspan="2">{$oLanguage->getText("The maximum size of an uploaded file")} {$iMaxSize}</td> 
	</tr>
</table>
