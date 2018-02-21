<div class="gm-block-popup js-popup-auth2" style="display: none;  " >
    <div class="dark"></div>
    {*<div class="dark" onclick="popupClose('.js-popup-auth2');"></div>*}
    <div class="block-popup auth-popup" style="padding: 20px 84px;">
        {*<div class="close" onclick="popupClose('.js-popup-auth2');"></div>*}
        <div class="auth-form">
        {*<form action="/" method='post'>*}
            <div class="head" style="color:red">{$oLanguage->GetMessage('Увага!')}</div>
            <div class="gm-block-form">
                <div class="form-element" id="sum_dolg" >   
                 {if $aAuthUser.type_!='manager'}
<pre><p>Не сплачені <a style="color: #5fb7c1;" class="link-clear" target="_blank" href="/pages/finance_user_debt?search_dist=0&search%5Bis_debt%5D=is&action=finance_user_debt"><span class="gm-link-dashed">замовлення</span></a>, на сумму <span style="color:red">{$aBonus} грн. </span>
Бажаєте сплатити попередні замовлення при отриманні?
<br>             
*<em>При доставці поточного замовлення перш ніж його отримати Ви маєте сплатити попереднє замовлення, 
у разі відмови від оплати, водій не має права віддати Ваше поточне замовлення.</em><p></pre>
                {/if}              
                </div>
            </div>
           {* </form>*}
        </div>
        <div class="register-advantages" style="margin: 47px 0;text-align: center; width: 277px;">
            <label class="remember">
                {if $aAuthUser.type_!='manager'}
                        <span><input type="checkbox" onchange="popupClose('.js-popup-auth2'); javascript: location.href='/?action=cart_onepage_order'" style="-webkit-appearance: checkbox;" name="dolg">
                        <b>{$oLanguage->GetMessage('oplatit pri poluchenii')}</b></span>
                {else}
                        <span><input type="checkbox" onchange="popupClose('.js-popup-auth2');" style="-webkit-appearance: checkbox;" name="dolg">
                        <b>{$oLanguage->GetMessage('oplatit pri poluchenii')}</b></span>
                {/if}
            </label>    
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>
</div>
