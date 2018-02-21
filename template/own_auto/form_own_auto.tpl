<table>
	<tr>
		<td><b>{$oLanguage->getMessage("Marka")}:</b></td>
		<td>{$aData.marka}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("VIN")}:</b></td>
		<td>{$aData.vin|upper}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Model")}:</b></td>
		<td>{$aData.model}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Engine")}:</b></td>
		<td>{$aData.engine}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Country producer")}:</b></td>
		<td>{$aData.country_producer}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Month/Year")}:</b></td>
		<td>{$oLanguage->getMessage($aData.month)} / {$aData.year} </td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Volume")}:</b></td>
		<td>{$aData.volume}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Body")}:</b></td>
		<td>{$aData.body}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("KPP")}:</b></td>
		<td>{$aData.kpp}</td>
	</tr>

{if $aData.wheel}
	<tr>
		<td><b>{$oLanguage->getMessage("Wheel")}:</b></td>
		<td>{$aData.wheel}</td>
	</tr>
{/if}

{if $aData.utable}
	<tr>
		<td><b>{$oLanguage->getMessage("VinUtable")}:</b></td>
		<td>{$aData.utable}</td>
	</tr>
{/if}

{if $aData.engine_number}
	<tr>
		<td><b>{$oLanguage->getMessage("VinEngineNumber")}:</b></td>
		<td>{$aData.engine_number}</td>
	</tr>
{/if}

{if $aData.engine_code}
	<tr>
		<td><b>{$oLanguage->getMessage("engine_code")}:</b></td>
		<td>{$aData.engine_code}</td>
	</tr>
{/if}

{if $aData.engine_volume}
	<tr>
		<td><b>{$oLanguage->getMessage("engine_volume")}:</b></td>
		<td>{$aData.engine_volume}</td>
	</tr>
{/if}

{if $aData.kpp_number}
	<tr>
		<td><b>{$oLanguage->getMessage("kpp_number")}:</b></td>
		<td>{$aData.kpp_number}</td>
	</tr>
{/if}

	<tr>
		<td><b>{$oLanguage->getMessage("Additional")}:</b></td>
		<td>{$aData.additional}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Customer Comment")}:</b></td>
		<td>{$aData.customer_comment}</td>
	</tr>
</table>