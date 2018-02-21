<script type="text/javascript" src="/libp/js/table.js"></script>

{if $smarty.get.table_error}
<div class="error_message">{$oLanguage->getMessage($smarty.get.table_error)}</div>
{/if}

{if $sTableMessage}<div class="{$sTableMessageClass}">{$sTableMessage}</div>{/if}


{if $bFormAvailable}<form id="{$sIdForm}" {$sFormHeader}>{/if}

<div {if $sIdTable!=""}id="{$sIdTable}"{/if} style="width:{$sWidth};border-spacing:{$sCellSpacing};padding:0px;">

{assign var="iTr" value="0"}
{section name=d loop=$aItem}
{assign var=aRow value=$aItem[d]}
{assign var=iTr value=$iTr+1}

{include file=$sDataTemplate}

{/section}


{if !$aItem}
<a class="child-element">
	{if $sNoItem}
		{$oLanguage->getMessage($sNoItem)}
	{else}
		{$oLanguage->getMessage("No items found")}
	{/if}
</a>
{/if}
            <span class="child-empty"></span>
            <span class="child-empty"></span>
            <span class="child-empty"></span>
            <span class="child-empty"></span>
            <span class="child-empty"></span>
</div>

{if $sStepper && !$bStepperOutTable && $aStepperData.iPageCount > 1}
	{$sStepper}
{/if}
{if $bFormAvailable}
<input type="hidden" name="action" id='action' value='{if $sFormAction}{$sFormAction}{else}empty{/if}'>
<input type="hidden" name="return" id='return' value='{$sReturn}'>
</form>
{/if}