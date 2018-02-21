
   <div class="form-group form-group-sm">
      <label class="sr-only">Search</label>
         <input type="text" id="filter_input_id" class="form-control btn-sm" placeholder="Search" value="{$sFilterValue}" />
   </div>
   <div class="form-group form-group-sm">

<select id=filter_select_id name="filter_select" id="filter_select_id" class="btn btn-sm btn-default">
	{foreach key=sField item=aRow from=$oTable->aColumn}
	{if $aRow.sOrder!=''}
	<option value="{$sField}"{if $sFilter==$sField} selected{/if}>{$aRow.sTitle}</option>
	{/if}
	{/foreach}
</select>
 <a class="btn btn-success btn-sm" id='find_by_filter' href="?{$sQueryString}"
onclick="
        xajax_process_browse_url(this.href
        +(document.getElementById('filter_input_id').value!=''?
        '&filter='+document.getElementById('filter_select_id').options[document.getElementById('filter_select_id').selectedIndex].value
        +'&filter_value='+document.getElementById('filter_input_id').value
        :'')
        );
return false;
"
><i class="fa fa-search" aria-hidden="true"></i></a>

  <a class="btn btn-danger btn-sm" href="?{$sQueryString}"
onclick="xajax_process_browse_url(this.href);return false;">
  <i class="fa fa-remove" aria-hidden="true"></i>
  </a>
   </div>
