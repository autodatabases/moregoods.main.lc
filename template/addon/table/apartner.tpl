<script type="text/javascript" src="/libp/js/table.js"></script>
{if $bFormAvailable}<form id="table_form" {$sFormHeader}>{/if}

<table cellpadding="0" cellspacing="0" border="0" class="list_tbl">
{if $bHeaderVisible}
<thead>
<tr>
	{if $bCheckVisible}<th><input type=checkbox name=check_all
		onclick="mt.SetCheckboxes(this.form,this.checked);" {if $bDefaultChecked}checked{/if} ></th>
	{/if}


{foreach key=key item=aValue from=$aColumn}
	<th {if $aValue.sWidth} width="{$aValue.sWidth}"{/if} nowrap>
	{if $aValue.sOrderLink}
	<a class="sel" href='./?{$aValue.sOrderLink}' {if $bAjaxStepper}onclick=" xajax_process_browse_url(this.href); return false;"{/if}
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


{section name=d loop=$aItem}
<tr class="{cycle values="even,none"}">
{assign var=aRow value=$aItem[d]}
	{if $bCheckVisible}<td><input type=checkbox name=row_check[]
		id='row_check_{$smarty.section.d.index}' value='{$aRow.$sCheckField}' {if $bDefaultChecked} checked{/if} ></td>
	{/if}
{include file=$sDataTemplate}
</tr>
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


{if $sSubtotalTemplate} {include file=$sSubtotalTemplate} {/if}

</table>

<div style="padding: 5;">
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


{if $sStepper}

<div class="pages2">
	{$sStepper}
</div>
{/if}