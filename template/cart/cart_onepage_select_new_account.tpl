<table>
  	<tr>
    	<td><nobr><b>{$oLanguage->getMessage("Phone")}:</b>{$sZir}<span id='check_login_image_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
    	<td valign=center width=280>
    	<input type=text name=data[phone] value='{if $aUser.name}{$aUser.phone}{else}{$smarty.request.data.phone}{/if}' style='width:270px' class='phone'
    	onblur="javascript: xajax_process_browse_url('?action=user_check_login&login='+this.value); return false;">
    	</td>
    </tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Password")}:</b>{$sZir}</td>
		<td>
		<input type=text name=data[password] value='{$smarty.request.data.password}'
			 maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td><b>{$oLanguage->getMessage("Retype Password")}:</b>{$sZir}</td>
		<td>
	<input type=text name=data[verify_password] value='{$smarty.request.data.verify_password}'
		 maxlength=50 style='width:270px'></td>
	</tr>
	<tr>
		<td><nobr><b>{$oLanguage->getMessage("Email")}:</b></td>
		<td valign=center width=280>
		<input type=text name=data[email] value='{$smarty.request.data.email}' style='width:270px'></td>
	</tr>
	<tr>
		<td><nobr><b>{$oLanguage->getMessage("FLName")}:</b>{$sZir}</td>
		<td valign=center width=280>
		<input type=text name=data[name] value='{if $aUser.name}{$aUser.name}{else}{$smarty.request.data.name}{/if}' style='width:270px'></td>
	</tr>
	<tr>
		<td><nobr><b>{$oLanguage->getMessage("City")}:</b></td>
		<td valign=center width=280>
		<input type=text name=data[city] value='{if $aUser.name}{$aUser.city}{else}{$smarty.request.data.city}{/if}' style='width:270px'></td>
	</tr>
	<tr>
	   <td width=50%><b>{$oLanguage->getDMessage('Region')}:</b>{$sZir}</td>
	    <td>
	    {if $aUser.id_region}
	        {assign var=iIdRegion value=$aUser.id_region}
	    {else}
	        {assign var=iIdRegion value=$smarty.request.data.id_region}
	    {/if}
	   {html_options name=data[id_region] options=$aRegionList selected=$iIdRegion style='width: 92% !important;max-width: 400px;'}
	  </td>
	</tr>
	{* include file="user/new_account_delivery_info.tpl" *}
	{ include file="cart/cart_onepage_delivery.tpl" }
	{ include file="cart/cart_onepage_payment.tpl" }
</table>