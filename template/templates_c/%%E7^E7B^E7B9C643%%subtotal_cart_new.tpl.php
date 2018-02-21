<?php /* Smarty version 2.6.18, created on 2017-07-04 00:12:19
         compiled from manager/subtotal_cart_new.tpl */ ?>
    <?php if (! $this->_tpl_vars['aRow']['is_payed'] && ! $this->_tpl_vars['sAlreadySent']): ?>
    <a href="/?action=manager_send_bill_liqpay&id=<?php echo $this->_tpl_vars['aRow']['id_cart_package']; ?>
&id_user=<?php echo $this->_tpl_vars['aRow']['id_user']; ?>
" 

    class="link-edit"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage('For paying to customer'); ?>
</span></a> &nbsp;&nbsp;
    <?php else: ?>
    <a href="/?action=manager_send_bill_liqpay&id=<?php echo $this->_tpl_vars['aRow']['id_cart_package']; ?>
&id_user=<?php echo $this->_tpl_vars['aRow']['id_user']; ?>
" 

    class="link-edit"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage('letter already sent'); ?>
</span></a> &nbsp;&nbsp;
    <?php endif; ?>
     <a href="/?action=manager_copy_fact&id=<?php echo $this->_tpl_vars['aRow']['id_cart_package']; ?>
" class="link-edit"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Copy all to fact'); ?>
</span></a>


        
        <div class="gm-basket-control-line">
            <a href="/?action=manager_order_print&id=<?php echo $this->_tpl_vars['aRow']['id_cart_package']; ?>
&id_user=<?php echo $this->_tpl_vars['aRow']['id_user']; ?>
" class="link-edit"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage('print_cart'); ?>
</span></a>
            <div class="block-total" >
                <span><?php echo $this->_tpl_vars['oLanguage']->getMessage('Total_sum'); ?>
:</span>
            <?php if ($this->_tpl_vars['aData']['summa_fact'] != 0): ?>
			 <div class="block-total" id='cart_subtotal_fact'><?php echo $this->_tpl_vars['aData']['summa_fact']-$this->_tpl_vars['aData']['bonus']; ?>
<?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['dSubtotal']); ?>
</div>
            <?php else: ?>
             <div class="block-total" id='cart_subtotal'><?php echo $this->_tpl_vars['aData']['price_total']-$this->_tpl_vars['aData']['bonus']; ?>
<?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['dSubtotal']); ?>
</div>
        	<?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>