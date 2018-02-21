<form class="form" id="add_form">
<table>
	<tr>
		<td><b>{$oLanguage->GetMessage('Select existing product')}:</b></td>
		<td><select name="data[id_product]" style="width:270px;">{html_options options=$aProducts}</select></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage('Store')}:</b></td>
		<td><select name="data[id_store]" style="width:270px;">{html_options options=$aStoresFrom}</select></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage('count')}:</b></td>
		<td><input type="text" name="data[count]" value="1" style="width:270px;"></td>
	</tr>
</table>

<input type="hidden" name="action" value="store_sale_invoice_add">
<input type="hidden" name="is_post" value="1">
<input type="submit" value="add" onclick="this.form.submit()">
</form>