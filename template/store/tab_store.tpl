<ul class="secodary_tabs">
	<li class="{if $smarty.request.action=='store'}sel{/if}"
		><a href='/pages/store/'
		>{$oLanguage->GetMessage('Store')}</a></li>

	<li class="{if $smarty.request.action=='store_transfer'}sel{/if}"
		><a href='/pages/store_transfer/'
		>{$oLanguage->GetMessage('Store transfer')}</a></li>
		
	<li class="{if $smarty.request.action=='store_input_invoice_manual'}sel{/if}"
		><a href='/pages/store_input_invoice_manual/'
		>{$oLanguage->GetMessage('Store input invoice')}</a></li>
		
	<li class="{if $smarty.request.action=='store_products'}sel{/if}"
		><a href='/pages/store_products/'
		>{$oLanguage->GetMessage('Store products')}</a></li>
		
	<li class="{if $smarty.request.action=='store_return'}sel{/if}"
		><a href='/pages/store_return/'
		>{$oLanguage->GetMessage('Store return')}</a></li>
		
	<li class="{if $smarty.request.action=='store_sale'}sel{/if}"
		><a href='/pages/store_sale/'
		>{$oLanguage->GetMessage('Store sale')}</a></li>
		
	<li class="{if $smarty.request.action=='store_sale_invoice'}sel{/if}"
		><a href='/pages/store_sale_invoice/'
		>{$oLanguage->GetMessage('Store sale invoice')}</a></li>
		
		
	<li class="{if $smarty.request.action=='store_log'}sel{/if}"
		><a href='/pages/store_log/'
		>{$oLanguage->GetMessage('Store log')}</a></li>
		
	<li class="{if $smarty.request.action=='store_balance'}sel{/if}"
		><a href='/pages/store_balance/'
		>{$oLanguage->GetMessage('Store balance')}</a></li>
</ul>