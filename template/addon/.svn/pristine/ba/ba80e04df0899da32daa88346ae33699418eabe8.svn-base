<span>

<select id='filter_select_id' name=data[admin_filter] style="width: 100px;">
	{foreach from=$aField item=aItem}
		<option value="{$aItem.id}">{$aItem.title}</option>
	{/foreach}
</select>
<input type=text id='filter_input_id' name=filter_input value='' class=filter_input>

&nbsp;<a href='?action={$sBaseAction}_filter' id=filter_link_id
	onclick="javascript: if (document.getElementById('filter_input_id').value!='')
	xajax_process_browse_url('?action={$sBaseAction}_filter&field='
		+document.getElementById('filter_select_id').options[document.getElementById('filter_select_id').selectedIndex].value
        +'&value='+document.getElementById('filter_input_id').value);
        return false;"
	><b>Filter</b></a>&nbsp;
	&nbsp;<a href='?action={$sBaseAction}_filter_clear'
		onclick="javascript: xajax_process_browse_url('?action={$sBaseAction}_filter_clear'); return false;"
	><b>Clear</b></a>

</span>