<br>
<form class="form" id="add_form">
<select name="data[id_from]">{html_options options=$aStoresFrom}</select>
 => 
<select name="data[id_to]">{html_options options=$aStoresTo}</select>

<input type="hidden" name="action" value="store_input_invoice_manual_process">
<input type="hidden" name="is_post" value="1">
<input type="submit" value="process" onclick="this.form.submit()">
</form>