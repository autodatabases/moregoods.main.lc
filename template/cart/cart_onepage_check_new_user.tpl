<div class="block-form">
	{ include file="cart/cart_onepage_delivery.tpl" }
	{ include file="cart/cart_onepage_payment.tpl" }
	<button class='gm-button' type='submit' id='end_cart' style='display:none'>{$oLanguage->getMessage("Завершить оформление")}</button>
	</div>
	<div class="block-info">
                <div class="head">{$oLanguage->getMessage("Личные данные")}</div>
                <div class="gm-block-form">
					<div class="form-element">
					<div class="element-name">{$oLanguage->getMessage("Phone")}:{$sZir}<span id='check_login_image_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
			    	<input type=text name=data[phone] value='{if $aUser.name}{$aUser.phone}{else}{$smarty.request.data.phone}{/if}' style='width:100%' class='phone'
    	onblur="javascript: xajax_process_browse_url('?action=user_check_login&login='+this.value); return false;">
    	
					</div>
					
					<div class="form-element">
					<div class="element-name">{$oLanguage->getMessage("Password")}:{$sZir}</div>
		<input type=password name=data[password] value='{$smarty.request.data.password}'
			 maxlength=50 style='width:100%'>
					</div>

<div class="form-element">
					<div class="element-name">{$oLanguage->getMessage("Retype Password")}:{$sZir}</div>
	<input type=password name=data[verify_password] value='{$smarty.request.data.verify_password}'
		 maxlength=50 style='width:100%'>
</div>
	
	<div class="form-element">
					<div class="element-name">{$oLanguage->getMessage("Email")}:{$sZir}</div>
		<input type=text name=data[email] value='{$smarty.request.data.email}' style='width:100%'>
</div>
	{ include file="user/new_account_delivery_info.tpl" }

<div class="form-element">
		<input type=checkbox name=data[user_agreement] value='1' style="-webkit-appearance: checkbox;"
			{if $smarty.request.data.user_agreement} checked{/if}>
		{$oLanguage->getMessage("I agree to")} <a href='/pages/agreement' target=_blank
			>{$oLanguage->getMessage("User agreement")}</a>
</div>

 
</div>

</div>
