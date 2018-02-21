<?php /* Smarty version 2.6.18, created on 2017-05-16 19:40:22
         compiled from manager/row_order_new.tpl */ ?>
                      
                <td class="cell-image">
                    <a href="#" class="block-image">
                        <span class="wrap">
                                                        <span class="image"><img src="<?php echo $this->_tpl_vars['aRow']['image']; ?>
" alt=""></span>
                        </span>
                    </a>
                </td>
                <td class="cell-name">
                    <a target="_blank" href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"><?php echo $this->_tpl_vars['aRow']['name_translate']; ?>
</a>
                    <span>(ID: <?php echo $this->_tpl_vars['aRow']['id_product']; ?>
)&nbsp;(Артикул : <?php echo $this->_tpl_vars['aRow']['code']; ?>
) (Штрихкод: <?php echo $this->_tpl_vars['aRow']['barcode']; ?>
)   &nbsp;&nbsp; <?php echo $this->_tpl_vars['aRow']['cat_name']; ?>
</span>
					</td>
                <td class="cell-price simple">
				    <?php if ($this->_tpl_vars['aRow']['price_parent_margin'] != 0): ?>
						<a id="price_old_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" style="text-decoration: line-through;font-size: 14px;"><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price_original']); ?>
</a>
						<?php else: ?>
						<a> </a>
					<?php endif; ?>
				  <span id="price_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"  
				   <?php if ($this->_tpl_vars['aRow']['price_parent_margin'] != 0): ?> style ="color:#ba0000;font-size: 18px;" <?php endif; ?>><nobr><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
 </nobr></span>
									</td>
                <td class="cell-counter" style="width:40px;height: 40px;border-bottom:1px dashed #b5b5b5;font-size: 18px;">
                        <nobr><?php echo $this->_tpl_vars['aRow']['number']; ?>
&nbsp;<?php echo $this->_tpl_vars['oLanguage']->getMessage("sht."); ?>
</nobr>
                </td>
                <td class="cell-price" id='cart_total_<?php echo $this->_tpl_vars['aRow']['id']; ?>
'>
                <nobr><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['aRow']['total']); ?>
</nobr>
                </td>
                <td class="cell-price_fact" style="width:40px;height: 40px;border-bottom:1px dashed #b5b5b5;font-size: 18px;">
                      
                    <input type="text"  id='cart_<?php echo $this->_tpl_vars['aRow']['id']; ?>
' name='cart[<?php echo $this->_tpl_vars['aRow']['id']; ?>
]' value='<?php echo $this->_tpl_vars['aRow']['price_fact']; ?>
' style="width:70px"
        onKeyUp="xajax_process_browse_url('/?action=manager_update_number_fact&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&price_fact='+this.value);">
                           
                </td>
                <td class="cell-counter" style="width:40px;height: 40px;border-bottom:1px dashed #b5b5b5;font-size: 18px;">
                      <input type="text"  id='cart_num_<?php echo $this->_tpl_vars['aRow']['id']; ?>
' name='cart[<?php echo $this->_tpl_vars['aRow']['id']; ?>
]' value='<?php echo $this->_tpl_vars['aRow']['count_fact']; ?>
' style="width:70px"
        onKeyUp="xajax_process_browse_url('/?action=manager_update_number_fact&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&count_fact='+this.value);">
                </td>
                <td class="cell-price" id='cart_total_fact_<?php echo $this->_tpl_vars['aRow']['id']; ?>
'>
                <nobr><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['aRow']['summa_fact']); ?>
</nobr>
                </td>
                
				 
			
        
			
