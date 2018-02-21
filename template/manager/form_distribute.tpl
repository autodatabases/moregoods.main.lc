<table width=700 border=0 class="gm-block-order-filter no-mobile">
	<tr>
		<td>{$oLanguage->getMessage("id_dist")}:</td>
		<td class="sel">
		{html_options name=search_dist options=$aNameDistr selected=$smarty.request.search_dist id="select_name_user3"
								style="width: 196px;  max-width: 270px; "}
			<script type="text/javascript">
	    {literal}
	    $(document).ready(function() {
		    $("#select_name_user3").searchable({
		    maxListSize: 50,
		    maxMultiMatch: 25,
		    wildcards: true,
		    ignoreCase: true,
		    latency: 10,
		    {/literal}warnNoMatch: '{$oLanguage->getMessage('no matches')} ...',{literal}
		    zIndex: 'auto'
		    });
	    });
	    {/literal}
	    </script>
		</td>
		{if $aAuthUser.type_=='manager'}
		<td>{$oLanguage->getMessage("user_debt")}:</td>
		<td class="sel">
		
		{html_options  name=search_login options=$aNameUser selected=$smarty.request.search_login id="select_name_user2"
								style="width: 160px; max-width: 270px;"}
		<script type="text/javascript">
    {literal}
    $(document).ready(function() {
	    $("#select_name_user2").searchable({
	    maxListSize: 50,
	    maxMultiMatch: 25,
	    wildcards: true,
	    ignoreCase: true,
	    latency: 10,
	    {/literal}warnNoMatch: '{$oLanguage->getMessage('no matches')} ...',{literal}
	    zIndex: 'auto'
	    });
    });
    {/literal}
    </script>
		</td>{/if}
		
		<td>{$oLanguage->getMessage("is_debt")}:</td>
		<td>
		<div class="options">
		<select class="js-uniform" id="menu_select" name='search[is_debt]' >
    		<option value=''>Все</option>
    		<option {if $smarty.request.search.is_debt=='is'} selected {/if} value='is'>Есть долг</option>
		</select>
		</div>
		</td>
	</tr>
</table>