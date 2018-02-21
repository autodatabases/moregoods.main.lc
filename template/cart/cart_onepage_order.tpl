<div class="gm-block-order-legend">
            <div class="legend-wrap">
                <div class="step">{$oLanguage->getMessage("Корзина")}</div>
                <div class="step selected">{$oLanguage->getMessage("Доставка")}</div>
                <div class="step">{$oLanguage->getMessage("Оплата")}</div>
                <div class="clear"></div>
            </div>
        </div>
{if !isset($aUser)}
	 <div class="gm-makeorder-auth" style="padding: 0 0 0px 80px;">
            {$sCheckLoggedForm}
{*
            <div class="register-advantages">
                { *<div class="head">Преимущества регистрации</div>
                <ul>
                    <li>Вы будете тратить меньше времени на оформление заказа</li>
                    <li>Отслеживать состояние заказов и историю покупок</li>
                    <li>За Вами будет закреплен персональный менеджер</li>
                    <li>Добавлять товары в избранное для дальнейшей покупки</li>
                </ul>* }
                <a class="gm-button" href="javascript:void(0);" id='cart_register'>{$oLanguage->getMessage("Регистрация")}</a>
                <div class="clear"></div>
            </div>
*}
            <div class="clear"></div>
            
        </div>
           <div class="gm-makeorder-delivery" id='delivery_new_account' style='display:none'>
        
            {$sCheckNewAccountForm}<br />
            
            
            <div class="block-button" style='display:none' id='btn_new_account'>
                <a href="javascript:void(0);" class="gm-button" id='continue_cart2'>{$oLanguage->getMessage("Продолжить оформление")}</a>
            </div>
            </div>
	
{else}

        <div class="gm-makeorder-delivery">
        
            {$sCheckNewAccountForm}<br />
            
            </div>
{/if}
