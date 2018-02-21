<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->getMessage("Link")} : </b></td> 
		<td>{if $sFileTime}<a href="image/price/export/partmaster.zip">partmaster.zip</a> {$sFileTime}{/if}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Coefficient")} : </b></td> 
		<td><input type=text name=search[coef] value='' maxlength=20 style='width:50px'></td>
	</tr>
</table>