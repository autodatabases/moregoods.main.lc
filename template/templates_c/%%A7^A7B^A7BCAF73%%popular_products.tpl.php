<?php /* Smarty version 2.6.18, created on 2018-02-20 11:54:25
         compiled from index_include/popular_products.tpl */ ?>
<?php if ($this->_tpl_vars['aPopularProducts']): ?>
<div class="gm-mainer">
    <h2 class="line-through"   style="margin:0 0 0 0;"></h2>

    <div class="gm-product-carousel js-product-carousel">
        <div class="wrapper">
        <?php $_from = $this->_tpl_vars['aPopularProducts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aRow']):
?>
            <div>
 			 <script type="text/javascript" src="/js/cart.js"></script>     
<div class="gm-product-thumb-element">
               <div class="element-wrap" style="border: 1px dotted #666;
    padding: 10px;">
               <div class="label nocolor" style="padding-left:0;">
                <?php if (! $this->_tpl_vars['aRow']['promo']): ?>
                    <span id="promo_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_1" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: '';"></span>
                    <span id="promo_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_2" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: '';"></span>
                    <span id="promo_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_3" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: '';"></span>
                    <span id="promo_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_4" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: '';"></span>
                
                <?php else: ?>
                             <?php $_from = $this->_tpl_vars['aRow']['promo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItemP']):
?>
                                <?php if ($this->_tpl_vars['aItemP']['i'] == 3): ?><br><?php endif; ?><span id="promo_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
_<?php echo $this->_tpl_vars['aItemP']['i']; ?>
" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: <?php echo $this->_tpl_vars['aItemP']['color']; ?>
;"><?php echo $this->_tpl_vars['aItemP']['name']; ?>
</span>
                             <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>            
               </div>
                   <a href="javascript:void(0)" class="link-favorite <?php if ($this->_tpl_vars['aRow']['is_fav']): ?>active<?php endif; ?>" id="fav_<?php echo $this->_tpl_vars['aRow']['id']; ?>
"></a>
                   <div class="image"><a  href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['id']; ?>
" id="image_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"><img class="image_cont" src="<?php echo $this->_tpl_vars['aRow']['image']; ?>
" alt="<?php echo $this->_tpl_vars['aRow']['name']; ?>
"></a></div>
                   <div class="name"><a  href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['id']; ?>
"><?php echo $this->_tpl_vars['aRow']['name']; ?>
</a></div>
                                       <div class="button" id="pricemain_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" style="margin-bottom: 10px;">
                             <a href="javascript:void(0)" class="gm-button gm-button-buy <?php if ($this->_tpl_vars['aRow']['in_cart']): ?>already<?php endif; ?><?php if ($this->_tpl_vars['aRow']['stock'] < $this->_tpl_vars['aRow']['min_stock']): ?>missing<?php endif; ?>" id="buy_<?php echo $this->_tpl_vars['aRow']['id']; ?>
">
                                <?php if ($this->_tpl_vars['aRow']['in_cart']): ?><?php echo $this->_tpl_vars['oLanguage']->GetMessage('in_cart'); ?>
<?php elseif ($this->_tpl_vars['aRow']['stock'] < $this->_tpl_vars['aRow']['min_stock']): ?><?php echo $this->_tpl_vars['oLanguage']->GetMessage('expected'); ?>
<?php else: ?><?php echo $this->_tpl_vars['oLanguage']->GetMessage('buy'); ?>
 <?php endif; ?></a>
                        </div>
                   <div class="price-before" <?php if ($this->_tpl_vars['aRow']['from_matrica'] == 1): ?>style="color:blue"<?php else: ?>style="color:green"<?php endif; ?>>
                   <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
                   <?php if ($this->_tpl_vars['aRow']['discount'] != 0): ?>
                    <?php echo $this->_tpl_vars['aRow']['discount']*-1.00; ?>
%&nbsp;<?php if ($this->_tpl_vars['aRow']['promo']['0']['id_type_skidka'] == 3): ?>A<?php else: ?>D<?php endif; ?>&nbsp;<?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['base_price']); ?>

                    <?php endif; ?>
                   <?php endif; ?>
                                       </div>
                   <div class="price">
                                            <a id="price_old_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" style="text-decoration: line-through;font-size: 14px;"><?php if ($this->_tpl_vars['aRow']['promo']['0']['skidka'] != 0): ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
<?php endif; ?></a>
                                                                                       <span id="price_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"  
                   <?php if ($this->_tpl_vars['aRow']['promo']['0']['skidka'] != 0): ?> style ="color:#ba0000;font-size: 20px;" <?php endif; ?>><?php if ($this->_tpl_vars['aRow']['promo']['0']['skidka'] == 0): ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']); ?>
 <?php else: ?> 
                   
                   <?php if ($this->_tpl_vars['aRow']['promo']['0']['id_type_skidka'] == 3): ?> <?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['base_price']*$this->_tpl_vars['aRow']['promo']['0']['skidka']); ?>
  <?php else: ?> <?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price']*$this->_tpl_vars['aRow']['promo']['0']['skidka']); ?>
  <?php endif; ?>

                     

                   
                   <?php endif; ?></span>
                   </div>
                   </div>
             


				
            </div>
        <?php endforeach; endif; unset($_from); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Популярные товары на главной -->
<!-- End Популярные товары на главной -->