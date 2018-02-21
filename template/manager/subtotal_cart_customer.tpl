        <div class="gm-basket-control-line">
            <a href="/?action=manager_customer_cart_print&where={$sWhere}&id_region={$aRow.id_region}&return={$sReturn|escape:"url"}" class="link-edit"><span class="gm-link-dashed">{$oLanguage->getMessage("print_cart")}</span></a>
            <div class="block-total" >
                <span>{$oLanguage->getMessage("Total_sum")}: &nbsp;&nbsp;&nbsp;{$dSubtotalCount}&nbsp;{$oLanguage->getMessage("sht.")}</span>
               <div class="block-total" id='cart_subtotal'>{$oCurrency->PrintSymbol($dSubtotalGrn)}</div>
            </div>
            <div class="clear"></div>
        </div>
		