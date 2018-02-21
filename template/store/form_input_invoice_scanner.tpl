
<h3>{$oLanguage->GetMessage('add by scanner')}</h3>

<form class="form" id="add_form_by_scanner">
<b>{$oLanguage->GetMessage('item codes')}:</b><br>
<textarea rows="16" cols="50" name="item_codes"></textarea><br>

<input type="hidden" name="action" value="store_input_invoice_scanner">
<input type="hidden" name="is_post" value="1">
<input type="submit" value="add" onclick="this.form.submit()">
</form>