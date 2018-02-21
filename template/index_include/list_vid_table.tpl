<div class="gm-product-list-list no-mobile js-product-list-list" {if $sIdTable!=""}id="{$sIdTable}"{/if}>
                
{assign var="iTr" value="0"}
{section name=d loop=$aItem}
{assign var=aRow value=$aItem[d]}
{assign var=iTr value=$iTr+1}

{include file=$sDataTemplate}

{/section}
{$sStepper}

</div>

<div class="clear"></div>