<script language="javascript" type="text/javascript" src="/js/form.js?3284"></script>
<table width="99%">
	<tr>
	   	<td><b>{$oLanguage->getMessage("Make")}:</b></td>
   		<td nowrap><select id=pref name=search[pref]>
   		{html_options  options=$aPref selected=$smarty.request.search.pref}
		</select>
   		</td>

	   	<td><b>{$oLanguage->getMessage("Code Part")}:</b></td>
   		<td nowrap><input id=code type="text" name=search[code] value={$smarty.request.search.code}>
   		</td>

   	</tr>
</table>
