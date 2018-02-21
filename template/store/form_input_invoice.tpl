
<h3>{$oLanguage->GetMessage('add manual')}</h3>

<form class="form" id="add_form">
<table>
	<tr>
		<td><b>{$oLanguage->GetMessage('Select existing product')}:</b></td>
		<td><select name="data[id_product]" style="width:270px;">{html_options options=$aProducts}</select></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;"><b>{$oLanguage->GetMessage('or')}</b></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage('brand')}:</b></td>
		<td><select name="data[pref]" style="width:270px;">{html_options options=$aBrand}</select></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage('code')}:</b></td>
		<td><input type="text" name="data[code]" value="" style="width:270px;"></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage('name')}:</b></td>
		<td><input type="text" name="data[name]" value="" style="width:270px;"></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;"><b>{$oLanguage->GetMessage('params')}</b></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage('tax')}:</b></td>
		<td><input type="text" name="data[tax]" value="0" style="width:270px;"></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage('price')}:</b></td>
		<td><input type="text" name="data[price]" value="0" style="width:270px;"></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->GetMessage('count')}:</b></td>
		<td><input type="text" name="data[count]" value="1" style="width:270px;"></td>
	</tr>
</table>

<input type="hidden" name="action" value="store_input_invoice_manual_add">
<input type="hidden" name="is_post" value="1">
<input type="submit" value="add" onclick="this.form.submit()">
</form>