<table>
	<tr>
		<td><b>{$oLanguage->GetMessage('code')}</b>:</td>
		<td><input type="text" name="search[code]" value="{$smarty.request.search.code}"></td>
	<td>&nbsp;</td>
		<td><b>{$oLanguage->GetMessage('brand')}</b>:</td>
		<td><select name="search[pref]" >{html_options options=$aBrand selected=$smarty.request.search.pref}</select></td>
	</tr>
</table>
<input type="hidden" name="store" value="{$smarty.request.store}">