<table width=100% border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td>{$oLanguage->getMessage("CartCode")}:</td>
		<td><input type=text name=search[code] value='{$smarty.request.search.code}' maxlength=20 style="width:214px;"></td>
		<td>{$oLanguage->getMessage("Status")}:</td>
		<td>
		<div class="options">{html_options class="js-uniform" id="menu_select"  name=search[order_status] options=$aOrderStatus selected=$smarty.request.search.order_status
				}
				</div>
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->getMessage("Name")}:</td>
		<td><input type=text name=search[name] value='{$smarty.request.search.name}' maxlength=20 style="width:214px;"></td>
		<td>{$oLanguage->getMessage("По дате")}</td>
		<td><input class="date" name=search[datestart] id=datestart type="text" value="{$smarty.request.search.datestart}">&nbsp; -
			<input class="date" name=search[dateend] id=dateend type="text" value="{$smarty.request.search.dateend}"></td>
		<input class="js-date" type="text" name="search[date]" value="" style="display: none;">
		{*<td>{$oLanguage->getMessage("Customer_ID")}:</td>
		<td><input type=text name=search[customer_id] style="width:278px;" value='{$smarty.request.search.customer_id}' maxlength=30
			></td>*}
	</tr>
	<tr>
		<td>{$oLanguage->getMessage("#")}:</td>
		<td><input type=text name=search[id] value='{$smarty.request.search.id}' maxlength=20 style="width:214px;"></td>

		<td>{$oLanguage->getMessage("Order #")}:</td>
		<td><input type=text name=search[id_cart_package] style="width:278px;" value='{$smarty.request.search.id_cart_package}' maxlength=20
			></td>

	</tr>
	<tr>

	</tr>

</table>