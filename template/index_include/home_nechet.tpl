{if $aProductList}
<div class="gm-block-sales js-block-sales">
	<div class="gm-mainer">
    <h2 class="line-through"  style="margin:0 0 0 0;"><span>{$aGroupP.name}</span></h2>

    <div class="gm-product-carousel js-product-carousel">
        <div class="wrapper">
        {foreach item=aRow from=$aProductList}
            <div>
 			{include file='index_include/row_thumb.tpl'}
{*               <div class="element">
                    <a href="javascript:void(0)" class="link-favorite{if $aRow.is_fav} active{/if}" id='fav_{$aRow.id}'></a>
                    <div class="image"><a href="/?action=catalog_product&product={$aRow.id}"><img src="{$aRow.image}" alt=""></a></div>
                    <div class="name"><a href="/?action=catalog_product&product={$aRow.id}">{$aRow.name}</a></div>
                    <div class="description">{$aRow.description}</div>
                    <div class="price">{$oCurrency->PrintPrice($aRow.price)}</div>
                    <div class="expand">
                       { * <div class="options no-margin">
                            <select class="js-uniform">
                                <option value="">30 ML</option>
                                <option value="">180 ML</option>
                                <option value="">500 ML</option>
                            </select>
                        </div>
                        * }
                        <div class="button">
                            <a href="javascript:void(0)" class="gm-button gm-button-buy" id="buy_{$aRow.id}">{$oLanguage->GetMessage('buy')}</a>
                        </div>
                    </div>
                </div>
*}				
            </div>
        {/foreach}
        </div>
    </div>
    </div>
</div>
{/if}