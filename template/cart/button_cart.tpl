{ include file=cart/popup_dolg.tpl }
<table border=0 width=99%>
<tr><td width=70%>
{if $aItem}
{if $aAuthUser.type_!='manager'}
	{if $aBonus < 0}
<a href="javascript:void(0);" onclick="popupOpen('.js-popup-auth2');">{/if}<input type=button class='btn order-package-btn' value="{$oLanguage->getMessage("Продолжить заказ")}"
	{if $aBonus < 0} onclick="" {else} onclick="javascript: location.href='/?action=cart_onepage_order'"{/if} />
	{if $aBonus < 0}</a>{/if}
{else}
<input type=button class='btn order-package-btn' value="{$oLanguage->getMessage("Продолжить заказ")}"
	 onclick="javascript: location.href='/?action=cart_onepage_order_manager'"/>
	{/if}
	
{*<input type=button class='btn order-package-btn' value="{$oLanguage->getMessage("Clear cart")}"
	onclick="javascript: location.href='/pages/cart_cart_clear'" />*}
	
{if $bAllowEditOrder}
<input type=button class='btn order-package-btn' value="{$oLanguage->getMessage("add to existing order")}"
	onclick="javascript: location.href='/pages/cart_add_to_order/?id_order='+document.getElementById('existing_order').options[document.getElementById('existing_order').selectedIndex].value;" />
	
<select name="existing_order" class="js-uniform" id="existing_order">
	{html_options options=$aOrderAvailable}
</select>
{/if}

{*
<span style="float: right;">
<a href='/?action=additional_delivery' target='_blank'>{$oLanguage->GetMessage('Delivery and Garanties')}</a>&nbsp;&nbsp;&nbsp;

<a href='/?action=cart_cart_print' target='_blank'><img src='/image/fileprint.png'  border='0' hspace='2' align='absmiddle'
	/> {$oLanguage->GetMessage('Print')}</a>
</span>
*}
{/if}


</td>
</tr>
</table>
{* include file="cart/order_by_phone.tpl" *}

<br>
<br>
