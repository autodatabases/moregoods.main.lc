<br>
<form class="form" id="add_form">
{$oLanguage->GetMessage('order #')}: <input type="text" name="data[id_order]" value="">
 => 
<select name="data[id_to]">{html_options options=$aStoresTo}</select>

<input type="hidden" name="action" value="store_sale_invoice_process">
<input type="hidden" name="is_post" value="1">
<input type="submit" value="process" onclick="this.form.submit()">
</form>