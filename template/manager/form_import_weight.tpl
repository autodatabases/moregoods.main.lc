<table>
	<tr>
   		<td><b>{$oLanguage->getMessage("code")}:</b></td>
   		<td><input type=text name=search[code] value="{$smarty.request.search.code}"></td>

   		<td><b>{$oLanguage->getMessage("comment")}:</b></td>
   		<td><input type=text name=search[comment] value="{$smarty.request.search.comment}"></td>
  	</tr>
	<tr>
   		<td><b>{$oLanguage->getMessage("File to import")}:</b></td>
   		<td><input type=file name=import_file style='width:270px'></td>
   		<td>&nbsp;</td>
   		<td>&nbsp;</td>
  	</tr>
</table>

<input type=hidden name=is_post value='1'>