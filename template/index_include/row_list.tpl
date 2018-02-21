                {*<hr>*}
                <div class="gm-product-list-element">
                    <div class="block-left">
                        <div class="image"><a  href="/?action=catalog_product&product={$aRow.child.0.id}" id="image_{$aRow.id_product}"><img class="image_cont" src="{$oContent->GetImageThumb($aRow.child.0.image)}" alt=""></a></div>
                        <a href="javascript:void(0)" class="link-favorite favorite {if $aRow.is_fav}active{/if}" id="fav_{$aRow.child.0.id}"></a>
                    </div>

                    <div class="block-right">
               <div class="label nocolor" style="padding-left:0;">
							 {foreach from=$aRow.promo item=aItemP}
								{if $aItemP.i==33}<br>{/if}
								<span href="/?action=promo&promo_id={$aItemP.ch_id}" onmousedown="OnPromoClick('promo_{$aItemP.ch_id}'); return false;" id="promo_{$aRow.id_product}_{$aItemP.i}" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: {$aItemP.color};">{$aItemP.name}</span>
							 {/foreach}
			   </div>
                        <div class="price">
						{if $aRow.promo.0.skidka!=0}
							<a id="price_old_{$aRow.id_product}" style="text-decoration: line-through;font-size: 20px;">{$oCurrency->PrintPrice($aRow.price)}</a><br>
						{else}
							<a> </a>
						{/if}
						<span id="price_{$aRow.id_product}"
							{if $aRow.promo.0.skidka!=0} style ="color:#ba0000;" {/if}>{if $aRow.promo.0.skidka==0}{$oCurrency->PrintPrice($aRow.price)} {else} {if $aRow.promo.0.id_type_skidka==3} {$oCurrency->PrintPrice($aRow.base_price*$aRow.promo.0.skidka)} {else}{$oCurrency->PrintPrice($aRow.price*$aRow.promo.0.skidka)}  {/if}{/if}</span>
                            <span style="font-size:12px;" id="store_{$aRow.id_product}">({$aRow.stock|string_format:"%d"} {$oLanguage->getMessage("sht.")})</span>
                        </div>
                        <div class="button" id="pricemain_{$aRow.id_product}">
					         <a href="javascript:void(0)" class="gm-button gm-button-buy {if $aRow.child.0.in_cart}already{/if}{if $aRow.child.0.stock<$aRow.child.0.min_stock}missing{/if}" id="buy_{$aRow.child.0.id}">{if $aRow.child.0.in_cart}{$oLanguage->GetMessage('in_cart')}{elseif $aRow.child.0.stock<$aRow.child.0.min_stock}{$oLanguage->GetMessage('expected')}{else}{$oLanguage->GetMessage('buy')} {/if}</a>
					    </div>
                       {if $aRow.select_type==0}
						<div class="options" id="{$aRow.id_product}">
						 {foreach from=$aRow.child item=aItem}     
                            <a class="{if $aItem.check_==1} selected {/if} notselected" id="price2_{$aRow.id_product}_{$aItem.id}" discount="{$aItem.kf_discount}"
                            	name="{$aItem.price}_{$aItem.stock}_{$aItem.id}_{$aItem.art}_{$aItem.barcode}_{$aItem.image}_{$aItem.min_stock}_{if $aItem.promo.0.skidka==0}{$aItem.price}{else}{if $aItem.promo.0.id_type_skidka==3}{$aItem.base_price*$aItem.promo.0.skidka}{else}{$aItem.price*$aItem.promo.0.skidka}{/if}{/if}_{$aItem.in_cart}_{$aItem.promo.0.name}_{$aItem.promo.0.color}_{$aItem.promo.1.name}_{$aItem.promo.1.color}_{$aItem.promo.2.name}_{$aItem.promo.2.color}_{$aItem.promo.3.name}_{$aItem.promo.3.color}" 
						        onmouseenter="OnPrice2('price_{$aRow.id_product}',
    						    'price2_{$aRow.id_product}_{$aItem.id}','store_{$aRow.id_product}','code_{$aRow.id_product}','art_{$aRow.id_product}',
    						    'barcode_{$aRow.id_product}', 'image_{$aRow.id_product}','pricemain_{$aRow.id_product}', '{$aRow.id_product}'); return false;"
    						    >{$aItem.short_name}</a>
                         {/foreach}
                        </div>
					   {else}	
                        <div class="options no-margin">
						    <select class="js-uniform" id="price2_{$aRow.id_product}" onchange="OnPrice('price_{$aRow.id_product}',
						    'price2_{$aRow.id_product}','store_{$aRow.id_product}','code_{$aRow.id_product}','art_{$aRow.id_product}',
						    'barcode_{$aRow.id_product}', 'image_{$aRow.id_product}','pricemain_{$aRow.id_product}'); return false;">
						     {foreach from=$aRow.child item=aItem}        
						        <option id="price_{$aRow.id_product}_{$aItem.id}"  value="{$aItem.price}_{$aItem.stock}
						        _{$aItem.id}_{$aItem.art}_{$aItem.barcode}_{$aItem.image}_{$aItem.min_stock}_{$aItem.in_cart}">{$aItem.short_name}</option>
						     {/foreach}
						    </select>
						</div>
                        {/if}
                        

                    </div>

                    <div class="block-info">
                        <div class="name">
                            <a  href="/?action=catalog_product&product={$aRow.child.0.id}">{$aRow.name}</a>
                        </div>
						{$aRow.short_name}<br><br>
                        <span class="code" id="code_{$aRow.id_product}">({$oLanguage->getMessage("Code_product")}: {$aRow.child.0.id})</span>&nbsp;
                        <span class="code" id="art_{$aRow.id_product}">({$oLanguage->getMessage("articul")}: {$aRow.child.0.art})</span><br>
                        <span class="code" id="barcode_{$aRow.id_product}">({$oLanguage->getMessage("barcode")}: {$aRow.child.0.barcode})</span>
						<br>
						<div class="price-before" {if $aRow.from_matrica==1}style="color:blue"{else}style="color:green"{/if}>
						{if $aAuthUser.type_=='manager'}
						{if $aRow.discount !=0}<br>
						{$aRow.discount*-1.00}%&nbsp;{if $aRow.promo.0.id_type_skidka==3}A{else}D{/if}&nbsp;{$oCurrency->PrintPrice($aRow.base_price)}
						{/if}
						{/if}
						</div>
						

					</div>
                    <div class="clear"></div>
                </div>
            