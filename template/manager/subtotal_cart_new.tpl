    {if !$aRow.is_payed && !$sAlreadySent}
    <a href="/?action=manager_send_bill_liqpay&id={$aRow.id_cart_package}&id_user={$aRow.id_user}" 

    class="link-edit"><span class="gm-link-dashed">{$oLanguage->getMessage("For paying to customer")}</span></a> &nbsp;&nbsp;
    {else}
    <a href="/?action=manager_send_bill_liqpay&id={$aRow.id_cart_package}&id_user={$aRow.id_user}" 

    class="link-edit"><span class="gm-link-dashed">{$oLanguage->getMessage("letter already sent")}</span></a> &nbsp;&nbsp;
    {/if}
     <a href="/?action=manager_copy_fact&id={$aRow.id_cart_package}" class="link-edit"><span class="gm-link-dashed">{$oLanguage->getMessage("Copy all to fact")}</span></a>


        {*if !$aRow.is_payed && $aRow.id_payment_type==4}
        &nbsp;&nbsp;
        <a {strip}href="/?action=manager_package_payed&id={$aRow.id_cart_package}&return={$sReturn|escape:"url"}"
        {/strip}><img src="/image/inbox.png" border=0 width=16 align=absmiddle />{$oLanguage->getMessage("Set cart package payed by LiqPay")}</a>
        {/if*}

        <div class="gm-basket-control-line">
            <a href="/?action=manager_order_print&id={$aRow.id_cart_package}&id_user={$aRow.id_user}" class="link-edit"><span class="gm-link-dashed">{$oLanguage->getMessage("print_cart")}</span></a>
            <div class="block-total" >
                <span>{$oLanguage->getMessage("Total_sum")}:</span>
            {if $aData.summa_fact != 0}
			 <div class="block-total" id='cart_subtotal_fact'>{$aData.summa_fact-$aData.bonus}{$oCurrency->PrintSymbol($dSubtotal)}</div>
            {else}
             <div class="block-total" id='cart_subtotal'>{$aData.price_total-$aData.bonus}{$oCurrency->PrintSymbol($dSubtotal)}</div>
        	{/if}
            </div>
            <div class="clear"></div>
        </div>
