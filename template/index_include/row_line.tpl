{*<hr>*}
                <div class="gm-product-line-element">
                    <div class="cell-image">
                        <a href="/?action=catalog_product&product={$aRow.id_product}" class="block-image">
                            <span class="wrap">
                                {*<span class="label red">Акция</span>*}
                                <span class="image"><img src="{$oContent->GetImageThumb($aRow.image)}" alt=""></span>
                            </span>
                        </a>
                    </div>
                    {*$aRow.promo|@debug_print_var*}
                    <div class="cell-name">
                        <a  href="/?action=catalog_product&product={$aRow.id_product}">{$aRow.name}[{$aRow.short_name}]</a>
						<div class="label nocolor" style="padding-left:0;">
							 {foreach from=$aRow.promo item=aItemP}
							<span  id="promo_{$aRow.id_product}_{$aItemP.i}" style="
							font-size: 14px;  
							font-weight: bold;
							color: #ffffff;  
							top: -10px;  left: -10px;
							float: left;
							line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: {$aItemP.color};
									">{$aItemP.name}</span>
							 {/foreach}
						</div>
                        <span>({$oLanguage->getMessage("code_product")}: {$aRow.id}) &nbsp; ({$oLanguage->getMessage("barcode")}: {$aRow.barcode})
                        &nbsp; ({$oLanguage->getMessage("articul")}: {$aRow.art}){*<em class="red">Акция</em>*}</span>
                    </div>
                    <div class="cell-favorite">
                        <a href="javascript:void(0)" class="link-favorite {if $aRow.is_fav}active{/if}" id="fav_{$aRow.id_product}" ></a>
                    </div>
                    <div class="cell-price" style="font-size:17px">
				    {if $aRow.promo.0.skidka!=0}
						<a id="price_old_{$aRow.id_product}" style="text-decoration: line-through;font-size: 14px;">{$oCurrency->PrintPrice($aRow.price)}</a>
						{else}
						<a> </a>
					{/if}
				   <span{if $aRow.promo.0.skidka!=0} style ="color:#ba0000;font-size: 17px;" {/if}>{if $aRow.promo.0.skidka==0}{$oCurrency->PrintPrice($aRow.price)} {else} {if $aRow.promo.0.id_type_skidka==3} {$oCurrency->PrintPrice($aRow.base_price*$aRow.promo.0.skidka)}  {else}{$oCurrency->PrintPrice($aRow.price*$aRow.promo.0.skidka)}  {/if}{/if}</span>
{*                        {$oCurrency->PrintPrice($aRow.price)}  *}
                    </div>
                    <div class="cell-price" style="font-size:14px;text-align: right;">
                        {$aRow.stock}&nbsp;{$oLanguage->getMessage("sht.")}
                    </div>
                    <div class="cell-counter line">
                        <div class="gm-block-counter js-block-count">
                            <span class="plus"></span>
                            <span class="minus"></span>
                            <input class="count" type="text" value="{if $aRow.in_cart}{$aRow.in_cart}{else}{/if}">
                        </div>
                    </div>
                    <div class="cell-button">
			            <a href="javascript:void(0)" class="gm-icon-buy {if $aRow.in_cart}already{/if}{if $aRow.stock<$aRow.min_stock}missing{/if}" id="buy_{$aRow.id_product}"></a>
                    </div>
                </div>