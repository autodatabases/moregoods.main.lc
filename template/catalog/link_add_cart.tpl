<input type=text name='n[{$aRow.id}]' id='number_{$aRow.id}' value="1" size='3'>
		
<span id='add_link_{$aRow.id}'>
<a href="javascript:;"
onclick="{strip}
xajax_process_browse_url('/?action=cart_add_cart_item&xajax_request=1
&id_product={$aRow.id}
&link_id=add_link_{$aRow.id}
&number='+document.getElementById('number_{$aRow.id}').value);

oCart.AnimateAdd(this);
return false;{/strip}"><img src="/image/basket.png" alt="{$oLanguage->getMessage('buy')}"/></a>
</span>