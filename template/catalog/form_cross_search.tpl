<script language="javascript" type="text/javascript" src="/js/form.js?3284"></script>
<table width="99%">
	<tr>
	   	<td><b>{$oLanguage->getMessage("Make")}:</b></td>
   		<td nowrap><select id=pref name=search[pref] style="width:200px;">
   		{html_options  options=$aPref selected=$smarty.request.search.pref}
		</select>
   		</td>

	   	<td><b>{$oLanguage->getMessage("Code Part")}:</b></td>
   		<td nowrap><input style='width:150px;' id=code type="text" name=search[code] value={$smarty.request.search.code}>
   		</td>

	   	<td><b>{$oLanguage->getMessage("Sorce crs search")}:</b></td>
   		<td nowrap><input id=source type="text" name=search[source] value={$smarty.request.search.source}>
   		</td>
   	</tr>
	<tr>
	   	<td><b>{$oLanguage->getMessage("Date from")}:</b></td>
   		<td nowrap><input id=date_from name=search[date_from]  style='width:100px;'
				readonly value='{if $smarty.request.search.date_from}{$smarty.request.search.date_from}{else
					}{"2013-01-01"|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, document.getElementById('date_from'), 'dd.mm.yyyy')">
   		</td>

	   	<td><b>{$oLanguage->getMessage("Date to")}:</b></td>
   		<td nowrap><input id=date_to name=search[date_to]  style='width:100px;'
				readonly value='{if $smarty.request.search.date_to}{$smarty.request.search.date_to}{else
					}{$smarty.now+86400|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, document.getElementById('date_to'), 'dd.mm.yyyy')">
   		</td>

	   	<td><b>{$oLanguage->getMessage("Manager")}:</b></td>
   		<td nowrap><input id=manager type="text" name=search[manager] value={$smarty.request.search.manager}>
   		</td>
   	</tr>
</table>
