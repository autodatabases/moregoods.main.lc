        <div class="gm-basket-control-line">
            <a href="/pages/cart_cart_clear" class="link-clear"><span class="gm-link-dashed">{$oLanguage->getMessage("Clear_cart")}</span></a>
            <a href="/?action=cart_cart_print" class="link-edit"><span class="gm-link-dashed">{$oLanguage->getMessage("print_cart")}</span></a>
            <div class="block-total" >
                <span>{$oLanguage->getMessage("Total_sum")}:</span>
               <div class="block-total" id='cart_subtotal'>{$oCurrency->PrintSymbol($dSubtotal)}</div>
            </div>
            <div class="clear"></div>
        </div>