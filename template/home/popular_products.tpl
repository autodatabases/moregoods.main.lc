<div class="gm-mainer">
    <h2 class="line-through"><span>{$oLanguage->GetMessage('popular products')}</span></h2>

    <div class="gm-product-carousel js-product-carousel">
        <div class="wrapper">
        {foreach from=$aPopularProducts item=aRow}
            <div>
                <div class="element">
                    <a href="javascript:void(0)" class="link-favorite{if $aRow.is_fav} active{/if}" id='fav_{$aRow.id_products}'></a>
                    <div class="image"><a href="/?action=catalog_product&product={$aRow.id_products}"><img src="{$aRow.image}" alt=""></a></div>
                    <div class="name"><a href="/?action=catalog_product&product={$aRow.id_products}">{$aRow.name}</a></div>
                    <div class="description">{$aRow.description}</div>
                    <div class="price">{$oCurrency->PrintPrice($aRow.price)}</div>
                    <div class="expand">
                        {*<div class="options no-margin">
                            <select class="js-uniform">
                                <option value="">30 ML</option>
                                <option value="">180 ML</option>
                                <option value="">500 ML</option>
                            </select>
                        </div>*}
                        <div class="button">
                            <a href="javascript:void(0)" class="gm-button gm-button-buy" id="buy_{$aRow.id_products}">{$oLanguage->GetMessage('buy')}</a>
                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
        </div>
    </div>
</div>
{*
<!-- Популярные товары на главной -->
<h2 class="at-caption">{$oLanguage->GetMessage('popular products')}</h2>
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
</div>
<!-- End Популярные товары на главной -->
*}