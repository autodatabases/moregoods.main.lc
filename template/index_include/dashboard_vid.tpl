        <!--<aside class="gm-aside-left">
            <div class="gm-block-filter close js-block-left-filter">
                <div class="head">
                    <div class="close js-block-left-filter-toggle"></div>
                    {$oLanguage->getMessage("to_filter")}
                </div>
                <div class="body">
              
   <div class="filter-element">
   <div class="filter-name">{$oLanguage->getMessage("you_choose")}:</div>
			{if $smarty.request.promo}
					{if $aPage.promo}<a id="{$aPage.promo}" href="{$sUrl}&remove_promo={$smarty.request.promo}" class="link-selected remove-filter-poromo" style="white-space: nowrap";>{$aPage.promo}</a>{/if}
					<br>
			{/if}		
			{if $smarty.request.brand}
					{if $aPage.brand}<a id="{$aPage.brand}" href="{$sUrl}&remove_brand={$smarty.request.brand}" class="link-selected remove-filter-brand" style="white-space: nowrap";>{$aPage.brand}</a>{/if}
			{/if}		
		<div class="link-clear">
			<a class="clear-filter"  
        {if $smarty.request.promo} href="/?action=catalog_vid&{if $smarty.request.group}group={$smarty.request.group}{/if}"
        {else}
            href="{$sUrl}{if $smarty.request.table}&table={$smarty.request.table}{/if}&remove_all=1" 
        {/if}
        class="gm-link-dashed">{$oLanguage->getMessage("clear_filter")}</a><br />
   		</div>
			{if $smarty.request.vid}
				{foreach from=$aTmpChooseBra item=aChooseBra}
					<a id="{$aChooseBra.name}" href="{$sUrl}&remove=vid&value={$aChooseBra.id}{if $smarty.request.table}&table={$smarty.request.table}{/if}" class="link-selected remove-filter-vid">{$aChooseBra.name}</a><br />
				{/foreach}
    		
			{/if}
		
    {if $smarty.request.choose}
    	{foreach from=$aTmpChoose item=aChoose}
    		<a id="{$aChoose.anval_nm}" href="{$sUrl}&remove=choose&value={$aChoose.id}{if $smarty.request.table}&table={$smarty.request.table}{/if}" class="link-selected remove-filter-atrib">{$aChoose.anval_nm}</a><br />
    	{/foreach}
    	{/if}
		
   	</div>
        <div class="filter-element">
             <label><input class="filter-vid-checkbox" id="" type="checkbox" {if $smarty.request.promo} checked {/if}
              onclick="document.location='/?action=catalog_promo&{if $smarty.request.group}group={$smarty.request.group}{/if}&promo=3{if $smarty.request.choose}&choose={$smarty.request.choose}{/if}'">
              <a class="filter-vid" id="" href="/?action=catalog_promo&{if $smarty.request.group}group={$smarty.request.group}{/if}&promo=3{if $smarty.request.choose}&choose={$smarty.request.choose}{/if}" onclick="document.location=this.href;">Акції</a></label>
        </div>
        {*if !$smarty.request.brand*}
		<div class="filter-element">
		      <div class="filter-name">{$oLanguage->getMessage("vid")}</div>
		      {foreach from=$aVidsFilter key=aKey item=aItem }
		      <label><input class="filter-vid-checkbox" id="{$aItem.name}" type="checkbox" {if $aItem.checked} checked {/if}
		      onclick="document.location='{$sUrl}&set_vid={$aItem.id_vid}{if $smarty.request.table}&table={$smarty.request.table}{/if}'">
		      <a class="filter-vid" id="{$aItem.name}" href="{$sUrl}&set_vid={$aItem.id_vid}{if $smarty.request.table}&table={$smarty.request.table}{/if}" onclick="document.location=this.href;">{$aItem.name}</a> ({$aItem.qty})</label>
		      {/foreach}
		  </div>
		{*/if*}
		{foreach from=$aAtributeAll item=aItem}
		<div class="filter-element">
		      <div class="filter-name">{$aItem.variable_nm}</div>
		      {foreach from=$aItem.atrib item=aAtrib}
		      <label><input class="filter-atrib-checkbox" id="{$aAtrib.anval_nm}" type="checkbox" {if $aAtrib.checked} checked {/if}
		      onclick="document.location='{$sUrl}&{if $aAtrib.checked}remove{else}add{/if}=choose&value={$aAtrib.id}{if $smarty.request.table}&table={$smarty.request.table}{/if}'">
		      <a class="filter-atrib-checkbox" id="{$aAtrib.anval_nm}" href="{$sUrl}&{if $aAtrib.checked}remove{else}add{/if}=choose&value={$aAtrib.id}{if $smarty.request.table}&table={$smarty.request.table}{/if}" onclick="document.location=this.href;">{$aAtrib.anval_nm}</a> ({$aAtrib.qty})</label>
		      {/foreach}
		  </div>
		{/foreach}
		<div class="filter-element">
                        <div class="filter-name">{$oLanguage->getMessage("price")}</div>
                        <input class="from-to" id="minCost" type="text" value='{if $smarty.request.price_min}{$smarty.request.price_min}{else}0{/if}' readonly> -
                        <input class="from-to" id="maxCost" type="text" value='{if $smarty.request.price_max}{$smarty.request.price_max}{else}2500{/if}' readonly>

                       <input class="send" type="submit" value=""
         onclick="document.location='/?action=catalog_vid&group={$smarty.request.group}{if $smarty.request.brand}&brand={$smarty.request.brand}{/if}{if $smarty.request.vid}&vid={$smarty.request.vid}{/if}{if $smarty.request.table}&table={$smarty.request.table}{/if}&price_min='+$('#minCost').val()+'&price_max='+$('#maxCost').val()">
                       <div class="slider">
                            <div id="slider"></div>
                            {literal}<script type="text/javascript">
                                jQuery("#slider").slider({
                                    min: 0,
                                    max: 2500,
                                    values: [($('#minCost').val()),($('#maxCost').val())],
                                    range: true,
                                    stop: function(event, ui) {
                                        minVal = ui.values[0];
                                        maxVal = ui.values[1];

                                        jQuery("input#minCost").val(minVal);
                                        jQuery("input#maxCost").val(maxVal);
                                    },
                                    slide: function(event, ui){
                                        minVal = ui.values[0];
                                        maxVal = ui.values[1];
                                        jQuery("input#minCost").val(minVal);
                                        jQuery("input#maxCost").val(maxVal);
                                    }
                                });
                            </script>{/literal}
                        </div>
                    </div>
                </div>
            </div>
        </aside> -->

        <section class="gm-section-content">
            <div class="gm-productlist-wrap">
                <div class="head">
                    <div class="block-view js-change-view">
                        {*<a href="{$sGroupChangeTableUrl}&table=list" class="list{if $smarty.request.table=='list'} selected{/if}" data-type="list"></a>
                        <a href="{$sGroupChangeTableUrl}&table=line" class="line{if $smarty.request.table=='line'} selected{/if}" data-type="line"></a>*}
                        <a href="{$sGroupChangeTableUrl}&table=thumb" class="thumb{if $smarty.request.table=='thumb'|| $smarty.request.table==''} selected{/if}" data-type="thumb"></a>
                    </div>

                    <div class="block-sort">
                        <span class="title">Сортувати:</span>
                        <select class="js-uniform" onchange="document.location=this.options[this.selectedIndex].value;">
                            <option {if $smarty.request.sort=='name'}selected="selected"{/if} value="{$sSeoUrl}{if $iSeoUrlAmp}&sort=name{else}sort=name{/if}">{$oLanguage->GetMessage('по імені')}</option>
                            <option {if $smarty.request.way=='up'}selected="selected"{/if} value="{$sSeoUrl}{if $iSeoUrlAmp}&sort=price&way=up{else}sort=price/way=up{/if}">{$oLanguage->GetMessage('зростанню ціни')}</option>
        					<option {if $smarty.request.way=='down'}selected="selected"{/if} value="{$sSeoUrl}{if $iSeoUrlAmp}&sort=price&way=down{else}sort=price/way=down{/if}">{$oLanguage->GetMessage('зменшенню ціни')}</option>
{*                            <option {if $smarty.request.sort=='new'}selected="selected"{/if} value="{$sSeoUrl}{if $iSeoUrlAmp}&sort=new{else}sort=new{/if}">{$oLanguage->GetMessage('новинки')}</option> *}
                        </select>
                    </div>
                    {if $smarty.request.table=='line'}
                    <div class="block-sort">
                        <a class="btn" href="/?action={if $smarty.request.action == 'catalog_promo'}catalog_promo{else}catalog_vid{/if}&group={$smarty.request.group}{if $smarty.request.vid}&vid={$smarty.request.vid}{/if}&catalog_export=1{if $smarty.request.action =='catalog_promo'}&promo={$smarty.request.promo}{/if}" style="margin: 0 50px;">
                            <span class="title">{$oLanguage->GetMessage('export_prices')}</span></a></div>
                    {/if}
                    <div class="block-filter">
                        <a href="#" class="gm-link-dashed js-block-left-filter-toggle">Фильтры</a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            {*<div class="gm-filter-values">
                <div class="filter-name">Вы выбрали:</div>
                <a href="#" class="link-selected">от 300  до 800 грн</a>
                <a href="#" class="link-selected">Украина</a>
                <a href="#" class="link-selected">От темных кругов</a>
                <a class="gm-link-dashed" href="#">Сбросить</a>
            </div> *}
{$sPriceTable}

        </section>
<div class="clear"></div>
{*if $template.sDescription && $template.sDescription!="&nbsp;"}{$template.sDescription}{/if*}