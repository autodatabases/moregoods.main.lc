{if $bFormAvailable}<form id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">{/if}
{if $sTableMessage}<div class="{$sTableMessageClass}">{$sTableMessage}</div>{/if}
<table class="itemslist" id='admin_itemslist_table'>
<tbody>
{if $bHeaderVisible}
<tr>
	{if $bCheckVisible}<th width="20">
		<input name="check_all" id="all" value="all" type="checkbox" {if $bDefaultChecked}checked{/if}>
	</th>{/if}

{foreach key=key item=aValue from=$aColumn}
	<th {if $aValue.sWidth} width="{$aValue.sWidth}"{/if} {if $aValue.sOrderImage}class="sel"{/if} nowrap>
	{if $aValue.sOrderLink}
	<a href='./?{$aValue.sOrderLink}' {if $bAjaxStepper}onclick=" xajax_process_browse_url(this.href); return false;"{/if}
		>{/if}
	{$aValue.sTitle}

	{if $aValue.sOrderLink}
		{if $aValue.sOrderImage}<img src='{$aValue.sOrderImage}' border=0 hspace=1>{/if}
	</a>{/if}

	{if !$aValue.sTitle}&nbsp;{/if}</th>
{/foreach}
</tr>
{/if}

{assign var="num" value=1}
{section name=d loop=$aItem}
{assign var=aRow value=$aItem[d]}
<tr class="{cycle values="even,none"}">
	{if $bCheckVisible}
		<td><input name="row_check[{$num}]" value="{$aRow.$sCheckField}" type="checkbox"></td>
	{/if}
{include file=$sDataTemplate}
</tr>
{assign var="num" value=$num+1}
{/section}


{if !$aItem}
<tr>
	<td class=even colspan=20>
	{if $sNoItem}
		{$oLanguage->getMessage($sNoItem)}
	{else}
		{$oLanguage->getMessage("No items found")}
	{/if}
	</td>
</tr>
{/if}
</tbody>
</table>
<table style="width: 100%;">
<tbody>
{if $sSubtotalTemplate} {include file=$sSubtotalTemplate} {/if}

{if $sStepper}
{literal}

{/literal}
<tr class="stepper">
	{if $sLeftFilter}
	<td colspan={$iColspanFilter}>{$sLeftFilter}</td>
	{/if}
	<td colspan="20" align="right" class="pages">
	{$sStepper}
	</td>
</tr>
{/if}

{if $bShowRowPerPage}
<tr>
	<td><nobr>
    <input type=checkbox id=search_strong_id name=data[search_strong] value='1' style="width:22px;" {if $oLanguage->getConstant('mpanel_search_strong',0)}checked{/if}
    onchange="javascript:
	xajax_process_browse_url('?action=admin_search_strong_change&status='+document.getElementById('search_strong_id').checked); return false;">
    {$oLanguage->getDMessage('Searh strong')}
    </td>
	<td colspan="20" align="right">
	{$oLanguage->getDMessage('Display #')}
<select id=display_select_id name=display_select style="width: 50px;"
	onchange="javascript:
xajax_process_browse_url('?action={$sAction}_display_change&content='+document.getElementById('display_select_id').options[document.getElementById('display_select_id').selectedIndex].value); return false;">
	<option value=5 {if $iRowPerPage==5} selected{/if}>5</option>
    <option value=10 {if $iRowPerPage==10 || !$iRowPerPage} selected{/if}>10</option>
    <option value=20 {if $iRowPerPage==20} selected{/if}>20</option>
    <option value=30 {if $iRowPerPage==30} selected{/if}>30</option>
    <option value=50 {if $iRowPerPage==50} selected{/if}>50</option>
    <option value=100 {if $iRowPerPage==100} selected{/if}>100</option>
    <option value=200 {if $iRowPerPage==200} selected{/if}>200</option>
    <option value=500 {if $iRowPerPage==500} selected{/if}>500</option>
    <option value=1000 {if $iRowPerPage==1000} selected{/if}>1000</option>
</select>

<span class=stepper_results>{$oLanguage->getDMessage('Results')} {$iStartRow} - {$iEndRow} of {$iAllRow}</span>
	</td>
</tr>
{/if}
</tbody>
</table>
<div style="padding: 5px;">
{if $sButtonTemplate} {include file=$sButtonTemplate} {/if}

{if $sAddButton}
<input type=button value="{$sAddButton}" onclick="location.href='./?action={$sAddAction}'" >
{/if}
</div>

{if $bFormAvailable}
<input type=hidden name=action id='action' value='empty'>
<input type=hidden name=return id='return' value=''>
</form>
{/if}