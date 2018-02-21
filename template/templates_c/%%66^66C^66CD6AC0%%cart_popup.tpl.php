<?php /* Smarty version 2.6.18, created on 2018-02-20 16:25:49
         compiled from catalog/cart_popup.tpl */ ?>

<div id="qiuck_buy_popup" class="reveal-modal">
	<div class="cart_popup_overlay" id="qiuck_buy_popup1"></div>
	<div class="windowBasket" id="qiuck_buy_popup2" >
		
                <div style="color: black;" class="modal-title"><i class="fa fa-shopping-basket"></i><?php echo $this->_tpl_vars['oLanguage']->getMessage('Package_order'); ?>
 
                	<span class="cart-id"></span> 
                    <div class="btn-area"><a id="continue-shopping" class=" btn2 js-continue-shopping" href='' onclick="$('#qiuck_buy_popup1').fadeOut(1); $('#qiuck_buy_popup2').fadeOut(1); $('#qiuck_buy_popup').fadeOut(1); return false;"><i class="icon-back"></i><?php echo $this->_tpl_vars['oLanguage']->GetMessage('continue buying'); ?>
</a>
                    	<span style="display: inline;
    margin: 16%;"><?php echo $this->_tpl_vars['oLanguage']->getMessage('vse tovary sohran v korsine'); ?>
 </span>
                    </div>
                    
                </div>
                
            
	<a href="" onclick="
$('#qiuck_buy_popup1').fadeOut(1);
$('#qiuck_buy_popup2').fadeOut(1);
$('#qiuck_buy_popup').fadeOut(1); return false;" class="close-reveal-modal"></a>

		<div class="basketCurrent">
							</div>

<div class="tableBasket" id="cart_popup_content" >
<?php echo $this->_tpl_vars['sCartPopUpContent']; ?>

</div>
<div class="gm-basket-control-line" style="padding:0;">
<div class="block-total">
<span style="margin-left: 7%;"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('Всього'); ?>
:</span> <div class="block-total2" id="cart_subtotal"><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aTemplateNumber']['cart_total']); ?>
</div></div></div>

	<div class="clear"></div>
	<a href="/?action=cart_cart" class="btn order-package-btn"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Order Package'); ?>
</a>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'cart/order_by_phone.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clear"></div>

	</div>
</div>
