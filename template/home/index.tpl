<h2 class="at-caption">{$oLanguage->getMessage('Select parts by auto')}</h2>
<div class="at-car-category">
	{foreach item=aItem from=$aCatalog}
	<div class="item">
		{if $oLanguage->getConstant('global:url_is_lower',0)}
        <a href="/pages/catalog_brand/?brand={$oContent->Translit($aItem.name)|@lower}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}">
		{else}
        <a href="/pages/catalog_brand/?brand={$oContent->Translit($aItem.name)}{if $oLanguage->getConstant('global:url_is_not_last_slash',0)}{else}/{/if}">
		{/if}
            <img src="{$aItem.image}" alt="" height='20' />
            {$aItem.title}
        </a>
    </div>
    {/foreach}
    <br>
 	<div class="item">
        <a href="/?action=catalog" class="se-all">{$oLanguage->GetMessage('all brands')}</a>
    </div>
    <!-- Важно оставить!! для правильного позиционирования по ширине -->
    <div class="item-fake">&nbsp;</div>
    <div class="item-fake">&nbsp;</div>
    <div class="item-fake">&nbsp;</div>
    <div class="item-fake">&nbsp;</div>
    <div class="item-fake">&nbsp;</div>
    <div class="item-fake">&nbsp;</div>
    <!-- Важно оставить!! для правильного позиционирования по ширине -->
</div>