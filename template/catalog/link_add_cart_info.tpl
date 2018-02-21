<input type=text name ="n[{$aRow.id}]" id='number_{$aRow.id}' style="width:90px;" value="{if $aRow.request_number}{$aRow.request_number}{else}1{/if}">



		
<span id='add_link_{$aRow.id}'>
{if $aPartInfo.stock>=$aRow.min_stock}
<a href="javascript:;"
onclick="{strip}
xajax_process_browse_url('/?action=cart_add_cart_item&xajax_request=1
&id_product={$aRow.id}
&link_id=add_link_{$aRow.id}
&number='+document.getElementById('number_{$aRow.id}').value);
return false;{/strip}">
{/if}
<button type="submit" class="btn btn-sm btn-primary {if $aPartInfo.stock<$aRow.min_stock }missing{/if}">
{if $aPartInfo.stock<$aRow.min_stock }{$oLanguage->getMessage("isnot_store")}
{elseif $iInCartAlready==0}{$oLanguage->getMessage("buy")}
{else}{$oLanguage->getMessage("in_cart")}
{/if}
</button>
</a>
</span>


