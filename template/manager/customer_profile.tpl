<table class="gm-block-order-filter2 " 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 0 20px 0;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 20px 20px;
    position: relative;">
	<tr>
		<td>{$oLanguage->GetMessage("Your login")}:
		{if $bLoginChange}{$oLanguage->getContextHint("customer_account_login_change")}{/if}</td>
		<td style="border: 1px solid #cccccc;padding: 10px 10px 10px 10px; border-radius: 5px;">{$aUser.login}&nbsp;&nbsp;
		{if $bLoginChange}
		<a class="gm-link-dashed" href='/?action=manager_set_user_login&id_user={$aUser.id}'>{$oLanguage->GetMessage("Set New Login")}
		{/if} 
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("Your email")}:{if !$bReadOnly}{$sZir}{/if}</td>
		<td style="padding: 10px 0;"><input type=text name=data[email] value='{$aUser.email}' maxlength=50 style='width:100%'
		{if $bReadOnly}readonly{/if}></td>
	</tr>
	{if $bPasswChange}
	<tr>
		<td>{$oLanguage->GetMessage("Password")}:</td>
		<td style="padding: 10px 0px 10px 0px;">******&nbsp;&nbsp;
		<a class="gm-link-dashed" style="float: right;border: 1px solid #cccccc;padding: 10px 20px 10px 20px; border-radius: 5px;background-color: white;" 
		href='/?action=manager_set_user_password&id_user={$aUser.id}'>{$oLanguage->GetMessage("Change Password")}
		</td>
	</tr>
	{/if}
{*	<tr>
		<td>{$oLanguage->GetMessage("Your manager")}:</td>
		<td style="padding: 10px 0px 10px 0px;"> {$aAuthUser.manager_login}
&nbsp;
	<a class="gm-link-dashed" style="float: right;border: 1px solid #cccccc;padding: 10px 44px 10px 44px; border-radius: 5px;background-color: white;" 
	href='/?action=message_compose&compose_to={$aAuthUser.manager_login}'
		>{$oLanguage->getMessage("Send message to manager")}</a>

		</td>
	</tr>
	*}
	<tr>
		<td>{$oLanguage->getMessage("Basic Currency")}:
		<td>
		<div class="options">
		<select class="js-uniform" id="menu_select" name=data[id_currency] style='width:100%' class="gm-select">
		{section name=d loop=$aCurrency}
		<option value={$aCurrency[d].id}
			{if $aCurrency[d].id == $aUser.id_currency} selected {/if}
			{if $bReadOnly}disabled{/if}
			>{$aCurrency[d].name}</option>
		{/section}
		</select>
		</div>
		</td>
	</tr>
	<tr>
		<td>{$oLanguage->getMessage("Group")}:{if $bGroupChange}{$sZir}{/if}</td>
		<td valign=center width=280>
		{if $bGroupChange}
        <div class="form-element">
        {assign var=iIdGroup value=$aUser.id_customer_group}
		{html_options name=data[id_group] options=$aGroupsG selected=$iIdGroup class=js-uniform style='width:100%'}
         </div>
		{else}	
		<input type=text name=data[id_group] value='{$aGroupSelected}' style='width:100%' readonly></td>
		{*<select data-placeholder="{$oLanguage->GetMessage('select region')}" tabindex="2" name=data[id_region]>
        	{html_options options=$aCity selected=$sSelectedCity}
        	</select>*}
		{/if}
		</td>
	</tr>

	<tr>
		<td>{$oLanguage->getMessage("Canal")}:{if $bGroupChange}{$sZir}{/if}</td>
		<td valign=center width=280>
		{if $bGroupChange}
        <div class="form-element">
        {assign var=iIdType value=$aUser.id_user_customer_type}
		{html_options name=data[id_user_customer_type] options=$aTypeG selected=$iIdType class=js-uniform style='width:100%'}
         </div>
		{else}	
		<input type=text name=data[id_user_customer_type] value='{$aTypeSelected}' style='width:100%' readonly></td>
		{/if}
		</td>
	</tr>

	<tr>
		<td colspan=2><i>{$oLanguage->GetMessage("Delivery info")}</i><hr /></td>
	</tr>
    <script type="text/javascript" src="/js/user.js?2"></script>
	<tr>
		<td><nobr>{$oLanguage->GetMessage("FLName")}:{if !$bReadOnly}{$sZir}{/if}</td>
		<td valign=center width=280>
		<input type=text name=data[name] value='{$aUser.name|stripslashes}' style='width:100%'
		{if $bReadOnly}readonly{/if}></td>
	</tr>
	<tr>
		<td><nobr>{$oLanguage->GetMessage("GeoRegion")}:{if $bRegionChange}{$sZir}{/if}</td>
		<td valign=center width=280>
		
		{if $bRegionChange}
        <div class="form-element">
        {assign var=iIdGeoRegion value=$aUser.id_geo}
		{html_options name=data[id_geo] options=$aGeoRegionList selected=$iIdGeoRegion class=js-uniform style='width:100%'}
         </div>
		{else}	
		<input type=text name=data[id_geo] value='{$aRegionGeoSelected}' style='width:100%' readonly></td>
		{*<select data-placeholder="{$oLanguage->GetMessage('select region')}" tabindex="2" name=data[id_geo]>
        	{html_options options=$aCity selected=$sSelectedCity}
        	</select>*}
		{/if}
		
		
		</td>
	</tr>

	<tr>
		<td><nobr>{$oLanguage->GetMessage("region")}:{if $bRegionChange}{$sZir}{/if}</td>
		<td valign=center width=280>
		
		{if $bRegionChange}
        <div class="form-element">
        {assign var=iIdRegion value=$aUser.id_region}
		{html_options name=data[id_region] options=$aRegionList selected=$iIdRegion class=js-uniform style='width:100%'}
         </div>
		{else}	
		<input type=text name=data[id_region] value='{$aRegionSelected}' style='width:100%' readonly></td>
		{*<select data-placeholder="{$oLanguage->GetMessage('select region')}" tabindex="2" name=data[id_region]>
        	{html_options options=$aCity selected=$sSelectedCity}
        	</select>*}
		{/if}
		
		
		</td>
	</tr>
	


	<tr>
		<td><nobr>{$oLanguage->GetMessage("City")}:{if !$bReadOnly}{$sZir}{/if}</td>
		<td valign=center width=280>
		<input type=text name=data[city] value='{$aUser.city|stripslashes}' style='width:100%'
		{if $bReadOnly}readonly{/if}></td>
	</tr>
  	<tr>
		<td><nobr>{$oLanguage->GetMessage("Address")}:{if !$bReadOnly}{$sZir}{/if}</td>
		<td valign=center width=280>
		<input type=text name=data[address] value='{$aUser.address|stripslashes}' style='width:100%'
		{if $bReadOnly}readonly{/if}></td>
	</tr>
	<tr>
		<td><nobr>{$oLanguage->GetMessage("Phone")}:{if !$bReadOnly}{$sZir}{/if}</td>
		<td valign=center width=280>
		<input type=text name=data[phone] value='{$aUser.phone|stripslashes}' style='width:100%' id='user_phone' placeholder="(___)___ __ __"
		{if $bReadOnly}readonly{/if}></td>
	</tr>
{*	
	<tr>
		<td>{$oLanguage->getMessage("Store num rating")}:</td>
		<td>
		<select onchange="
{strip}
xajax_process_browse_url('/?action=customer_change_rating
&id_user={$aRow.id_user}&num_rating='+this.value); return false;
{/strip}"
			style='width:100%' class="js-uniform">
			{html_options options=$aRatingAssoc selected=$aAuthUser.num_rating}

		</select>
		</td>
	</tr>
*}	
	<tr>
		<td valign=top>{$oLanguage->GetMessage("CustomerRemarks")}:{if !$bReadOnly}{$sZir}{/if}</td>
		<td><textarea name=data[remark] style='width:100%' {if $bReadOnly}disabled{/if}>{$aUser.remark|stripslashes}</textarea></td>
	</tr>
{*	
	<tr>
		<td colspan=2><i>{$oLanguage->GetMessage("Delivery points")}</i><hr /></td>
	</tr>
	<tr>
		<td colspan=2>
		{foreach from=$aAdress key=iKey item=aItem}
        		<div class="outer"><textarea name=data[addreses][{$aItem.id}] style='width:88%' {if $bReadOnly}disabled{/if}>{$aItem.addresses}</textarea>
        		<div class='remove_btn inner'><a href="javascript:void(0)" class="link-delete rmAddress"></a></div></div>
    		{/foreach}
    		<br><input type="button" style="border: 1px solid #cccccc;padding: 10px 20px 50px 20px; border-radius: 10px;"
			class="btn addAddress" value="{$oLanguage->GetMessage("add address")}">
    		<br><br><br>
		</td>
	</tr>
*}
  	<tr>
		<td><nobr>{$oLanguage->GetMessage("is_bonus")}:</td>
		<td valign=center width=280>
		<input type=hidden name=data[is_bonus] value='0'>
		<input type=checkbox name=data[is_bonus] value='1' {if $aUser.is_bonus==1}checked{/if}
		></td>
	</tr>
</table>