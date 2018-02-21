<table width=700 border=0 class="gm-block-order-filter ">
	<tr>

		<td>{$oLanguage->getMessage("id_brand_group")}:</td>
		<td class="sel4">
		{html_options name=search_brand_group options=$aNameBrandGroup selected=$smarty.request.search_brand_group id="select_name_user4"
								style='width:160px;padding: 8px 8px 8px 10px;height: 40px;'}
			<script type="text/javascript">
	    {literal}
	    $(document).ready(function() {
		    $("#select_name_user4").searchable({
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
		<td>{$oLanguage->getMessage("id_dist")}:</td>
		<td class="sel4">
		{html_options name=search_dist options=$aNameDistr selected=$smarty.request.search_dist id="select_name_user3"
								style='width:160px;padding: 8px 8px 8px 10px;height: 40px;'}
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
		<td>{$oLanguage->getMessage("Group")}:</td>
		<td>
		<select name='search_group' style='width:130px;padding: 8px 8px 8px 10px;height: 40px;'>
			{html_options options=$aGroupsG  selected=$smarty.request.search_group}
			</select>
		</td>
		
		{/if}
</tr>
<tr>
		<td>{$oLanguage->getMessage("id_brand")}:</td>
		<td class="sel4">
		{html_options name=search_brand options=$aNameBrand selected=$smarty.request.search_brand id="select_name_user5"
								style='width:160px;padding: 8px 8px 8px 10px;height: 40px;'}
			<script type="text/javascript">
	    {literal}
	    $(document).ready(function() {
		    $("#select_name_user5").searchable({
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
		<td class="sel4">
		
		{html_options  name=search_login options=$aNameUser selected=$smarty.request.search_login id="select_name_user2"
								style='width:160px;padding: 8px 8px 8px 10px;height: 40px;'}
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
		</td>
		
		<td>{$oLanguage->getMessage("InList")}:</td>
		<td >
			<select name=search_list style='width:130px;padding: 8px 8px 8px 10px;height: 40px;'>
			{html_options options=$aList  selected=$smarty.request.search_list}
			</select>
		</td>

		{/if}
	</tr>
</table>