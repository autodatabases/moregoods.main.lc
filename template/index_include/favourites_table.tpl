{*<div class="gm-block-favorite-head">
                <div class="cell-check">
                    <input type="checkbox">
                </div>
                <div class="cell-count">
                    5 товаров на сумму: <strong>4 000 грн</strong>
                </div>
                <div class="cell-button">
                    <a href="#" class="gm-button">Купить</a>
                </div>
            </div>
            *}
            <script type="text/javascript" src="/libp/js/table.js"></script>

<div {if $sIdTable!=""}id="{$sIdTable}"{/if} class="gm-product-line-list simple favorite">
               
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
            
            