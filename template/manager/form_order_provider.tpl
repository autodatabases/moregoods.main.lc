<script language="javascript" type="text/javascript" src="/js/form.js?3284"></script>
<table width="99%" class="gm-block-order-filter2 no-mobile">
	<tr>
		<td>{$oLanguage->getMessage("Provider")}:</td>
   		<td><input type="text" value="{$aData.provider_name}" style="width:155px" readonly>
		</td>
   	</tr>
   	<tr>
		<td>{$oLanguage->getMessage("Order to the provider")}:{$sZir}</td>
   		<td><select name="data[id_provider_ordered]" style="width: 155px;" >
			{html_options options=$aProvider selected=$aData.id_provider_ordered}
			</select>			
		</td>
   	</tr>
</table>
