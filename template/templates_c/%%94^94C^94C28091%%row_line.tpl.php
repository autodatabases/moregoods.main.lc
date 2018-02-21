<?php /* Smarty version 2.6.18, created on 2018-01-13 21:28:38
         compiled from index_include/row_line.tpl */ ?>
                <div class="gm-product-line-element">
                    <div class="cell-image">
                        <a href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" class="block-image">
                            <span class="wrap">
                                                                <span class="image"><img src="<?php echo $this->_tpl_vars['oContent']->GetImageThumb($this->_tpl_vars['aRow']['image']); ?>
" alt=""></span>
                            </span>
                        </a>
                    </div>
                                        <div class="cell-name">
                        <a  href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"><?php echo $this->_tpl_vars['aRow']['name']; ?>
[<?php echo $this->_tpl_vars['aRow']['short_name']; ?>
]</a>
						<div class="label nocolor" style="padding-left:0;">
							 <?php $_from = $this->_tpl_vars['aRow']['promo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItemP']):
?>
							<span  id="promo_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_<?php echo $this->_tpl_vars['aItemP']['i']; ?>
" style="
							font-size: 14px;  
							font-weight: bold;
							color: #ffffff;  
							top: -10px;  left: -10px;
							float: left;
							line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: <?php echo $this->_tpl_vars['aItemP']['color']; ?>
;
									"><?php echo $this->_tpl_vars['aItemP']['name']; ?>
</span>
							 <?php endforeach; endif; unset($_from); ?>
						</div>
                        <span>(<?php echo $this->_tpl_vars['oLanguage']->getMessage('code_product'); ?>
: <?php echo $this->_tpl_vars['aRow']['id']; ?>
) &nbsp; (<?php echo $this->_tpl_vars['oLanguage']->getMessage('barcode'); ?>
: <?php echo $this->_tpl_vars['aRow']['barcode']; ?>
)
                        &nbsp; (<?php echo $this->_tpl_vars['oLanguage']->getMessage('articul'); ?>
: <?php echo $this->_tpl_vars['aRow']['art']; ?>
)</span>
                    </div>
                    <div class="cell-favorite">
                        <a href="javascript:void(0)" class="link-favorite <?php if ($this->_tpl_vars['aRow']['is_fav']): ?>active<?php endif; ?>" id="fav_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" ></a>
                    </div>
                    <div class="cell-price" style="font-size:17px">
				    <?php if ($this->_tpl_vars['aRow']['promo']['0']['skidka'] != 0): ?>
						<a id="price_old_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" style="text-decoration: line-through;font-size: 14px;"><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
</a>
						<?php else: ?>
						<a> </a>
					<?php endif; ?>
				   <span<?php if ($this->_tpl_vars['aRow']['promo']['0']['skidka'] != 0): ?> style ="color:#ba0000;font-size: 17px;" <?php endif; ?>><?php if ($this->_tpl_vars['aRow']['promo']['0']['skidka'] == 0): ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
 <?php else: ?> <?php if ($this->_tpl_vars['aRow']['promo']['0']['id_type_skidka'] == 3): ?> <?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['base_price']*$this->_tpl_vars['aRow']['promo']['0']['skidka']); ?>
  <?php else: ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']*$this->_tpl_vars['aRow']['promo']['0']['skidka']); ?>
  <?php endif; ?><?php endif; ?></span>
                    </div>
                    <div class="cell-price" style="font-size:14px;text-align: right;">
                        <?php echo $this->_tpl_vars['aRow']['stock']; ?>
&nbsp;<?php echo $this->_tpl_vars['oLanguage']->getMessage("sht."); ?>

                    </div>
                    <div class="cell-counter line">
                        <div class="gm-block-counter js-block-count">
                            <span class="plus"></span>
                            <span class="minus"></span>
                            <input class="count" type="text" value="<?php if ($this->_tpl_vars['aRow']['in_cart']): ?><?php echo $this->_tpl_vars['aRow']['in_cart']; ?>
<?php else: ?><?php endif; ?>">
                        </div>
                    </div>
                    <div class="cell-button">
			            <a href="javascript:void(0)" class="gm-icon-buy <?php if ($this->_tpl_vars['aRow']['in_cart']): ?>already<?php endif; ?><?php if ($this->_tpl_vars['aRow']['stock'] < $this->_tpl_vars['aRow']['min_stock']): ?>missing<?php endif; ?>" id="buy_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"></a>
                    </div>
                </div>