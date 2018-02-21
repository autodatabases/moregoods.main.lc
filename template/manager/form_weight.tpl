<script language="javascript" type="text/javascript" src="/js/form.js?3284"></script>
<table width="99%" class="gm-block-order-filter2 no-mobile">
	<tr>
	   	<td>{$oLanguage->getMessage("Item code")}:{$sZir}</td>
   		<td nowrap><input id=item_code type="text" name=data[item_code] value="{$smarty.request.item_code}" readonly>
   		</td>
   	</tr>
   	<tr>
	   	<td>{$oLanguage->getMessage("Weight")}:</td>
   		<td nowrap><input id=weight type="text" name=data[weight] value="{$aData.weight}">
   		</td>
   	</tr>
   	<tr>
	   	<td>{$oLanguage->getMessage("Name ru")}:{$sZir}</td>
   		<td nowrap><input type="text" name=data[name_rus] value="{$aData.name_rus}" style="width:177px">
   		</td>
   	</tr>
   	
   	
</table>
