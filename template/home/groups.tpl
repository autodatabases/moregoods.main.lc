<h2 class="at-caption">{$oLanguage->getMessage('Select groups')}</h2>
<div class="at-category-block">
{foreach item=aItem from=$aMainGroups}
{if $aItem.is_main}
<div class="item">
	<div class="image-container">
		<a href="/select/{if $oLanguage->getConstant('global:url_is_lower',0)}{$aItem.code_name|@lower}{else}{$aItem.code_name}{/if}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}">
			<img src="{$aItem.image}" alt="" width="62" height="62" />
		</a>
	</div>
	<div class="text">
		<a href="/select/{if $oLanguage->getConstant('global:url_is_lower',0)}{$aItem.code_name|@lower}{else}{$aItem.code_name}{/if}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}" class="name">{$aItem.name}</a>
		<div class="sub-category">
			{foreach item=aItemsBrand from=$aItem.brand}
				{if $oLanguage->getConstant('global:url_is_lower',0)}
					<a href="/select/{$aItem.code_name|@lower}/{$aItemsBrand.c_name|@lower}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}">{$aItemsBrand.c_title}</a>
				{else}
					<a href="/select/{$aItem.code_name}/{$aItemsBrand.c_name}/">{$aItemsBrand.c_title}</a>
				{/if}
			{/foreach}
    			<a href="/select/{if $oLanguage->getConstant('global:url_is_lower',0)}{$aItem.code_name|@lower}{else}{$aItem.code_name}{/if}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}" class="other">Другие</a>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>
{/if}
{/foreach}
<div class="item-fake">&nbsp;</div>
<div class="item-fake">&nbsp;</div>
</div>