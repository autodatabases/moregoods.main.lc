<b>{$oLanguage->getMessage("Cart - Number / All in cart")}</b><br>
<font color="Green">
{foreach key=key item=aValue from=$aCartScan}
	<font color="
		{if $aValue.cart_number==0}red
		{elseif $aValue.numbersum > $aValue.cart_number}brown
		{elseif $aValue.numbersum < $aValue.cart_number}green
		{elseif $aValue.numbersum == $aValue.cart_number}black{/if}
		">
			<b>{$aValue.id_cart} - {$aValue.numbersum}</b> / {$aValue.cart_number}<br>
	</font>
{/foreach}
</font>