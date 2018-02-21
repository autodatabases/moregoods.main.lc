{*<div class="legend">
<a href="/">{$oLanguage->GetMessage("category price")}</a>
{foreach item=aImem from=$aNavigator}
{if $aImem.name} <span>›</span> <a href="{$aImem.url}">{$aImem.name}</a>{/if}
{/foreach}
</div>*}

{if count($aChildNavigator)}
<div class="legend-brand">
{$oLanguage->getMessage("Subcategories in this category")}:&nbsp;
{foreach item=aItem from=$aChildNavigator name=childnavi}
{if $aItem.name}<a href="
{if $oLanguage->getConstant('global:url_is_lower',0)}
	{$aItem.url|@lower}
{else}
	{$aItem.url}
{/if}
">{$aItem.name}</a> {if $smarty.foreach.childnavi.last}{else}<span>|</span>{/if} {/if}
{/foreach}
</div>
{/if}

{$sDescription}


<div class="legend-brand">

{capture name="sDelimeter"}{/capture}
 {foreach key=sKey item=sItem from=$aPriceGroupBrand}
 {if $smarty.capture.sDelimeter==''}
 	<a class="{if !$smarty.request.brand}sub_active{/if}" href="/select/{if $oLanguage->getConstant('global:url_is_lower',0)}{$sPg_code_name|@lower}{else}{$sPg_code_name}{/if}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}">{$oLanguage->getMessage("All")}</a> <span>|</span> {/if}
	{$smarty.capture.sDelimeter}
       	{if $oLanguage->getConstant('global:url_is_lower',0)}
       		<a class="{if $smarty.request.brand && $smarty.request.brand==$sItem.c_name|@lower}sub_active{/if}" href="/select/{$sItem.pg_code_name|@lower}/{$sItem.c_name|@lower}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}">{$sItem.c_title}</a>
    	{else}
    	   	<a class="{if $smarty.request.brand && $smarty.request.brand==$sItem.c_name}sub_active{/if}" href="/select/{$sItem.pg_code_name}/{$sItem.c_name}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}">{$sItem.c_title}</a>
    	{/if}
    {capture name="sDelimeter"} <span>|</span> {/capture}
{/foreach}
</div>