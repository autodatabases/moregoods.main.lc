<div class="gm-product-thumb-list only-mobile js-product-thumb-list" {if $sIdTable!=""}id="{$sIdTable}"{/if}>
{assign var="iTr" value="0"}
{section name=d loop=$aItem}
{assign var=aRow value=$aItem[d]}
{assign var=iTr value=$iTr+1}

{include file=$sDataTemplate}

{/section}
{$sStepper}

               <div class="gm-product-thumb-empty"></div>
                <div class="gm-product-thumb-empty"></div>
                <div class="gm-product-thumb-empty"></div>
            </div>