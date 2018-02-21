<?php /* Smarty version 2.6.18, created on 2017-05-15 18:52:51
         compiled from cart/subtotal_cart.tpl */ ?>
        <div class="gm-basket-control-line">
            <a href="/pages/cart_cart_clear" class="link-clear"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Clear_cart'); ?>
</span></a>
            <a href="/?action=cart_cart_print" class="link-edit"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage('print_cart'); ?>
</span></a>
            <div class="block-total" >
                <span><?php echo $this->_tpl_vars['oLanguage']->getMessage('Total_sum'); ?>
:</span>
               <div class="block-total" id='cart_subtotal'><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['dSubtotal']); ?>
</div>
            </div>
            <div class="clear"></div>
        </div>