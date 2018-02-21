<script src="/js/popcalendar.js"></script>

<table width=100% border=0>
	<tr>
		<td><b>{$oLanguage->getMessage("From")}:</b></td>
		<td><input type=text name=search_from value='{$smarty.request.search_from}' maxlength=20 style='width:110px'></td>
		<td><b>{$oLanguage->getMessage("To")}:</b></td>
		<td><input type=text name=search_to value='{$smarty.request.search_to}' maxlength=20 style='width:110px'></td>
	</tr>
	<tr>
		<td>
		<input type=checkbox name=search_date value=1 {if $smarty.request.search_date}checked{/if}>
		<b>{$oLanguage->getMessage("DFrom")}:</b></td>
		<td><input id=date_from name=date_from  style='width:100px;'
				readonly value='{if $smarty.request.date_from}{$smarty.request.date_from}{else}{$smarty.now-$oLanguage->getConstant('popup_calendar:left_board',30)*86400|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, document.getElementById('date_from'), 'dd.mm.yyyy')">
		</td>
		<td><b>{$oLanguage->getMessage("DTo")}:</b></td>
		<td><input id=date_to name=date_to  style='width:100px;'
				readonly value='{if $smarty.request.date_to}{$smarty.request.date_to}{else}{$smarty.now+86400|date_format:"%d.%m.%Y"}{/if}'
   			 	onclick="popUpCalendar(this, document.getElementById('date_to'), 'dd.mm.yyyy')">
		</td>

	</tr>
</table>