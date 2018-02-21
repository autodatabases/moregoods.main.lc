<div class="ak-taber-block">
	<a {if $smarty.request.search.num_rating==0}class="selected"{/if} href='/?action=manager_invoice_customer&search[num_rating]=0'>{$oLanguage->GetMessage('All')}</a>
	{foreach from=$aRatingAssoc item=aItem key=sKey}
	<a {if $smarty.request.search.num_rating==$sKey}class="selected"{/if} href='/?action=manager_invoice_customer&search[num_rating]={$sKey}'>{$aItem}</a>
	{/foreach}
	<div class="clear"></div>
</div>