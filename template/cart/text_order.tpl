		<h2>{$oLanguage->getMessage("My order")}</h2>
		<table width="100%" cellspacing=0 cellpadding=5 class="datatable">
		<tr>
			<th><nobr>{$oLanguage->getMessage("CatName")}</th>
			<th><nobr>{$oLanguage->getMessage("CartCode")}</th>
			<th><nobr>{$oLanguage->getMessage("Name")}</th>
			<th><nobr>{$oLanguage->getMessage("Number")}</th>
			<th><nobr>{$oLanguage->getMessage("Price")}</th>
			<th><nobr>{$oLanguage->getMessage("Total")}</th>

		</tr>
		{foreach item=aItem from=$aUserCart}
		<tr class="{cycle values="even,none"}">
			<td>{$aItem.cat_name}</td>
			<td>{if $aItem.code_visible}
				{$aItem.code}
			{else}
				<i>{$oLanguage->getMessage("cart_invisible")}</i>
			{/if}</td>
			<td><div style="overflow:overlay;">
			    {$aItem.name_translate}
			    </div>
			</td>
			<td>{$aItem.number}</td>
			<td>{$oCurrency->PrintPrice($aItem.price)}</td>
			<td>{$oCurrency->PrintSymbol($aItem.number_price)}</td>
		</tr>
		{/foreach}
		<tr>
			<td colspan=6><hr></td>
		</tr>

		<tr>
			<td colspan=5 align=right>{$oLanguage->getMessage('Subtotal')}:</td>
			<td>{$oCurrency->PrintSymbol($dSubtotal)}</td>
		</tr>
		<tr>
			<td colspan=5 align=right>{$oLanguage->getMessage('Shipment Included')}:</td>
			<td><span id='price_delivery'>{$oCurrency->PrintPrice($smarty.session.current_cart.price_delivery)}</span></td>
		</tr>
		 <tr>
			<td colspan=5 align=right><b>{$oLanguage->getMessage('Total')}</b>:</td>
			<td><b><span id='price_total'>{$oCurrency->PrintSymbol($dTotal)}</span></b></td>
		 </tr>
		</table>
