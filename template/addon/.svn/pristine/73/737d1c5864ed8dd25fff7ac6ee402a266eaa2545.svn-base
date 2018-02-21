<table>
{if $aData.mobile}
	<tr>
		<td><font color=red><b>{$oLanguage->getMessage("Mobile")}:</b></font></td>
		<td><font color=red>{$aData.mobile}</font></td>
	</tr>
{/if}
	<tr>
		<td><b>{$oLanguage->getMessage("Marka")}:</b></td>
		<td>{$aData.marka}</td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("VIN")}:</b></td>
		<td>{$aData.vin}</td>
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
	<tr>
		<td><b>{$oLanguage->getMessage("Customer Info")}:</b></td>
		<td>{$oLanguage->AddOldParser('customer',$aData.id_user)}</td>
	</tr>

	<tr>
   		<td width=50%><b>{$oLanguage->GetMessage("Passport image preview")}:</b></td>
   		<td>
   		{if $aData.passport_image_name}
   			<a href='{$aData.passport_image_name}' target=_blank
				><img src='{$aData.passport_image_name_small}' width='{$oLanguage->GetConstant('passport_image:small_width',150)}'
				border=0></a>
   		{else}
   			{$oLanguage->getMessage("not uploaded")}
   		{/if}
   		</td>
  	</tr>

{if $oContent->IsChangeableLogin($aData.login)}
	<tr>
		<td><b>{$oLanguage->getMessage("Change temp login to")}:</b></td>
		<td>
		<input type=text name=data[change_login] maxlength=15
			value='{if $smarty.request.data.change_login}{$smarty.request.data.change_login}{else}m{$aData.login}{/if}' />
		<input type=hidden name=data[current_login] value='{$aData.login}' />
		</td>
	</tr>
{/if}
	<tr>
		<td colspan=2 align=center><hr></td>
	</tr>
	<!--tr>
		<td><b>{$oLanguage->getMessage("Part Description")}:</b></td>
		<td>{$aData.part_description}</td>
	</tr-->
	<tr>
		<td width=50%><b>{$oLanguage->getMessage("Old Order Status")}:</b></td>
		<td>{$oLanguage->getMessage($aData.order_status)}</td>
	</tr>
	<input type='hidden' name='old_order_status' value='{$aData.order_status}'>
	<!--tr>
		<td><b>{$oLanguage->getMessage("New Order Status")}:</b></td>
		<td>
<select name="order_status" style='width:270px'>
{foreach from=$aOrderStatusConfig item=sOrderStatus}
	<option  value="{$sOrderStatus}">{$oLanguage->getMessage($sOrderStatus)}</option>
{/foreach}
</select>
		</td>
	</tr-->
	<tr>
		<td><b>{$oLanguage->getMessage("Comment")}:</b>
		</td>
		<td><textarea name=manager_comment style='width:270px'>{$aData.manager_comment}</textarea></td>
	</tr>
	<tr>
		<td>
<input type=checkbox value=1 {if $aData.is_remember}checked{/if}
	onclick=" xajax_process_browse_url('?action=vin_request_manager_remember&id={$aData.id}&checked='+this.checked);"
	>
		<b>{$oLanguage->getMessage("Remember Text")}:</b>
		</td>
		<td><textarea name=remember_text style='width:270px'>{$aData.remember_text}</textarea></td>
	</tr>
</table>