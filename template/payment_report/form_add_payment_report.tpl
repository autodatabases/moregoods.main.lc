<input type='hidden' name='is_post' value='1'>
<table class="gm-block-order-filter2 no-mobile">
	<tr>
		<td><b>{$oLanguage->GetMessage("Date and time")}:</b>
		<br>{$oLanguage->GetText("If empty - get current date and time. Use format: d-m-Y H:i:s")}</td>
		<td>
			<input type=text name=data[payment_date] value='{if $smarty.request.data.payment_date}{$smarty.request.data.payment_date}{else}{$aData.payment_date}{/if}' maxlength=50 style='width:270px'>
		</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Method")}:</b></td>
		<td>
		<div class="options">
			<select class="js-uniform" id="menu_select" name="data[method]" id='method' style="width: 271px;">
				{html_options values=$aMethods output=$aMethods selected=$aData.method}
			</select>
		</div>
		</td>
	</tr>
	<tr>
		<td>{$sZir}&nbsp;<b>{$oLanguage->GetMessage("Price payment report")}:</b></td>
		<td><input type=text name=data[price] value='{$aData.price}' maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Comment")}:</b></td>
		<td><textarea name=data[comment] style='width:270px'>{$aData.comment}</textarea></td>
	</tr>
</table>