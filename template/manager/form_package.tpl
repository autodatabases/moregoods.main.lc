<table class="gm-block-order-filter2 no-mobile" 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 0 20px 0;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 20px 20px;
    position: relative;">
	<tr>
   		<td>{$oLanguage->getMessage("Login")}:</td>
   		<td>
   		{if $oContent->IsChangeableLogin($aData.login)}
      	     <input type=text name=data[change_login] value='m{$aData.login}' maxlength=50 style='width:270px' readonly>
      	     <input type="hidden" name=data[login] value='{$aData.login}' maxlength=50 style='width:270px' readonly>
      	{else}
      	     <input type=text name=data[login] value='{$aData.login}' maxlength=50 style='width:270px' readonly>
      	{/if}
   		</td>
  	</tr>	
	<tr>
		<td>{$oLanguage->GetMessage("email")}:</td>
		<td><input type=text name=data[email] value='{$aData.email}' maxlength=50 style='width:270px'></td>
	</tr>
	
	{*<tr>
   		<td width=50%>{$oLanguage->getMessage("NameManager")}:</td>
   		<td><input type=text name=name_manager value='{$aData.name_manager}' maxlength=50 style='width:370px'></td>
  	</tr>*}
	<tr>
	<td colspan=2><i>{$oLanguage->getMessage("Delivery info")}</i><hr /></td>
	</tr>
	<tr>
	<td><nobr>{$oLanguage->getMessage("FLName")}:{*$sZir*}</td>
	<td valign=center width=280>
	<input type=text name=data[name] value='{if $aData.name}{$aData.name}{else}{$smarty.request.data.name}{/if}' style='width:270px'></td>
</tr>
<tr>
	<td><nobr>{$oLanguage->getMessage("City")}:{*$sZir*}</td>
	<td valign=center width=280>
	<input type=text name=data[city] value='{if $aData.city}{$aData.city}{else}{$smarty.request.data.city}{/if}' style='width:270px'></td>
</tr>
	<tr>
	<td><nobr>{$oLanguage->getMessage("Address")}:{*$sZir*}</td>
	<td valign=center width=280>
	<input type=text name=data[address] value='{if $aData.address}{$aData.address}{else}{$smarty.request.data.address}{/if}' style='width:270px'></td>
</tr>
<tr>
	<td><nobr>{$oLanguage->getMessage("Phone")}:{*$sZir*}</td>
	<td valign=center width=280>
	<input type=text name=data[phone] value='{if $aData.phone}{$aData.phone}{else}{$smarty.request.data.phone}{/if}' style='width:270px'></td>
</tr>
<tr>
	<td>{$oLanguage->getMessage("Comment")}:</td> 
	<td><textarea name=data[remark] style='width:270px'>{if $aData.remark}{$aData.remark}{else}{$smarty.request.data.remark}{/if}</textarea></td>
</tr>
{if $aData.is_order_by_phone_customer==1}
<tr>
	<td colspan=2>
	<b>{$oLanguage->getMessage("is_by_phone_customer")}</b>
	</td>
</tr>
{/if}
	{* include file="user/new_account_delivery_info.tpl" *}
	{*<tr>
		<td>{$oLanguage->getMessage("Delivery link")}:</td>
		<td><textarea name=data[delivery_link] style='width:270px' rows="5">{$aData.delivery_link|escape}</textarea></td>
	</tr>
	<tr>
		<td>{$oLanguage->getMessage("Vin")}:</td>
		<td><input type=text name=data[vin] value='{$aData.vin|escape}' maxlength=50 style='width:230px'>
		<input type="hidden" name=data[vin_check] value="0">
   <input type=checkbox name=data[vin_check] value='1' style="width:22px;" {if $aData.vin_check}checked{/if}>
		</td>
	</tr>*}
	{if $aData.is_need_check}
		<tr>
			<td></td>
			<td>
				<span id="auto_{$aData.id}" onclick="set_checked_auto(this,{if ($aData.is_checked_auto)}'0'{else}'1'{/if})" 
				     onmouseout="$('#tip_auto_{$aData.id}').hide();" onmouseover="$('#tip_auto_{$aData.id}').show();">
				{if $aData.is_checked_auto == 0}
					<a><img src="/image/design/not_sel_chk.png"></img></a>
				{else}
					<a><img src="/image/design/sel_chk.png"></img></a>
				{/if}
				<div align="left" style="width: 500px; display: none;" class="tip_div" id="tip_auto_{$aData.id}">{$sAutoInfo}</div>
				</span>
			</td>	
		</tr>
	{/if}
	{*
	<tr>
		<td colspan=2><i>{$oLanguage->GetMessage("Delivery point")}</i><hr /></td>
	</tr>
	<tr>
		<td></td>
		<td>
		    {foreach from=$aAdress key=iKey item=aItem}
        		<div><textarea name=data[addreses][{$aItem.id}] style='width:195px' {if $bReadOnly}disabled{/if}>{$aItem.addresses}</textarea>
        		<input type="button" class="btn rmAddress" value="-" style="margin-top: -55px;"></div>
    		{/foreach}
    		<br><input type="button" class="btn addAddress" value="{$oLanguage->GetMessage("add address")}">
		</td>
	</tr>
	*}
</table>