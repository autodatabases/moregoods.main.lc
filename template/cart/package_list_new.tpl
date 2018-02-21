            <div class="gm-ordermobile-link-filter">
                <a href="#" class="gm-link-dashed">{$oLanguage->getMessage("Фильтры")}</a>
            </div>
            

            <div class="gm-order-list">
            {if $aCartPackage}
{foreach from=$aCartPackage item=aRow}
                <div class="gm-order-element">
                    <div class="head">
                        <div class="toggle js-order-toggle"></div>
                        <div class="name">
                            <strong>№ {$aRow.id}</strong>  |  {$oCurrency->PrintPrice($aRow.price_total,1)}  |  {$aRow.date_delivery}
                            <span class="description">{$aRow.post_date} | {$aRow.delivery_point}</span>
                        </div>
                        {*<div class="download">
                            <a href="/?action=cart_package_print&id={$aRow.id}" target="_blank"><span class="gm-link-dashed">{$oLanguage->getMessage("download_sch")}</span></a>
                        </div>*}
                        <div class="status">
                            {$oLanguage->getOrderStatus($aRow.order_status)}
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="body">
                        <table>
                            <thead>
                                <tr>
                                    <td>Наименование</td>
                                    <td>Цена грн.</td>
                                    <td>Кол-во шт</td>
                                    <td>Сумма грн.</td>
                          
                                </tr>
                            </thead>
                            {foreach from=$aRow.aCart item=aCart}
                            {*$aCart|@debug_print_var*}
                            <tr>
                                <td>
                                    <a href="#" class="block-image">
                                        <span class="wrap">
                                            {*<span class="label green">НОВИНКА</span>*}
                                            <span class="image"><img src="{$aCart.image}" alt=""></span>
                                        </span>
                                    </a>
                                    <div class="name">
                                        <a href="/?action=catalog_product&product={$aCart.id_product}">{$aCart.name_translate}</a>
                                        <span class="description">ID: {$aRow.id})&nbsp;(Артикул : {$aRow.code}) (Штрихкод: {$aRow.barcode}) </span>
                                    </div>
                                </td>
                                <td class="count"><div class="thead-m">Цена грн.</div>{$aCart.price|number_format:2:".":" "}</td>
                                <td class="count"><div class="thead-m">Кол-во шт.</div>{$aCart.number}</td>
                                <td class="count"><div class="thead-m">Сумма грн.</div><strong>{$oCurrency->PrintPrice($aCart.price*$aCart.number)}</strong></td>
                         
                            </tr>
                            {/foreach}
                        </table>
                        <div class="block-delivery">
                            <div class="delivery">
                                {*<strong>Доставка:</strong> Днепропетровск, Днепровская набережная 15, кв 335*}
                            </div>
                            <div class="summ">Стоимость доставки: <strong>{$oCurrency->PrintPrice($aRow.price_delivery,1)}</strong></div><br>
                             {if $aRow.bonus>0}
                             <div class="summ">{$oLanguage->getMessage("Bonus")}: <strong>{$oCurrency->PrintPrice($aRow.bonus,1)}</strong></div>
                             <br>
                            {/if}
                        </div>
                      
                        <div class="block-total" onLoad="document.getElementById('redirect').click">
                            <div class="summ">
                                Итого: <strong>{$oCurrency->PrintPrice($aCart.price*$aCart.number)}</strong>
                            </div>


                           
                            {*<a href="https://www.liqpay.com/ru/checkout/card/1491473229160352_6189348_183Dhr0SXtnAwc943And" class="link-repeat"><span class="gm-link-dashed">Оплатить по LiqPay</span></a>*}

                            {*<div id="liqpay_checkout"><a  target="_blank" href="https://www.liqpay.com/ru/checkout/i54276112930">{$oLanguage->getMessage("oplata liqpay")}</a></div>{literal}<script>  window.LiqPayCheckoutCallback = function() {    LiqPayCheckout.init(
                                {      data:"eyAidmVyc2lvbiIgOiAzLCAicHVibGljX2tleSIgOiAieW91cl9wdWJsaWNfa2V5IiwgImFjdGlv" +            "biIgOiAicGF5IiwgImFtb3VudCIgOiAxLCAiY3VycmVuY3kiIDogIlVTRCIsICJkZXNjcmlwdGlv" +            "biIgOiAiZGVzY3JpcHRpb24gdGV4dCIsICJvcmRlcl9pZCIgOiAib3JkZXJfaWRfMSIgfQ==",     signature: "QvJD5u9Fg55PCx/Hdz6lzWtYwcI=",      
                                embedTo: "#liqpay_checkout",      
                                mode: "embed" // embed || popup,       }).on("liqpay.callback", function(data){console.log(data.status);console.log(data);}).on("liqpay.ready", function(data){// ready}).on("liqpay.close", function(data){// close});  
                            };</script>
                                <script src="//static.liqpay.com/libjs/checkout.js" async></script>{/literal*}

                       {* <a href="/?action=liqpay&order_id={$aRow.id}&amount={$aRow.summa_fact}" class="link-repeat"><span class="gm-link-dashed">Оплатить по LiqPay  </span></a>*} 
                        {if $aRow.is_payed=='0' && $aRow.id_payment_type==4 && $sAlreadySent}
                       <a onclick="window.open('/pages/cart_package_list', '_blank');">{$aRow.html}</a>
                       {elseif $aRow.is_payed=='1'}
                       <span class="sale">
                        <a class="button" style="text-decoration:none;">{$oLanguage->getMessage("Already paid")}</a></span>
                        {/if}
{*<form method="post" action="cart_liqpay">
     <table style="border-color: #f9b515; box-shadow: 0 0 0 1px #f9b515;">
         <tr>
            <td>Сумма платежа:</td>
            <td style="text-align: left;"><input type="text" name="amount" value="{$aRow.summa_fact}" required readonly/>&nbsp;&nbsp;UAH</td>
         </tr>
         <tr>
            <td>Назначение платежа:</td>
            <td style="text-align: left;"><input type="text" name="Description" maxlength="200" size="30" /></td>
        </tr>
         <tr>
            <td>Ваш e-mail:</td>
            <td style="text-align: left;"><input type="email" name="SenderMail" maxlength="200" value="{$aRow.email}" size="30" required /></td>
        </tr>

    </table>
     <input type="submit" name="payment-system" value="Оплатить LiqPay" />

</form>*}



                            <div class="clear"></div>
                        </div>
						{if $aRow.customer_comment}
                        <div class="block-comment">
                            <strong>Комментарий:</strong><br />
                            {$aRow.customer_comment}
                        </div>
                        {/if}
                    </div>
                </div>
                {/foreach}
{/if}

                <br />

            </div>
        