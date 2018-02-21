{*<td>{$aRow.code}</td>
<td>{$aRow.name}</td>
<td>{$aRow.brand}</td>
<td>{$aRow.post_date}</td>
<td><a href="{if $aRow.id_product}/?action=catalog_product&product={$aRow.id_product}{else}/?action=catalog_price_view&code={$aRow.code}{/if}">
{$oLanguage->getMessage('View')}</a></td>
*}
<hr>
<div class="gm-product-line-element">
    <div class="cell-check">
        <input type="checkbox">
    </div>
    <div class="cell-image">
        <a href="#" class="block-image">
            <span class="wrap">
{*<span class="label green">НОВИНКА</span>*}
<span class="image"><img src="{$aRow.image}" alt=""></span>
            </span>
        </a>
    </div>
    <div class="cell-name">
        <a href="/?action=catalog_product&product={$aRow.id_product}">{$aRow.name}</a>
        <span>(Код товара: {$aRow.id_product}) {*<em class="green">Новинка</em>*}</span>
    </div>
    <div class="cell-favorite">
        <a href="javascript:void(0)" id="fav_{$aRow.id_product}" class="link-favorite active"></a>
    </div>
    <div class="cell-price">{$aRow.price|round:2} грн</div>
    <div class="cell-counter">
        <div class="gm-block-counter js-block-count">
            <span class="plus"></span>
            <span class="minus"></span>
            <input class="count" type="text" value="1">
        </div>
    </div>
    <div class="cell-button">
        <a href="javascript:void(0)" class="gm-icon-buy" id="buy_{$aRow.id_product}"></a>
    </div>
</div>