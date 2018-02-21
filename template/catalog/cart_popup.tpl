
<div id="qiuck_buy_popup" class="reveal-modal">
	<div class="cart_popup_overlay" id="qiuck_buy_popup1"></div>
	<div class="windowBasket" id="qiuck_buy_popup2" >
		
                <div style="color: black;" class="modal-title"><i class="fa fa-shopping-basket"></i>{$oLanguage->getMessage("Package_order")} 
                	<span class="cart-id"></span> 
                    <div class="btn-area"><a id="continue-shopping" class=" btn2 js-continue-shopping" href='' onclick="$('#qiuck_buy_popup1').fadeOut(1); $('#qiuck_buy_popup2').fadeOut(1); $('#qiuck_buy_popup').fadeOut(1); return false;"><i class="icon-back"></i>{$oLanguage->GetMessage('continue buying')}</a>
                    	<span style="display: inline;
    margin: 16%;">{$oLanguage->getMessage("vse tovary sohran v korsine")} </span>
                    </div>
                    
                </div>
                
            
	<a href="" onclick="
$('#qiuck_buy_popup1').fadeOut(1);
$('#qiuck_buy_popup2').fadeOut(1);
$('#qiuck_buy_popup').fadeOut(1); return false;" class="close-reveal-modal"></a>

		<div class="basketCurrent">
				{*<p>Отображать цены в:</p>
				<div class="currencyCont2">
					<a href="#">UAH</a>
					<div class="currencyOpen2">
						<ul>
							<li>UAH</li>
							<li>USD</li>
							<li>EUR</li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>*}
			</div>

<div class="tableBasket" id="cart_popup_content" >
{$sCartPopUpContent}
</div>
<div class="gm-basket-control-line" style="padding:0;">
<div class="block-total">
<span style="margin-left: 7%;">{$oLanguage->GetMessage('Всього')}:</span> <div class="block-total2" id="cart_subtotal">{$oCurrency->PrintPrice($aTemplateNumber.cart_total)}</div></div></div>

	<div class="clear"></div>
	<a href="/?action=cart_cart" class="btn order-package-btn">{$oLanguage->getMessage("Order Package")}</a>
	{*<a href='' onclick="$('#qiuck_buy_popup1').fadeOut(1); $('#qiuck_buy_popup2').fadeOut(1); $('#qiuck_buy_popup').fadeOut(1); return false;" class="btn order-package-btn">{$oLanguage->GetMessage('continue buying')}</a>*}
	{include file='cart/order_by_phone.tpl'}
	<div class="clear"></div>

	</div>
</div>

{*
<div class="windowBasket">
			
			<div class="basketCurrent">
				<p>Отображать цены в:</p>
				<div class="currencyCont2">
					<a href="#">UAH</a>
					<div class="currencyOpen2">
						<ul>
							<li>UAH</li>
							<li>USD</li>
							<li>EUR</li>
						</ul>
					</div>
				</div>
				<div  class="clear"></div>
			</div>
			<div class="tableBasket">
				<table cellpadding="0" cellspacing="0">
					<tr class="head">
						<td><p>#</p></td>
						<td><p>Бренд</p></td>
						<td><p>Код товара</p></td>
						<td><p>Наименование</p></td>
						<td><p>Срок</p></td>
						<td><p>Цена</p></td>
						<td><p>Кол-во</p></td>
						<td><p>Сумма</p></td>
						<td><div class="blockWithPrompt"><a href="#"><img src="img/remove_from_basket.jpg"   alt="" border="0px" /></a><div class="openPrompt"><div class="openPromptCont">Очистить корзину товаров<div class="openPromptBottom"></div></div></div></div></td>
					</tr>
					<tr>
						<td><p>1</p></td>
						<td><p>toyota</p></td>
						<td><p>pz451-j0990-za</p></td>
						<td><p>Интерфейс подключения iPod</p></td>
						<td><p class="st_1">14 дн.</p></td>
						<td><p>575</p></td>
						<td><input  type="text"  value="1" onfocus="if(this.value=='1'){this.value=''}" onblur="if(this.value==''){this.value='1'}"/></td>
						<td><p>575</p></td>
						<td><div class="blockWithPrompt"><a href="#"><img src="img/remove_from_basket.jpg"   alt="" border="0px" /></a><div class="openPrompt"><div class="openPromptCont">Удалить товар из корзины<div class="openPromptBottom"></div></div></div></div></td>
					</tr>		
					<tr>
						<td><p>2</p></td>
						<td><p>toyota</p></td>
						<td><p>pz451-j0990-za</p></td>
						<td><p>Мультимедиа DVD-система</p></td>
						<td><p class="st_1">4 дн.</p></td>
						<td><p>375</p></td>
						<td><input  type="text"  value="1" onfocus="if(this.value=='1'){this.value=''}" onblur="if(this.value==''){this.value='1'}"/></td>
						<td><p>375</p></td>
						<td><div class="blockWithPrompt"><a href="#"><img src="img/remove_from_basket.jpg"   alt="" border="0px" /></a><div class="openPrompt"><div class="openPromptCont">Удалить товар из корзины<div class="openPromptBottom"></div></div></div></div></td>
					</tr>		
					<tr>
						<td><p>3</p></td>
						<td><p>toyota</p></td>
						<td><p>pz451-j0990-za</p></td>
						<td><p>Стикеры JBL класса “премиум”</p></td>
						<td><p class="st_1">1 дн.</p></td>
						<td><p>10 400</p></td>
						<td><input  type="text"  value="1" onfocus="if(this.value=='1'){this.value=''}" onblur="if(this.value==''){this.value='1'}"/></td>
						<td><p>10 400</p></td>
						<td><div class="blockWithPrompt"><a href="#"><img src="img/remove_from_basket.jpg"   alt="" border="0px" /></a><div class="openPrompt"><div class="openPromptCont">Удалить товар из корзины<div class="openPromptBottom"></div></div></div></div></td>
					</tr>
					<tr>
						<td><p>3</p></td>
						<td><p>toyota</p></td>
						<td><p>pz451-j0990-za</p></td>
						<td><p>Комплект для установки iPod в бардачок</p></td>
						<td><p class="st_1">14 дн.</p></td>
						<td><p>1 320</p></td>
						<td><input  type="text"  value="1" onfocus="if(this.value=='1'){this.value=''}" onblur="if(this.value==''){this.value='1'}"/></td>
						<td><p>1 320</p></td>
						<td><div class="blockWithPrompt"><a href="#"><img src="img/remove_from_basket.jpg"   alt="" border="0px" /></a><div class="openPrompt"><div class="openPromptCont">Удалить товар из корзины<div class="openPromptBottom"></div></div></div></div></td>
					</tr>				
				</table>				
			</div>
			<p class="summ">Итого: <span>
				12 670 $</span></p>
			<div class="clear"></div>
			<a href="#" class="button">оформить заказ</a>
			<a href="#" class="button">продолжить покупки</a>
			<div class="clear"></div>
		</div>*}