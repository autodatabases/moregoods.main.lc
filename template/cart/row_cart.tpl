            <hr>
            <div class="gm-product-line-element">
                <div class="cell-image">
                    <a href="#" class="block-image">
                        <span class="wrap">
                            {*<span class="label red">Акция</span>*}
                            <span class="image"><img src="{$aRow.image}" alt=""></span>
                        </span>
                    </a>
                </div>
                <div class="cell-name">
                    <a target="_blank" href="/?action=catalog_product&product={$aRow.id_product}">{$aRow.name_translate}</a>
                    <span>(Код: {$aRow.id_product})<br> Время добавления: {$aRow.post_date} {*<em class="red">Акция</em></span>*}
                </div>
                <div class="cell-price simple">
				    {if $aRow.price_parent_margin!=0}
						<a id="price_old_{$aRow.id_product}" style="text-decoration: line-through;font-size: 14px;">{$oCurrency->PrintPrice($aRow.price_original)}</a>
						{else}
						<a> </a>
					{/if}
				  <span id="price_{$aRow.id_product}"  
				   {if $aRow.price_parent_margin!=0} style ="color:#ba0000;font-size: 18px;" {/if}>{$oCurrency->PrintPrice($aRow.price)} </span>

{*				<nobr>{$oCurrency->PrintPrice($aRow.price)}</nobr> *}
				</div>
                <div class="cell-counter">
                    <div class="gm-block-counter js-block-count">
                        <span class="plus"></span>
                        <span class="minus"></span>
                        <input class="count" type="text" id='cart_{$aRow.id}' name='cart[{$aRow.id}]' value='{$aRow.number}'
		maxlength=3 onKeyUp="xajax_process_browse_url('?action=cart_cart_update_number&id={$aRow.id}&number='+this.value);">
                    </div>
                </div>
                <div class="cell-price" id='cart_total_{$aRow.id}'>
				<nobr>{$oCurrency->PrintSymbol($aRow.total)}</nobr>
                </div>
                <div class="cell-remove">
                    <a href="/?action=cart_cart_delete&id={$aRow.id}" onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) return false;" class="gm-icon-remove"></a>
                </div>
            </div>

