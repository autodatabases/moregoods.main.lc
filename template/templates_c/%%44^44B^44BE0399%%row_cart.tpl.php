<?php /* Smarty version 2.6.18, created on 2018-02-19 22:46:45
         compiled from cart/row_cart.tpl */ ?>
            <hr>
            <div class="gm-product-line-element">
                <div class="cell-image">
                    <a href="#" class="block-image">
                        <span class="wrap">
                                                        <span class="image"><img src="<?php echo $this->_tpl_vars['aRow']['image']; ?>
" alt=""></span>
                        </span>
                    </a>
                </div>
                <div class="cell-name">
                    <a target="_blank" href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"><?php echo $this->_tpl_vars['aRow']['name_translate']; ?>
</a>
                    <span>(Код: <?php echo $this->_tpl_vars['aRow']['id_product']; ?>
)<br> Время добавления: <?php echo $this->_tpl_vars['aRow']['post_date']; ?>
                 </div>
                <div class="cell-price simple">
				    <?php if ($this->_tpl_vars['aRow']['price_parent_margin'] != 0): ?>
						<a id="price_old_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" style="text-decoration: line-through;font-size: 14px;"><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price_original']); ?>
</a>
						<?php else: ?>
						<a> </a>
					<?php endif; ?>
				  <span id="price_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"  
				   <?php if ($this->_tpl_vars['aRow']['price_parent_margin'] != 0): ?> style ="color:#ba0000;font-size: 18px;" <?php endif; ?>><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
 </span>

				</div>
                <div class="cell-counter">
                    <div class="gm-block-counter js-block-count">
                        <span class="plus"></span>
                        <span class="minus"></span>
                        <input class="count" type="text" id='cart_<?php echo $this->_tpl_vars['aRow']['id']; ?>
' name='cart[<?php echo $this->_tpl_vars['aRow']['id']; ?>
]' value='<?php echo $this->_tpl_vars['aRow']['number']; ?>
'
		maxlength=3 onKeyUp="xajax_process_browse_url('?action=cart_cart_update_number&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&number='+this.value);">
                    </div>
                </div>
                <div class="cell-price" id='cart_total_<?php echo $this->_tpl_vars['aRow']['id']; ?>
'>
				<nobr><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['aRow']['total']); ?>
</nobr>
                </div>
                <div class="cell-remove">
                    <a href="/?action=cart_cart_delete&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
" onclick="if (!confirm('<?php echo $this->_tpl_vars['oLanguage']->getMessage("Are you sure you want to delete this item?"); ?>
')) return false;" class="gm-icon-remove"></a>
                </div>
            </div>
