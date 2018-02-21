{if $aData.order_status=='pending' || $aData.order_status=='work'}
<div class="form" style="width: 99%;">
	<b style="padding: 10px">{$oLanguage->GetMessage('add product to order')}</b>
	<form action="/" style="padding: 10px">
		<label>{$oLanguage->GetMessage('zzz_code')}:</label>
		<input type="text" name="zzz_code" value="">
		<label>{$oLanguage->GetMessage('number')}:</label>
		<input type="text" name="number" value="1" maxlength="3" style="width: 30px">
		<input type="submit" value="{$oLanguage->GetMessage('add')}">
		<input type="hidden" name="action" value="manager_package_add_order_item">
		<input type="hidden" name="id_cart_package" value="{$aData.id}">
		<input type="hidden" name="return" value="{$sReturn|escape:"url"}">
	</form>
</div>
{/if}