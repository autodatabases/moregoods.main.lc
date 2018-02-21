<script type="text/javascript" src="/libp/js/table.js"></script>
{if $bFormAvailable}<form id="table_form" {$sFormHeader}>{/if}

<table cellpadding="0" cellspacing="0" border="0" class="{$sClass}" width="100%">
{if $bHeaderVisible}
<thead>
<tr>
	{if $bCheckVisible}<th><input type=checkbox name=check_all
		onclick="mt.SetCheckboxes(this.form,this.checked);" {if $bDefaultChecked}checked{/if} ></th>
	{/if}


{foreach key=key item=aValue from=$aColumn}
	<th {if $aValue.sWidth} width="{$aValue.sWidth}"{/if}
		{if (!$smarty.request.order && $aValue.bOrderDefault==true) || ($key==$smarty.request.order)} class="sel" {/if}
	 nowrap>

	{if $aValue.sOrderLink}
	<a class="sel" href='./?{$aValue.sOrderLink}' {if $bAjaxStepper}onclick=" xajax_process_browse_url(this.href); return false;"{/if}>
	{/if}

	{if $aValue.sOrderLink	}
		{if $aValue.sOrderImage}&#9650;{/if}
	{/if}

	{$aValue.sTitle}
	{if !$aValue.sTitle}&nbsp;{/if}</th>
{/foreach}
</tr>
</thead>
{/if}

{include file=$sDataTemplate}

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


{if $sStepper}

<div class="pages2">
	{$sStepper}
</div>
{/if}