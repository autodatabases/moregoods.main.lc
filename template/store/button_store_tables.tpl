<input type="hidden" name="is_post" value="1">
<input type="hidden" name="store" value="{$smarty.request.store}">
<input type="submit" value="{$oLanguage->GetMessage('add to sale')}" onclick="if (confirm('вы уверены?'))
	mt.ChangeActionSubmit(document.getElementById('table_form'),'store_add_to_sale'); return false;">
	
<input type="submit" value="{$oLanguage->GetMessage('add to transfer')}" onclick="if (confirm('вы уверены?'))
	mt.ChangeActionSubmit(document.getElementById('table_form'),'store_add_to_transfer'); return false;">
	
<input type="submit" value="{$oLanguage->GetMessage('export to price')}" onclick="if (confirm('вы уверены?'))
	mt.ChangeActionSubmit(document.getElementById('table_form'),'store_export_to_price'); return false;">