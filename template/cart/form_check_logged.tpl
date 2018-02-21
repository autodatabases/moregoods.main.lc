<div class="auth-form" 
style=" background-color: #f8f8f8;
    border-radius: 5px;
    margin: 0 0 0 -80px;
    border: 1px solid #5fb7c1;
    padding: 20px 20px 0px 20px;
    position: relative;
	width: 340px;">
                <div class="head" style="font-size:20px">Я уже зарегистрирован</div>
                <div class="gm-block-form">
                    <div class="form-element">
                        <div class="element-name">{$oLanguage->getMessage("Login")}:{*$sZir*}</div>
                        <input maxlength="50" size="18" name=data[old_login] value="{$smarty.request.data.old_login}" type="text">
                    </div>
                    <div class="form-element">
                        <span class="forget"><a class="gm-link-dashed" href="/pages/user_restore_password">Забыли пароль?</a></span>
                        <div class="element-name">{$oLanguage->getMessage("Password")}:{*$sZir*}</div>
                        <input maxlength="50" size="18" name=data[old_password] type="password" style="padding-right: 80px;">
                    </div>
                    <div class="form-element">
                        <input class="gm-button floated" style="margin: 22px 0px 22px 0px" type="submit" value="Войти">
                        {*<label class="remember" style="margin: 22px 0px 0px 0px">
                            <input name=remember_me value="1" class="no" type="checkbox" style='-webkit-appearance:checkbox'>&nbsp;{$oLanguage->GetMessage("Remember me")}
                        </label>*}
                    </div>
                </div>
            </div>

			{include file="cart/order_by_phone_2.tpl"}

			