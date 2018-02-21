{$oLanguage->GetText('Top Report Conten1t')}

<form id="filter_form" name="filter_form" action="javascript:void(null)" onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class="add_form">
	<tr>
		<th>Filter</th>
	</tr>
	<tr>
		<td>

		<table width="850" cellspacing="2" cellpadding="1">
		<tr>
			<td>{$oLanguage->getDMessage('Report List')}:</td>
			<td>
			{html_options name=search[filter_name] values=$aFilterName output=$aFilterName selected=$aSearch.filter_name}
			</td>
			<td>{$oLanguage->getDMessage('Date from')}:</td>
			<td><input id=date_from name=search[date_from] style='width: 80px;'
					readonly="readonly" value="{$aSearch.date_from|escape}"
					onclick="popUpCalendar(this, this, 'dd.mm.yyyy');"></td>
			<td>{$oLanguage->getDMessage('Date To')}:</td>
			<td><input id=date_to name=search[date_to] style='width: 80px;'
					readonly="readonly" value="{$aSearch.date_to|escape}"
					onclick="popUpCalendar(this, this, 'dd.mm.yyyy');"></td>
		</tr>
		<tr>
			<td>{$oLanguage->getDMessage('Region')}:</td>
			<td>

	<select name=search[id_partner_region] style='width: 160px'>
   		<option value=0>{$oLanguage->getMessage("Other region")}</option>
		{foreach from=$aPartnerRegion item=aItem}
		<option value={$aItem.id}
			{if $aItem.id == $aSearch.id_partner_region} selected {/if}
				> {$aItem.name}</option>
		{/foreach}
	</select>
			</td>
		</tr>

	   </table>

		</td>
	</tr>
</table>

<input type=button class='bttn' value="{$oLanguage->getDMessage('Clear')}"
	onclick="xajax_process_browse_url('?{$sSearchReturn|escape}')">
<input type=submit value='{$oLanguage->GetDMessage('Create Report')}' class='bttn'>

<input type=hidden name=action value={$sBaseAction}_search>
<input type=hidden name=return value="{$sSearchReturn|escape}">

</form>