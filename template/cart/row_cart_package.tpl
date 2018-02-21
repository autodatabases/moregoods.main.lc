<td>{$aRow.id}</td>
<td>{$oLanguage->getOrderStatus($aRow.order_status)}
	{if $aRow.order_status=='pending'}{$oLanguage->getContextHint("pending_order_status",true)}{/if}
</td>
<!--<td>
{if $aRow.id_user_contact=='samovivoz'}
	<b>{$oLanguage->getMessage("���������")}</b>
{else}
	<b>{$aRow.user_contact_name}</b>
{/if}
 / {$oLanguage->getMessage($aRow.delivery_type)}
</td>-->
<td> 
{$oCurrency->PrintPrice($aRow.price_total,1)}
<br>
{$aRow.delivery_type_name} / {$aRow.payment_type_name}<br>
{$oLanguage->getMessage("Delivery point")}:
{assign var=iSelectedAdr value=$aRow.id_addres}
{$aAdress.$iSelectedAdr.addresses}

{if $aRow.id_payment_type == 1}
<nobr><br><a href="/?action=cart_payment_end_button&data[id_payment_type]={$aRow.id_payment_type}&id_cart_package={$aRow.id}"
	><img src="/image/payment/money.png" border=0 width=16 align=absmiddle hspace=1
	/>{$oLanguage->getMessage("Pay for cart package")}</a></nobr>
{/if}
</td>
<td>{$aRow.customer_comment}&nbsp;</td>
<td>{$oLanguage->GetPostDate($aRow.post_date)}</td>
<td nowrap>
<nobr><a href="/?action=cart_package_print&id={$aRow.id}" target=_blank
	><img src="/image/fileprint.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Print")}</a></nobr>
<br>
<nobr><a href="/?action=cart_order&search[id_cart_package]={$aRow.id}"
	><img src="/image/tooloptions.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Browse Order Items")}</a></nobr>
</nobr>

<br>

<nobr><a href="/?action=cart_package_edit&id={$aRow.id}"
	><img src="/image/edit.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("EEdit")}</a>
</nobr>


{if $aRow.order_status=='pending' && !$aRow.is_confirm}
<br>
<a href="/?action=cart_package_delete&id={$aRow.id}"
	><img src="/image/delete.png" border=0 width=16 align=absmiddle hspace=1/>{$oLanguage->getMessage("Delete and return cart")}</a>
<br>
{/if}

</td>