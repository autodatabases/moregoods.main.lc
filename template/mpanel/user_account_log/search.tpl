<form id="filter_form" name="filter_form" action="javascript:void(null)" onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th>{$oLanguage->getDMessage('Filter')}:</th>
	</tr>
	<tr>
		<td>

		<table cellspacing=2 cellpadding=1 width=850>
			<tr>
				<td valign=top>{$oLanguage->getDMessage('ULogin')}:</td>
				<td><input type=text name=search[login]
					value="{$aSearch.login|escape}" maxlength=20
					style='width: 80px'>
					<!--select name=search[user_type] style='width: 75px'>
						{html_options options=$aUserType selected=$aSearch.user_type}
					</select-->
				</td>

				<td>{$oLanguage->getDMessage('Date from')}:</td>
				<td><input id=date_from name=search[date_from] style='width: 80px;'
					readonly="readonly" value="{if $aSearch.date_from}
													{$aSearch.date_from|escape}
												{else}
													{$sFromDate|date_format:'%d.%m.%Y'}
												{/if}"
					onclick="popUpCalendar(this, this, 'dd.mm.yyyy');"></td>

				<td>{$oLanguage->getDMessage('Date To')}:</td>
				<td><input id=date_to name=search[date_to] style='width: 80px;'
					readonly="readonly" value="{if $aSearch.date_to}
													{$aSearch.date_to|escape}
												{else}
													{$sForDate|date_format:'%d.%m.%Y'}
												{/if}"
					onclick="popUpCalendar(this, this, 'dd.mm.yyyy');"></td>
				<td></td>
				<td>{$oLanguage->getDMessage('Custom Id')}:</td>
				<td><input type=text name=search[custom_id]
					value="{$aSearch.custom_id|escape}" maxlength=20
					style='width: 110px'></td>
			</tr>
			<tr>
				<td>{$oLanguage->getDMessage('Amount')}:</td>
				<td><input type=text name=search[amount]
					value="{$aSearch.amount|escape}" maxlength=20
					style='width: 110px'></td>

				<td>{$oLanguage->getDMessage('Pay Type')}:</td>
				<td><select name=search[pay_type] style='width:110px'>
						<option value=''>{$oLanguage->GetDMessage('All')}</option>
				 		{html_options values=$aPayType output=$aPayType selected=$aSearch.pay_type}
					</select></td>

				<td>{$oLanguage->getDMessage('Description')}:</td>
				<td colspan="2"><input type=text name=search[description]
					value="{$aSearch.description|escape}" maxlength=150
					style='width: 110px'></td>

				<td>{$oLanguage->getDMessage('Account')}:</td>
				<td>
				 	{html_options name=search[id_account]  options=$aAccount
				 		selected=$aSearch.id_account style='width: 110px'}
				</td>
			</tr>
			<tr>
				<td>{$oLanguage->getDMessage('Type')}:</td>
				<td><select name=search[type_] style='width:110px'>
					 {html_options options=$aType selected=$aSearch.type_}
					</select></td>

				<td>{$oLanguage->getDMessage('Section')}:</td>
				<td><select name=search[section] style='width:110px'>
						<option value=''>{$oLanguage->GetDMessage('All')}</option>
   						{html_options values=$aSection selected=$aSearch.section output=$aSection}
					</select></td>

				<td>&nbsp;</td>
				<td colspan="2">&nbsp;</td>

				<td>{$oLanguage->getDMessage('Account Log Type')}:</td>
				<td>
				<select name=search[id_user_account_log_type]  style="width:110px">
					<option value=''>{$oLanguage->GetDMessage('All')}</option>
				 	{html_options  options=$aUserAccountLogType	selected=$aSearch.id_user_account_log_type}
				</select>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="140" nowrap><input type=button class='bttn' value="{$oLanguage->getDMessage('Clear')}"
	onclick="xajax_process_browse_url('?{$sSearchReturn|escape}')">
<input type=submit value='Search' class='bttn'>
</td>
    <td nowrap>
{if $dTotalAmountDebet || $dTotalAmountCredit}
  <b><span id="total_amount" style="color:red">
    {$oLanguage->GetDMessage('Debet:')} {$dTotalAmountDebet}
    {$oLanguage->GetDMessage('Credit:')} {$dTotalAmountCredit}
    </span></b>

    &nbsp;&nbsp;&nbsp;

    <a href="?action={$sBaseAction}_export"
	onclick="xajax_process_browse_url(this.href); return false;" class="submenu">
	<img hspace="3" border="0" align="absmiddle" src="/libp/mpanel/images/small/outbox.png"/
	>{$oLanguage->GetDMessage('Export to excel')}</a>
{/if}
    </td>
  </tr>
</table>

<div id="export_file_id"></div>

<input type=hidden name=action value={$sBaseAction}_search>
<input type=hidden name=return value="{$sSearchReturn|escape}">

</form>