<script type="text/javascript" src="/libp/js/table.js"></script>

{if $sTableMessage}<div class="{$sTableMessageClass}">{$sTableMessage}</div>{/if}


{if $bFormAvailable}<form id="{$sIdForm}" {$sFormHeader}>{/if}
{if $sPanelTemplateTop} {include file=$sPanelTemplateTop} {/if}

<div class="gm-product-line-list simple" {if $sIdTable!=""}id="{$sIdTable}"{/if} >

{if $sStepper && $bTopStepper}
<tr class="{$sStepperClass}">
	<td colspan="{$aColumn|@count}" style="text-align:{$sStepperAlign};">
	{$sStepper}
	</td>
</tr>
{/if}

{assign var="iTr" value="0"}
{section name=d loop=$aItem}
{assign var=aRow value=$aItem[d]}
{assign var=iTr value=$iTr+1}

	{include file=$sDataTemplate}
{/section}

{if $sSubtotalTemplate} {include file=$sSubtotalTemplate} {/if}

{if $sStepper && !$bStepperOutTable}
<tr class="{$sStepperClass}">
	<td colspan="{$aColumn|@count}" style="text-align:{$sStepperAlign};" class="{$sStepperClassTd}">
	{$sStepper}
	{if $bStepperInfo}
	<span class="{$sStepperInfoClass}">{$oLanguage->getDMessage('showing row')} {$iStartRow+1} - {if ($iEndRow==10000 && $iAllRow<10000) || $iAllRow<$iEndRow}{$iAllRow}{else}{$iEndRow}{/if} of {$iAllRow}</span>
	{/if}
	</td>
</tr>
{/if}
{if $bShowRowPerPage}
<tr>
	<td colspan="{$aColumn|@count}" style="text-align:right;">
	{$oLanguage->getDMessage('Display #')}
<select id=display_select_id name=display_select style="width: 50px;"
	onchange="{strip}javascript:
location.href='/?{$sActionRowPerPage}&content='+document.getElementById('display_select_id')
	.options[document.getElementById('display_select_id').selectedIndex].value; {/strip}">
	<option value=10 {if $iRowPerPage==10} selected{/if}>10</option>
    <option value=20 {if $iRowPerPage==20 || !$iRowPerPage} selected{/if}>20</option>
    <option value=50 {if $iRowPerPage==50} selected{/if}>50</option>
    <option value=100 {if $iRowPerPage==100} selected{/if}>100</option>
    {if $bShowPerPageAll}<option value=10000 {if $iRowPerPage==10000} selected{/if}>{$oLanguage->getMessage('all')}</option>{/if}
</select>

<span class="stepper_results">{$oLanguage->getDMessage('Results')} {$iStartRow} - {if $iEndRow==10000 && $iAllRow<10000}{$iAllRow}{else}{$iEndRow}{/if} {$oLanguage->getDMessage('of')} {$iAllRow}</span>
	</td>
</tr>
{/if}

</table>

{if $sStepper && $bStepperOutTable}
<div class="{$sStepperClass}">
	{$sStepper}
	{if $bStepperInfo}
	<span class="{$sStepperInfoClass}">{$oLanguage->getDMessage('showing row')} {$iStartRow+1} - {if ($iEndRow==10000 && $iAllRow<10000) || $iAllRow<$iEndRow}{$iAllRow}{else}{$iEndRow}{/if} {$oLanguage->getDMessage('of')} {$iAllRow}</span>
	{/if}
</div>
{/if}

<div style="padding: 5px;">
{if $sButtonTemplate} {include file=$sButtonTemplate} {/if}

{if $sAddButton}
<span {if $sButtonSpanClass}class="button"{/if}>
<input type=button class='btn' value="{$sAddButton}" onclick="location.href='{if !$bNoneDotUrl}.{/if}/?action={$sAddAction}'" >
</span>
{/if}
</div>


{if $bFormAvailable}
<input type="hidden" name="action" id='action' value='{if $sFormAction}{$sFormAction}{else}empty{/if}'>
<input type="hidden" name="return" id='return' value='{$sReturn}'>
</form>
{/if}