 <hr>
    <div class="gm-product-line-element" >
 		<div class="cell-image" style="     width: 105px;
    height: 78px;  text-align: -webkit-center;" >
			
				<img src="{$aRow.image}" alt="{$aRow.name}" style="max-height: 100px; max-width: 110px;
    ">
			
		</div>
<div class="cell-name" style="width: 0;">
	<a target="_blank" href="/?action=catalog_product&product={$aRow.id_product}">{$aRow.name_translate}</a>
</div>

<div class="cell-price simple">
		    {if $aRow.price_parent_margin!=0}
				<a id="price_old_{$aRow.id_product}" style="text-decoration: line-through;font-size: 14px;"><nobr>{$oCurrency->PrintPrice($aRow.price_original)}</nobr></a>
				{else}
				<a> </a>
			{/if}
		  <span id="price_{$aRow.id_product}"  
		   {if $aRow.price_parent_margin!=0} style ="color:#ba0000;font-size: 18px;" {/if}><nobr>{$oCurrency->PrintPrice($aRow.price)}</nobr> </span>
</div>

<div class="cell-price" style="padding: 0;">
    
        <input  type="text" id='cart_{$aRow.id}' name='cart[{$aRow.id}]' value='{$aRow.number}'style="height: 30px; width: 70px;"
maxlength=7 onKeyUp="xajax_process_browse_url('?action=cart_cart_update_number&id={$aRow.id}&number='+this.value);">
    
 </div>

<div class="cell-price" id='cart_total_{$aRow.id}' style="padding: 0;">
				<nobr>{$oCurrency->PrintSymbol($aRow.total)}</nobr>
</div>
<div class="cell-remove cell-price" style="text-align:center; width: 50px; padding: 0;">
                    <a class="gm-icon-remove" href="#"
	onclick="if (!confirm('{$oLanguage->getMessage("Are you sure you want to delete this item?")}')) {ldelim} return false; {rdelim} else {ldelim} xajax_process_browse_url('?action=cart_cart_delete&id={$aRow.id}'); return false;{rdelim}"
	></a>                
</div>
</div>
