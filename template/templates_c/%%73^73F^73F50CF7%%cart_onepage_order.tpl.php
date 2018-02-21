<?php /* Smarty version 2.6.18, created on 2017-05-15 18:53:00
         compiled from cart/cart_onepage_order.tpl */ ?>
<div class="gm-block-order-legend">
            <div class="legend-wrap">
                <div class="step"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Корзина"); ?>
</div>
                <div class="step selected"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Доставка"); ?>
</div>
                <div class="step"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Оплата"); ?>
</div>
                <div class="clear"></div>
            </div>
        </div>
<?php if (! isset ( $this->_tpl_vars['aUser'] )): ?>
	 <div class="gm-makeorder-auth" style="padding: 0 0 0px 80px;">
            <?php echo $this->_tpl_vars['sCheckLoggedForm']; ?>

            <div class="clear"></div>
            
        </div>
           <div class="gm-makeorder-delivery" id='delivery_new_account' style='display:none'>
        
            <?php echo $this->_tpl_vars['sCheckNewAccountForm']; ?>
<br />
            
            
            <div class="block-button" style='display:none' id='btn_new_account'>
                <a href="javascript:void(0);" class="gm-button" id='continue_cart2'><?php echo $this->_tpl_vars['oLanguage']->getMessage("Продолжить оформление"); ?>
</a>
            </div>
            </div>
	
<?php else: ?>

        <div class="gm-makeorder-delivery">
        
            <?php echo $this->_tpl_vars['sCheckNewAccountForm']; ?>
<br />
            
            </div>
<?php endif; ?>