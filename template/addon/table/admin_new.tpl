
{if $bFormAvailable}<form id='main_form' action='javascript:void(null);' onsubmit="submit_form(this)">{/if}
{if $sTableMessage}<div class="{$sTableMessageClass}">{$sTableMessage}</div>{/if}
<div class="table-responsive text-center" style="overflow-y: auto;">
<div class="col-md-12 header_table_admin ">
	<div class="rows_per_page col-md-3 col-xs-12">
	{$oLanguage->getDMessage('Display #')}
	<select class="btn-sm form-group" id=display_select_id name=display_select onchange="javascript:
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
	</div>
	<div class="filers form-inline col-md-9 col-xs-12">
		{if $sLeftFilter}
	{$sLeftFilter}
	<div class="form-group">
	<label class="new_check_lbl"><span></span><input type=checkbox id=search_strong_id name=data[search_strong] value='1' class="btn btn-sm new_check" {if $oLanguage->getConstant('mpanel_search_strong',0)}checked{/if}
    onchange="javascript:xajax_process_browse_url('?action=admin_search_strong_change&status='+document.getElementById('search_strong_id').checked); return false;">
    {$oLanguage->getDMessage('Searh strong')}</label>
    {/if}
    </div>
	</div>
</div>
<div class="pre-scrollable_new">
<table class="table-striped m-b-0 admin_itemslist_table" id='admin_itemslist_table'>
<thead>
{if $bHeaderVisible}
<tr>
	{if $bCheckVisible}<th>
		<input name="check_all" id="all" value="all" type="checkbox" {if $bDefaultChecked}checked{/if}>
	</th>{/if}

{foreach key=key item=aValue from=$aColumn}
	<th {if $aValue.sOrderImage}class="sel"{/if} {if $aValue.databreakpoints} data-breakpoints="{$aValue.databreakpoints}"{/if}>
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
</thead>
{/if}
<tbody>
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
</div>
{if $sStepper}<div class="col-md-12 "><div class="center-block-pag">
{$sStepper}
<br /><span class="label label-default">{$oLanguage->getDMessage('Results')} {$iStartRow} - {$iEndRow} of {$iAllRow}</span>
<br />
		{if $sLeftFilter}
		<div class="gotopage">
{$oLanguage->GetDMessage("move to page")}:&nbsp;
<input type='text' maxlength='5' class="btn-sm" name='step_page' id='step_page' style=" width: 35px;" onkeyup="this.value = this.value.replace (/\D/gi, '').replace (/^0+/, '')">
<a href="{$sCustomStepUrl}" class="btn btn-primary btn-sm" onclick="xajax_process_browse_url(this.href+document.getElementById('step_page').value);return false;"><b>{$oLanguage->GetDMessage("ok")}</b></a>
</div>
	{/if}
</div></div>{/if}


<table class ="stepper_table">
<tbody>
{if $sSubtotalTemplate} {include file=$sSubtotalTemplate} {/if}
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
</div>