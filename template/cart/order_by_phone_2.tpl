 {if !($aAuthUser.id && !($oContent->IsChangeableLogin($aAuthUser.login))) }
<table class='auth-form  no-mobile no-tablet respons' 
style=" background-color: white;
    border-radius: 5px;
    margin: 0 0 20px 0;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 20px 20px;
    position: relative;
    left: 10px;">
	<tr >
	<td >
	        <div class="register-advantages" style="width:320px">
				{*<div class="head" style="font-size:20px;margin: 0 0 -24px 0;">{$oLanguage->GetMessage('register_plus')}</div>
				{$oLanguage->GetText('register_descript')*}
				<a class="gm-button" style="margin: 18px 0px 0px 20px;" href="/pages/user_new_account">{$oLanguage->GetMessage('register')}</a>
			</div>

	</td>
	</tr>
	</table>

<table class='auth-form respons' 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 -20px 20px 0;
    border: 1px solid #5fb7c1;
    padding: 10px 20px 20px 20px;
    position: relative;
    left: 20px;">
	
	
	<tr>
		<td><nobr>{$oLanguage->getMessage("Phone")}:{$sZir}</td>
		<td valign=center style="font-size: 16px;font-weight: 800;">+38 
		<input type="text" name=data[order_by_phone] placeholder="(___)___ __ __" style="width: 200px;" value="{if $aAuthUser.phone}{$aAuthUser.phone}{else}{$smarty.request.user_phone}{/if}" id="user_phone" class="phone fast_order_phone"/>
		</td>
	</tr>
	<tr>
		<td><nobr>{$oLanguage->getMessage("Your name")}:{*$sZir*}</td>
		<td valign=center>
		<input type=text name=data[name] value='{if $aData.name}{$aData.name}{else}{$smarty.request.user_name}{/if}' style='width:240px' id="user_name"></td>
	</tr>
	<tr>
		<td>{$oLanguage->GetMessage("email")}:</td>
		<td><input type=email name=data[email] value='{$smarty.request.user_email}' maxlength=50 style='width:240px' id="user_email"></td>
	</tr>
	<tr>
		<td>{$oLanguage->getMessage("Comment")}:</td>
		<td><textarea name=data[remark] style='width:240px' id="user_comment">{if $aData.remark}{$aData.remark}{else}{$smarty.request.user_comment}{/if}</textarea></td>
	</tr>
	<tr>
		<td colspan=2>
                    <div class="capcha">
{$oLanguage->getMessage("Capcha field")}:{$sZir}
                        <div class="formula">
                            {$sCapcha}
                        </div>
                    </div>
		</td>				
	</tr>

	<tr>
	<td colspan=2 style="padding: 0 0 0 16px;">
{*	<input type=button class='btn order-package-btn' style="margin: 10px 0px 0px 0px;" value="{$oLanguage->getMessage("Order by phone")}" id="fast_order_button" onclick="check_phone(); return false;" tabindex="1"/></td>
*}
                    <input class="gm-button" type="submit" value="{$oLanguage->GetMessage('Order by phone')}"> 	</td>
	</tr>
	
	
	</table>



{* <script src="/js/check_phone.js?1"></script> *}
{/if}