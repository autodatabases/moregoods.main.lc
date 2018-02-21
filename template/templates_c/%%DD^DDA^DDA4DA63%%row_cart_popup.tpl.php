<?php /* Smarty version 2.6.18, created on 2017-05-15 18:46:27
         compiled from cart/row_cart_popup.tpl */ ?>
 <hr>
    <div class="gm-product-line-element" >
 		<div class="cell-image" style="     width: 105px;
    height: 78px;  text-align: -webkit-center;" >
			
				<img src="<?php echo $this->_tpl_vars['aRow']['image']; ?>
" alt="<?php echo $this->_tpl_vars['aRow']['name']; ?>
" style="max-height: 100px; max-width: 110px;
    ">
			
		</div>
<div class="cell-name" style="width: 0;">
	<a target="_blank" href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"><?php echo $this->_tpl_vars['aRow']['name_translate']; ?>
</a>
</div>

<div class="cell-price simple">
		    <?php if ($this->_tpl_vars['aRow']['price_parent_margin'] != 0): ?>
				<a id="price_old_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" style="text-decoration: line-through;font-size: 14px;"><nobr><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price_original']); ?>
</nobr></a>
				<?php else: ?>
				<a> </a>
			<?php endif; ?>
		  <span id="price_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"  
		   <?php if ($this->_tpl_vars['aRow']['price_parent_margin'] != 0): ?> style ="color:#ba0000;font-size: 18px;" <?php endif; ?>><nobr><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
</nobr> </span>
</div>

<div class="cell-price" style="padding: 0;">
    
        <input  type="text" id='cart_<?php echo $this->_tpl_vars['aRow']['id']; ?>
' name='cart[<?php echo $this->_tpl_vars['aRow']['id']; ?>
]' value='<?php echo $this->_tpl_vars['aRow']['number']; ?>
'style="height: 30px; width: 70px;"
maxlength=7 onKeyUp="xajax_process_browse_url('?action=cart_cart_update_number&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
&number='+this.value);">
    
 </div>

<div class="cell-price" id='cart_total_<?php echo $this->_tpl_vars['aRow']['id']; ?>
' style="padding: 0;">
				<nobr><?php echo $this->_tpl_vars['oCurrency']->PrintSymbol($this->_tpl_vars['aRow']['total']); ?>
</nobr>
</div>
<div class="cell-remove cell-price" style="text-align:center; width: 50px; padding: 0;">
                    <a class="gm-icon-remove" href="#"
	onclick="if (!confirm('<?php echo $this->_tpl_vars['oLanguage']->getMessage("Are you sure you want to delete this item?"); ?>
')) { return false; } else { xajax_process_browse_url('?action=cart_cart_delete&id=<?php echo $this->_tpl_vars['aRow']['id']; ?>
'); return false;}"
	></a>                
</div>
</div>