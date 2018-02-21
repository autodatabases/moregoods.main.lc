<?php /* Smarty version 2.6.18, created on 2018-01-13 21:29:49
         compiled from index_include/row_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'index_include/row_list.tpl', 23, false),)), $this); ?>
                                <div class="gm-product-list-element">
                    <div class="block-left">
                        <div class="image"><a  href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['child']['0']['id']; ?>
" id="image_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"><img class="image_cont" src="<?php echo $this->_tpl_vars['oContent']->GetImageThumb($this->_tpl_vars['aRow']['child']['0']['image']); ?>
" alt=""></a></div>
                        <a href="javascript:void(0)" class="link-favorite favorite <?php if ($this->_tpl_vars['aRow']['is_fav']): ?>active<?php endif; ?>" id="fav_<?php echo $this->_tpl_vars['aRow']['child']['0']['id']; ?>
"></a>
                    </div>

                    <div class="block-right">
               <div class="label nocolor" style="padding-left:0;">
							 <?php $_from = $this->_tpl_vars['aRow']['promo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItemP']):
?>
								<?php if ($this->_tpl_vars['aItemP']['i'] == 33): ?><br><?php endif; ?>
								<span href="/?action=promo&promo_id=<?php echo $this->_tpl_vars['aItemP']['ch_id']; ?>
" onmousedown="OnPromoClick('promo_<?php echo $this->_tpl_vars['aItemP']['ch_id']; ?>
'); return false;" id="promo_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_<?php echo $this->_tpl_vars['aItemP']['i']; ?>
" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: <?php echo $this->_tpl_vars['aItemP']['color']; ?>
;"><?php echo $this->_tpl_vars['aItemP']['name']; ?>
</span>
							 <?php endforeach; endif; unset($_from); ?>
			   </div>
                        <div class="price">
						<?php if ($this->_tpl_vars['aRow']['promo']['0']['skidka'] != 0): ?>
							<a id="price_old_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" style="text-decoration: line-through;font-size: 20px;"><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
</a><br>
						<?php else: ?>
							<a> </a>
						<?php endif; ?>
						<span id="price_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"
							<?php if ($this->_tpl_vars['aRow']['promo']['0']['skidka'] != 0): ?> style ="color:#ba0000;" <?php endif; ?>><?php if ($this->_tpl_vars['aRow']['promo']['0']['skidka'] == 0): ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
 <?php else: ?> <?php if ($this->_tpl_vars['aRow']['promo']['0']['id_type_skidka'] == 3): ?> <?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['base_price']*$this->_tpl_vars['aRow']['promo']['0']['skidka']); ?>
 <?php else: ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']*$this->_tpl_vars['aRow']['promo']['0']['skidka']); ?>
  <?php endif; ?><?php endif; ?></span>
                            <span style="font-size:12px;" id="store_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
">(<?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['stock'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%d") : smarty_modifier_string_format($_tmp, "%d")); ?>
 <?php echo $this->_tpl_vars['oLanguage']->getMessage("sht."); ?>
)</span>
                        </div>
                        <div class="button" id="pricemain_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
">
					         <a href="javascript:void(0)" class="gm-button gm-button-buy <?php if ($this->_tpl_vars['aRow']['child']['0']['in_cart']): ?>already<?php endif; ?><?php if ($this->_tpl_vars['aRow']['child']['0']['stock'] < $this->_tpl_vars['aRow']['child']['0']['min_stock']): ?>missing<?php endif; ?>" id="buy_<?php echo $this->_tpl_vars['aRow']['child']['0']['id']; ?>
"><?php if ($this->_tpl_vars['aRow']['child']['0']['in_cart']): ?><?php echo $this->_tpl_vars['oLanguage']->GetMessage('in_cart'); ?>
<?php elseif ($this->_tpl_vars['aRow']['child']['0']['stock'] < $this->_tpl_vars['aRow']['child']['0']['min_stock']): ?><?php echo $this->_tpl_vars['oLanguage']->GetMessage('expected'); ?>
<?php else: ?><?php echo $this->_tpl_vars['oLanguage']->GetMessage('buy'); ?>
 <?php endif; ?></a>
					    </div>
                       <?php if ($this->_tpl_vars['aRow']['select_type'] == 0): ?>
						<div class="options" id="<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
">
						 <?php $_from = $this->_tpl_vars['aRow']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>     
                            <a class="<?php if ($this->_tpl_vars['aItem']['check_'] == 1): ?> selected <?php endif; ?> notselected" id="price2_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_<?php echo $this->_tpl_vars['aItem']['id']; ?>
" discount="<?php echo $this->_tpl_vars['aItem']['kf_discount']; ?>
"
                            	name="<?php echo $this->_tpl_vars['aItem']['price']; ?>
_<?php echo $this->_tpl_vars['aItem']['stock']; ?>
_<?php echo $this->_tpl_vars['aItem']['id']; ?>
_<?php echo $this->_tpl_vars['aItem']['art']; ?>
_<?php echo $this->_tpl_vars['aItem']['barcode']; ?>
_<?php echo $this->_tpl_vars['aItem']['image']; ?>
_<?php echo $this->_tpl_vars['aItem']['min_stock']; ?>
_<?php if ($this->_tpl_vars['aItem']['promo']['0']['skidka'] == 0): ?><?php echo $this->_tpl_vars['aItem']['price']; ?>
<?php else: ?><?php if ($this->_tpl_vars['aItem']['promo']['0']['id_type_skidka'] == 3): ?><?php echo $this->_tpl_vars['aItem']['base_price']*$this->_tpl_vars['aItem']['promo']['0']['skidka']; ?>
<?php else: ?><?php echo $this->_tpl_vars['aItem']['price']*$this->_tpl_vars['aItem']['promo']['0']['skidka']; ?>
<?php endif; ?><?php endif; ?>_<?php echo $this->_tpl_vars['aItem']['in_cart']; ?>
_<?php echo $this->_tpl_vars['aItem']['promo']['0']['name']; ?>
_<?php echo $this->_tpl_vars['aItem']['promo']['0']['color']; ?>
_<?php echo $this->_tpl_vars['aItem']['promo']['1']['name']; ?>
_<?php echo $this->_tpl_vars['aItem']['promo']['1']['color']; ?>
_<?php echo $this->_tpl_vars['aItem']['promo']['2']['name']; ?>
_<?php echo $this->_tpl_vars['aItem']['promo']['2']['color']; ?>
_<?php echo $this->_tpl_vars['aItem']['promo']['3']['name']; ?>
_<?php echo $this->_tpl_vars['aItem']['promo']['3']['color']; ?>
" 
						        onmouseenter="OnPrice2('price_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
',
    						    'price2_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_<?php echo $this->_tpl_vars['aItem']['id']; ?>
','store_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
','code_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
','art_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
',
    						    'barcode_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
', 'image_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
','pricemain_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
', '<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
'); return false;"
    						    ><?php echo $this->_tpl_vars['aItem']['short_name']; ?>
</a>
                         <?php endforeach; endif; unset($_from); ?>
                        </div>
					   <?php else: ?>	
                        <div class="options no-margin">
						    <select class="js-uniform" id="price2_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" onchange="OnPrice('price_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
',
						    'price2_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
','store_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
','code_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
','art_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
',
						    'barcode_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
', 'image_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
','pricemain_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
'); return false;">
						     <?php $_from = $this->_tpl_vars['aRow']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>        
						        <option id="price_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_<?php echo $this->_tpl_vars['aItem']['id']; ?>
"  value="<?php echo $this->_tpl_vars['aItem']['price']; ?>
_<?php echo $this->_tpl_vars['aItem']['stock']; ?>

						        _<?php echo $this->_tpl_vars['aItem']['id']; ?>
_<?php echo $this->_tpl_vars['aItem']['art']; ?>
_<?php echo $this->_tpl_vars['aItem']['barcode']; ?>
_<?php echo $this->_tpl_vars['aItem']['image']; ?>
_<?php echo $this->_tpl_vars['aItem']['min_stock']; ?>
_<?php echo $this->_tpl_vars['aItem']['in_cart']; ?>
"><?php echo $this->_tpl_vars['aItem']['short_name']; ?>
</option>
						     <?php endforeach; endif; unset($_from); ?>
						    </select>
						</div>
                        <?php endif; ?>
                        

                    </div>

                    <div class="block-info">
                        <div class="name">
                            <a  href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['child']['0']['id']; ?>
"><?php echo $this->_tpl_vars['aRow']['name']; ?>
</a>
                        </div>
						<?php echo $this->_tpl_vars['aRow']['short_name']; ?>
<br><br>
                        <span class="code" id="code_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
">(<?php echo $this->_tpl_vars['oLanguage']->getMessage('Code_product'); ?>
: <?php echo $this->_tpl_vars['aRow']['child']['0']['id']; ?>
)</span>&nbsp;
                        <span class="code" id="art_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
">(<?php echo $this->_tpl_vars['oLanguage']->getMessage('articul'); ?>
: <?php echo $this->_tpl_vars['aRow']['child']['0']['art']; ?>
)</span><br>
                        <span class="code" id="barcode_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
">(<?php echo $this->_tpl_vars['oLanguage']->getMessage('barcode'); ?>
: <?php echo $this->_tpl_vars['aRow']['child']['0']['barcode']; ?>
)</span>
						<br>
						<div class="price-before" <?php if ($this->_tpl_vars['aRow']['from_matrica'] == 1): ?>style="color:blue"<?php else: ?>style="color:green"<?php endif; ?>>
						<?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
						<?php if ($this->_tpl_vars['aRow']['discount'] != 0): ?><br>
						<?php echo $this->_tpl_vars['aRow']['discount']*-1.00; ?>
%&nbsp;<?php if ($this->_tpl_vars['aRow']['promo']['0']['id_type_skidka'] == 3): ?>A<?php else: ?>D<?php endif; ?>&nbsp;<?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['base_price']); ?>

						<?php endif; ?>
						<?php endif; ?>
						</div>
						

					</div>
                    <div class="clear"></div>
                </div>
            