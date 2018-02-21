<form id="filter_form" name="filter_form" action="javascript:void(null)" onsubmit="submit_form(this)">

<table cellspacing=0 cellpadding=2 class=add_form>
	<tr>
		<th>Filter</th>
	</tr>
	<tr>
		<td>
            <table width="850" cellspacing="2" cellpadding="1">
    		<tr>
    			<td>Manager:</td>
    			<td><input type="text" style="width:110px;" maxlength="20" value="{$aSearchData.manager_login|escape}" name="search[manager_login]"></td>
    			<td>Status:</td>
    			<td>{html_options name="search[order_status]" options=$aOrderStatus selected=$iStatusSelected}</td>
    			<td>Date from:</td>
    			<td><input id="date_from" onclick="popUpCalendar(this, this, 'dd.mm.yyyy');" value="{if $aSearchData.date_from}{$aSearchData.date_from}{else}{$aSearchData.default_date_from}{/if}" readonly="" style="width: 80px;" name="search[date_from]"></td>
    			<td>Date To:</td>
    			<td><input id="date_to" onclick="popUpCalendar(this, this, 'dd.mm.yyyy');" value="{if $aSearchData.date_to}{$aSearchData.date_to}{else}{$aSearchData.default_date_to}{/if}" readonly="" style="width: 80px;" name="search[date_to]"></td>
    		</tr>
    	   </table>
		</td>
	</tr>
</table>

<input type="button" value="{$oLanguage->getDMessage('Clear')}"
	onclick="xajax_process_browse_url('?{$sSearchReturn|escape}')"
	class='bttn'>
<input type="submit" value="Search" class='bttn'>

<input type="hidden" name="action" value="{$sBaseAction}_search">
<input type="hidden" name="return" value="{$sSearchReturn|escape}">

</form>

<h3 style="padding:0 0 0 10px;">Total: <font color="red">$ {$dTotalSum}</font></h3>