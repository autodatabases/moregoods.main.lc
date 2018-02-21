<table>
	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("Id Cart")}:</b> {$sZir}</td>
   		<td><input type=text name=data[id_cart] value='{$aData.id_cart}' maxlength=20 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("number")}:</b></td>
   		<td><input type=text name=data[number]
			value='{if !$aData.number}1{else}{$aData.number}{/if}' maxlength=20 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("weight_payment")}: ($)</b></td>
   		<td><input type=text name=data[weight_payment] value='{$aData.weight_payment}'
				maxlength=20 style='width:270px'></td>
  	</tr>
  	<tr>
   		<td width=50%><b>{$oLanguage->getMessage("volume_payment")}: ($)</b></td>
   		<td><input type=text name=data[volume_payment] value='{$aData.volume_payment}'
				maxlength=20 style='width:270px'></td>
  	</tr>
</table>