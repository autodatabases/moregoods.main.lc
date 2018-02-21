<table>
	<tr>
		<td><b>{$oLanguage->getMessage("DFrom")}:</b></td>
		<td><input id=date_from name=search[date_from]  style='width:100px;'
			readonly value='{if $smarty.request.search.date_from}{$smarty.request.search.date_from}{else
			}{$smarty.now-86400|date_format:"%Y-%m-%d"}{/if}'
	   		onclick="popUpCalendar(this, document.getElementById('date_from'), 'yyyy-mm-dd')">
	   	</td>
	   	<td>&nbsp;</td>
	   	<td><b>{$oLanguage->getMessage("DTo")}:</b></td>
	   	<td><input id=date_to name=search[date_to]  style='width:100px;'
			readonly value='{if $smarty.request.search.date_to}{$smarty.request.search.date_to}{else
			}{$smarty.now|date_format:"%Y-%m-%d"}{/if}'
	   		onclick="popUpCalendar(this, document.getElementById('date_to'), 'yyyy-mm-dd')">
   		</td>
	   	<td>&nbsp;</td>
   		<td><b>{$oLanguage->GetMessage('store')}:</b></td>
		<td><select name="search[store]">{html_options options=$aStores selected=$smarty.request.search.store}</select></td>
	</tr>
</table>