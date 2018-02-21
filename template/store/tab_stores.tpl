<ul class="secodary_tabs">
{foreach from=$aStores item=sItem key=iKey}
	<li class="{if $smarty.request.store==$iKey}sel{/if}"
		><a href='/?action={$sActionPrefix}&store={$iKey}'
		>{$sItem}</a></li>
{/foreach}
</ul>