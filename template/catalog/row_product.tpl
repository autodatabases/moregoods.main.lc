<td class="cell-photo {$aRow.td_class}">
{if $aRow.image}
<div class="bg-product-photo">
	<div class="bg-photo-popup">
		<span>
			<img src="{$aRow.image}" style="max-width: 150px; max-height: 150px"
			alt=""
			title="">
		</span>
	</div>
</div>
{/if}
</td>
<td>{$aRow.brand}</td>
<td>{$aRow.art}</td>
<td><a href="/?action=catalog_product&product={$aRow.id}">{$aRow.name}</a></td>
<td>{$aRow.weight}</td>
<td>{$aRow.volume}</td>
<td>{$aRow.pack_qty}</td>
<td>{$aRow.stock}</td>
<td>{$oCurrency->PrintPrice($aRow.price)}</td>
<td>{include file="catalog/link_add_cart.tpl"}</td>