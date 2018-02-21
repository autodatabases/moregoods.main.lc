{if $aPopularProducts}
<div class="gm-mainer">
    <h2 class="line-through"   style="margin:0 0 0 0;">{*<span>{$oLanguage->GetMessage('popular products')}</span>*}</h2>

    <div class="gm-product-carousel js-product-carousel">
        <div class="wrapper">
        {foreach from=$aPopularProducts item=aRow}
            <div>
 			 <script type="text/javascript" src="/js/cart.js"></script>     
<div class="gm-product-thumb-element">
               <div class="element-wrap" style="border: 1px dotted #666;
    padding: 10px;">
               <div class="label nocolor" style="padding-left:0;">
                {if !$aRow.promo}
                    <span id="promo_{$aRow.id_product}_1" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: '';"></span>
                    <span id="promo_{$aRow.id_product}_2" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: '';"></span>
                    <span id="promo_{$aRow.id_product}_3" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: '';"></span>
                    <span id="promo_{$aRow.id_product}_4" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: '';"></span>
                
                {else}
                             {foreach from=$aRow.promo item=aItemP}
                                {if $aItemP.i==3}<br>{/if}<span id="promo_{$aRow.id_product}_{$aItemP.i}" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: {$aItemP.color};">{$aItemP.name}</span>
                             {/foreach}
                {/if}            
               </div>
                   <a href="javascript:void(0)" class="link-favorite {if $aRow.is_fav}active{/if}" id="fav_{$aRow.id}"></a>
                   <div class="image"><a  href="/?action=catalog_product&product={$aRow.id}" id="image_{$aRow.id_product}"><img class="image_cont" src="{$aRow.image}" alt="{$aRow.name}"></a></div>
                   <div class="name"><a  href="/?action=catalog_product&product={$aRow.id}">{$aRow.name}</a></div>
                   {*<div class="description">{$aRow.short_name}</div>*}
                    <div class="button" id="pricemain_{$aRow.id_product}" style="margin-bottom: 10px;">
                             <a href="javascript:void(0)" class="gm-button gm-button-buy {if $aRow.in_cart}already{/if}{if $aRow.stock<$aRow.min_stock}missing{/if}" id="buy_{$aRow.id}">
                                {if $aRow.in_cart}{$oLanguage->GetMessage('in_cart')}{elseif $aRow.stock<$aRow.min_stock}{$oLanguage->GetMessage('expected')}{else}{$oLanguage->GetMessage('buy')} {/if}</a>
                        </div>
                   <div class="price-before" {if $aRow.from_matrica==1}style="color:blue"{else}style="color:green"{/if}>
                   {if $aAuthUser.type_=='manager'}
                   {if $aRow.discount !=0}
                    {$aRow.discount*-1.00}%&nbsp;{if $aRow.promo.0.id_type_skidka==3}A{else}D{/if}&nbsp;{$oCurrency->PrintPrice($aRow.base_price)}
                    {/if}
                   {/if}
                    {* if $aRow.base_price}
                        <a>{$aRow.sRozn}</a>
                        <span id="price_{$aRow.id_product}_base">{$oCurrency->PrintPrice($aRow.base_price)}</span>
                        {else}
                        <a> </a>
                    {/if *}
                   </div>
                   <div class="price">
                    {*if $aRow.promo.0.skidka!=0*}
                        <a id="price_old_{$aRow.id_product}" style="text-decoration: line-through;font-size: 14px;">{if $aRow.promo.0.skidka!=0}{$oCurrency->PrintPrice($aRow.price)}{/if}</a>
                        {*else*}
                        {*<a> </a>*}
                    {*/if*}
                   <span id="price_{$aRow.id_product}"  
                   {if $aRow.promo.0.skidka!=0} style ="color:#ba0000;font-size: 20px;" {/if}>{if $aRow.promo.0.skidka==0}{$oCurrency->PrintPrice($aRow.price)} {else} 
                   
                   {if $aRow.promo.0.id_type_skidka==3} {$oCurrency->PrintPrice($aRow.base_price*$aRow.promo.0.skidka)}  {else} {$oCurrency->PrintPrice($aRow.price*$aRow.promo.0.skidka)}  {/if}

                   {* $oCurrency->PrintPrice(round(round(round($aRow.price*$aRow.promo.0.skidka,2)/1.2,2)*1.2,2)) *}  

                   
                   {/if}</span>
                   </div>
                   {*<div class="expand">
                   {if $aRow.select_type==0}
                        <div class="options" id="{$aRow.id_product}">
                         {foreach from=$aRow.child item=aItem}    
                            <a 
                            class="{if $aItem.check_==1} selected {/if} notselected" id="price2_{$aRow.id_product}_{$aItem.id}" 
                            name="{$aItem.price}_{$aItem.id}_{$aItem.image}_{$aItem.stock}_{$aItem.min_stock}_{if $aItem.promo.0.skidka==0}{$aItem.price}{else}{if $aRow.promo.0.id_type_skidka==3}{$aItem.base_price*$aItem.promo.0.skidka}{else}{$aItem.price*$aItem.promo.0.skidka}{/if}{/if}_{$aItem.in_cart}_{$aItem.promo.0.name}_{$aItem.promo.0.color}_{$aItem.promo.1.name}_{$aItem.promo.1.color}_{$aItem.promo.2.name}_{$aItem.promo.2.color}_{$aItem.promo.3.name}_{$aItem.promo.3.color}" onmouseenter="OnPriceThumb2('price_{$aRow.id_product}', 'price2_{$aRow.id_product}_{$aItem.id}', 'pricemain_{$aRow.id_product}', 'image_{$aRow.id_product}', '{$aRow.id_product}'); return false;">{$aItem.short_name}</a>
                         {/foreach}
                        </div>
                    {elseif $aRow.select_type==1}   
                        <div class="options no-margin">
                            <select class="js-uniform" id="price2_{$aRow.id_product}" onchange="OnPriceThumb('price_{$aRow.id_product}','price2_{$aRow.id_product}', 'pricemain_{$aRow.id_product}', 'image_{$aRow.id_product}'); return false;">
                             {foreach from=$aRow.child item=aItem}        
                                <option id="price_{$aRow.id_product}_{$aItem.id}" value="{$aItem.price}_{$aItem.id}_{$aItem.image}_{$aItem.stock}_{$aItem.min_stock}_{$aItem.in_cart}">{$aItem.short_name}</option>
                             {/foreach}
                            </select>
                        </div>
                    {else}
                    {/if}   
                       
                   </div>
               </div>*}
</div>
             


{*                <div class="element">
                    <a href="javascript:void(0)" class="link-favorite{if $aRow.is_fav} active{/if}" id='fav_{$aRow.id_products}'></a>
                    <div class="image"><a href="/?action=catalog_product&product={$aRow.id_products}"><img src="{$aRow.image}" alt=""></a></div>
                    <div class="name"><a href="/?action=catalog_product&product={$aRow.id_products}">{$aRow.name}</a></div>
                    <div class="description">{$aRow.description}</div>
                    <div class="price">{$oCurrency->PrintPrice($aRow.price)}</div>
                    <div class="expand">
                        { *<div class="options no-margin">
                            <select class="js-uniform">
                                <option value="">30 ML</option>
                                <option value="">180 ML</option>
                                <option value="">500 ML</option>
                            </select>
                        </div>* }
                        <div class="button">
                            <a href="javascript:void(0)" class="gm-button gm-button-buy" id="buy_{$aRow.id_products}">{$oLanguage->GetMessage('buy')}</a>
                        </div>
                    </div>
                </div>
*}				
            </div>
        {/foreach}
        </div>
    </div>
</div>
{/if}

<!-- Популярные товары на главной -->
{*<h2 class="at-caption">{$oLanguage->GetMessage('popular products')}</h2>
<div class="at-car-category" style="padding-bottom: 0;"></div>

<div class="main-block popular-home-block" id="popular-home-block">
    <div class="in"  id="popular-carousel-wrap">
	<div class="popular-home-list" id="popular-carousel">
	    {foreach from=$aPopularProducts item=aRow}
	    <div class="item">
		<a href="/?action=catalog_product&product={$aRow.id_products}" class="block-link">&nbsp;</a>
		<div class="img-holder"><img src="{$aRow.image}" alt="{$aRow.name}" /></div>
		<span class="title">{$aRow.name}</span>
		
		<a href="/?action=catalog_product&product={$aRow.id}" class="btn-buy" ><span>{$oLanguage->GetMessage('buy')}</span></a>
		
		{if $aRow.old_price>0}<span class="price old"><span>{$oCurrency->PrintPrice($aRow.old_price)}</span></span>{/if}
		<span class="price{if $aRow.old_price>0} new{/if}">{$oCurrency->PrintPrice($aRow.price,0,0,'strong')}</span>
		{if $aRow.bage}<span class="badge {$aRow.bage}"></span>{/if}
	    </div>
	    {/foreach}
	</div>
	    <div id="popular-carousel-left"></div>
	    <div id="popular-carousel-right"></div>
    </div>
</div>*}
<!-- End Популярные товары на главной -->
