<?php /* Smarty version 2.6.18, created on 2017-05-20 08:34:57
         compiled from cart/popup_dolg.tpl */ ?>
<div class="gm-block-popup js-popup-auth2" style="display: none;  " >
    <div class="dark"></div>
        <div class="block-popup auth-popup" style="padding: 20px 84px;">
                <div class="auth-form">
                    <div class="head" style="color:red"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Увага!'); ?>
</div>
            <div class="gm-block-form">
                <div class="form-element" id="sum_dolg" >   
                 <?php if ($this->_tpl_vars['aAuthUser']['type_'] != 'manager'): ?>
<pre><p>Не сплачені <a style="color: #5fb7c1;" class="link-clear" target="_blank" href="/pages/finance_user_debt?search_dist=0&search%5Bis_debt%5D=is&action=finance_user_debt"><span class="gm-link-dashed">замовлення</span></a>, на сумму <span style="color:red"><?php echo $this->_tpl_vars['aBonus']; ?>
 грн. </span>
Бажаєте сплатити попередні замовлення при отриманні?
<br>             
*<em>При доставці поточного замовлення перш ніж його отримати Ви маєте сплатити попереднє замовлення, 
у разі відмови від оплати, водій не має права віддати Ваше поточне замовлення.</em><p></pre>
                <?php endif; ?>              
                </div>
            </div>
                   </div>
        <div class="register-advantages" style="margin: 47px 0;text-align: center; width: 277px;">
            <label class="remember">
                <?php if ($this->_tpl_vars['aAuthUser']['type_'] != 'manager'): ?>
                        <span><input type="checkbox" onchange="popupClose('.js-popup-auth2'); javascript: location.href='/?action=cart_onepage_order'" style="-webkit-appearance: checkbox;" name="dolg">
                        <b><?php echo $this->_tpl_vars['oLanguage']->GetMessage('oplatit pri poluchenii'); ?>
</b></span>
                <?php else: ?>
                        <span><input type="checkbox" onchange="popupClose('.js-popup-auth2');" style="-webkit-appearance: checkbox;" name="dolg">
                        <b><?php echo $this->_tpl_vars['oLanguage']->GetMessage('oplatit pri poluchenii'); ?>
</b></span>
                <?php endif; ?>
            </label>    
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>
</div>