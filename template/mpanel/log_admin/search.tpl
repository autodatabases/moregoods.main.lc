<form id="filter_form" name="filter_form" action="javascript:void(null)" onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th>Filter</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1 width=850>
			<tr>
				<td>{$oLanguage->GetDMessage('Admin')}:</td>
				<td><input type=text name=search[login] value="{$aSearch.login|escape}" maxlength=20
					style='width: 110px'></td>

				<td>{$oLanguage->GetDMessage('Date from')}:</td>
				<td><input id=date_from name=search[date_from] style='width: 80px;'
					readonly="readonly" value="{$aSearch.date_from|escape}"
					onclick="popUpCalendar(this, this, 'dd.mm.yyyy');"></td>
				<td>{$oLanguage->GetDMessage('Date To')}:</td>
				<td><input id=date_to name=search[date_to] style='width: 80px;'
					readonly="readonly" value="{$aSearch.date_to|escape}"
					onclick="popUpCalendar(this, this, 'dd.mm.yyyy');"></td>
			</tr>
			<tr>
				<td>{$oLanguage->GetDMessage('Action')}:</td>
				<td><input type=text name=search[action] value="{$aSearch.action|escape}" maxlength=20
					style='width: 110px'></td>
				<td>{$oLanguage->GetDMessage('TableName')}:</td>
				<td><input type=text name=search[table_name] value="{$aSearch.table_name|escape}" maxlength=20
					style='width: 110px'></td>
				<td>{$oLanguage->GetDMessage('IP')}:</td>
				<td><input type=text name=search[ip] value="{$aSearch.ip|escape}" maxlength=20
					style='width: 110px'></td>
			</tr>
		</table>

		</td>
	</tr>
</table>

<input type=button class='bttn' value="{$oLanguage->getDMessage('Clear')}"
	onclick="xajax_process_browse_url('?{$sSearchReturn|escape}')">
<input type=submit value='Search' class='bttn'>

<input type=hidden name=action value={$sBaseAction}_search>
<input type=hidden name=return value="{$sSearchReturn|escape}">

</form>