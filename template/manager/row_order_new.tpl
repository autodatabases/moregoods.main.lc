           {* <hr> *}
           
                <td class="cell-image">
                    <a href="#" class="block-image">
                        <span class="wrap">
                            {*<span class="label red">Акция</span>*}
                            <span class="image"><img src="{$aRow.image}" alt=""></span>
                        </span>
                    </a>
                </td>
                <td class="cell-name">
                    <a target="_blank" href="/?action=catalog_product&product={$aRow.id_product}">{$aRow.name_translate}</a>
                    <span>(ID: {$aRow.id_product})&nbsp;(Артикул : {$aRow.code}) (Штрихкод: {$aRow.barcode})   &nbsp;&nbsp; {$aRow.cat_name}</span>
					</td>
                <td class="cell-price simple">
				    {if $aRow.price_parent_margin!=0}
						<a id="price_old_{$aRow.id_product}" style="text-decoration: line-through;font-size: 14px;">{$oCurrency->PrintPrice($aRow.price_original)}</a>
						{else}
						<a> </a>
					{/if}
				  <span id="price_{$aRow.id_product}"  
				   {if $aRow.price_parent_margin!=0} style ="color:#ba0000;font-size: 18px;" {/if}><nobr>{$oCurrency->PrintPrice($aRow.price)} </nobr></span>
					{*	<nobr>{$oCurrency->PrintPrice($aRow.price)}</nobr> *}
				</td>
                <td class="cell-counter" style="width:40px;height: 40px;border-bottom:1px dashed #b5b5b5;font-size: 18px;">
                        <nobr>{$aRow.number}&nbsp;{$oLanguage->getMessage("sht.")}</nobr>
                </td>
                <td class="cell-price" id='cart_total_{$aRow.id}'>
                <nobr>{$oCurrency->PrintSymbol($aRow.total)}</nobr>
                </td>
                <td class="cell-price_fact" style="width:40px;height: 40px;border-bottom:1px dashed #b5b5b5;font-size: 18px;">
                      
                    <input type="text"  id='cart_{$aRow.id}' name='cart[{$aRow.id}]' value='{$aRow.price_fact}' style="width:70px"
        onKeyUp="xajax_process_browse_url('/?action=manager_update_number_fact&id={$aRow.id}&price_fact='+this.value);">
                           
                </td>
                <td class="cell-counter" style="width:40px;height: 40px;border-bottom:1px dashed #b5b5b5;font-size: 18px;">
                      <input type="text"  id='cart_num_{$aRow.id}' name='cart[{$aRow.id}]' value='{$aRow.count_fact}' style="width:70px"
        onKeyUp="xajax_process_browse_url('/?action=manager_update_number_fact&id={$aRow.id}&count_fact='+this.value);">
                </td>
                <td class="cell-price" id='cart_total_fact_{$aRow.id}'>
                <nobr>{$oCurrency->PrintSymbol($aRow.summa_fact)}</nobr>
                </td>
                
				{*<td class="cell-counter">
                    <td class="gm-block-counter js-block-count">
                        <span class="plus"></span>
                        <span class="minus"></span>
                        <input class="count" type="text" id='cart_{$aRow.id}' name='cart[{$aRow.id}]' value='{$aRow.number}'
		maxlength=3 onKeyUp="xajax_process_browse_url('?action=cart_cart_update_number&id={$aRow.id}&number='+this.value);">
                    </td>
                </td> *} 
			
        
			

