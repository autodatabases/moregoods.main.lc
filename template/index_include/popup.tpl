<div class="gm-block-popup js-popup-auth" style="display: none;" >
    <div class="dark" onclick="popupClose('.js-popup-auth');"></div>
    <div class="block-popup auth-popup">
        <div class="close" onclick="popupClose('.js-popup-auth');"></div>
        <div class="auth-form">
        <form action="/" method='post'>
            <div class="head">{$oLanguage->GetMessage('entrance')}</div>
            <div class="gm-block-form">
                <div class="form-element">
                    <div class="element-name">{$oLanguage->GetMessage('Login')}:</div>
                    <input type="text" name="login" value="">
                </div>
                <div class="form-element">
                    <span class="forget"><a class="gm-link-dashed" href="/pages/user_restore_password">{$oLanguage->GetMessage('lost password')}</a></span>
                    <div class="element-name">{$oLanguage->GetMessage('password')}:</div>
                    <input type="password"  name="password" value="" style="padding-right: 80px;">
                </div>
                <div class="form-element">
                    <input class="gm-button floated" type="submit" value="Войти">
                    <input name="action" value="user_do_login" type="hidden">
                    {*<label class="remember">
                        <input type="checkbox" style="-webkit-appearance: checkbox;" name="remember_me">
                        Запам'ятати мене
                    </label>*}
                </div>
                 <a class="gm-button" href="/pages/user_new_account">{$oLanguage->GetMessage('register')}</a>
            </div>
            </form>
        </div>

        {*<div class="register-advantages">
            <div class="head">{$oLanguage->GetMessage('register_plus')}</div>
           {$oLanguage->GetText('register_descript')}
            <a class="gm-button" href="/pages/user_new_account">{$oLanguage->GetMessage('register')}</a>
            <div class="clear"></div>
        </div>*}

        <div class="clear"></div>
    </div>
</div>