<table style="width:100%;" border=0 class="gm-block-order-filter no-mobile">
 			
                <tr>
                   
<td><input type="text" name="search[id_cart_package]" value="{$smarty.request.search.id_cart_package}" placeholder="{$oLanguage->GetMessage('order number')}"></td>
    <td>
            <span class="status-wrap">
           <select name="search[order_status]" class="js-uniform">
            <option value="">{$oLanguage->GetMessage('status')}</option>
            <option value="new" {if $smarty.request.search.order_status=='new'}selected="selected"{/if} label="{$oLanguage->GetMessage('new')}">{$oLanguage->GetMessage('new')}</option>
            <option value="pending" {if $smarty.request.search.order_status=='pending'}selected="selected"{/if} label="{$oLanguage->GetMessage('pending')}">{$oLanguage->GetMessage('pending')}</option>
            <option value="work" {if $smarty.request.search.order_status=='work'}selected="selected"{/if} label="{$oLanguage->GetMessage('work')}">{$oLanguage->GetMessage('work')}</option>
            <option value="end" {if $smarty.request.search.order_status=='end'}selected="selected"{/if} label="{$oLanguage->GetMessage('end')}">{$oLanguage->GetMessage('end')}</option>
            <option value="refused" {if $smarty.request.search.order_status=='refused'}selected="selected"{/if} label="{$oLanguage->GetMessage('refused')}">{$oLanguage->GetMessage('refused')}</option>
        </select>
    </span></td>

  
                

            </tr>
                
</table>
