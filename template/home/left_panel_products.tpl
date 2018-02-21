<div class="at-news-block">
	<h3 class="at-caption">{$aGroupP.name}</h3>
{foreach item=aRow from=$aProductList}
	<div class="item">
		<a href="/?action=catalog_product&product={$aRow.id}" class="name">{$aRow.brand} {$aRow.art} {$aRow.name}</a>
		<span>{$aRow.price}</span><br>
		<span>{$aRow.dt1}</span><br>
		<span>{$aRow.dt2}</span>
	</div>
{/foreach}
</div>