<?php /* Smarty version 2.6.18, created on 2018-02-19 22:06:28
         compiled from catalog/info_part.tpl */ ?>
    <link href="/css/colorbox.css" rel="stylesheet" type="text/css" />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "popup.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <div class="gm-product-view info-part">
            <div class="image-block ">
                <div class="image-block">
                <div class="big">
                <div class="line" style="">
                    <ul style="">

                        <li style="">
                            <a class="colorbox cboxElement" href="<?php echo $this->_tpl_vars['aPartInfo']['image']; ?>
">
                                <img src="<?php echo $this->_tpl_vars['aPartInfo']['image']; ?>
" alt="<?php echo $this->_tpl_vars['aPartInfo']['short_name']; ?>
"></a>
                        </li>
                        <li style="">
                            <a class="colorbox cboxElement" href="<?php echo $this->_tpl_vars['aPartInfo']['img']; ?>
">
                                <img src="<?php echo $this->_tpl_vars['aPartInfo']['img']; ?>
" alt="<?php echo $this->_tpl_vars['aPartInfo']['short_name']; ?>
"></a>
                        </li>
                        <li style="">
                            <a class="colorbox cboxElement" href="<?php echo $this->_tpl_vars['aPartInfo']['img2']; ?>
">
                                <img src="<?php echo $this->_tpl_vars['aPartInfo']['img2']; ?>
" alt="<?php echo $this->_tpl_vars['aPartInfo']['short_name']; ?>
"></a>
                        </li>
                    </ul>
                </div></div>


                <div class="control">
                    <a class="colorbox cboxElement" href="<?php echo $this->_tpl_vars['aPartInfo']['image']; ?>
">
                        <span>
                            <img src="<?php echo $this->_tpl_vars['aPartInfo']['image']; ?>
" ></span>
                    </a>
                    <a class="colorbox cboxElement" href="<?php echo $this->_tpl_vars['aPartInfo']['img']; ?>
">
                        <span>
                            <img src="<?php echo $this->_tpl_vars['aPartInfo']['img']; ?>
" >
                        </span>
                    </a>
                    <a class="colorbox cboxElement" href="<?php echo $this->_tpl_vars['aPartInfo']['img2']; ?>
">
                        <span>
                            <img src="<?php echo $this->_tpl_vars['aPartInfo']['img2']; ?>
" >
                        </span>
                    </a>
                </div>                  
                <br>
                </div>
               
            </div>
            <script>$(".colorbox").colorbox({rel:'colorbox',maxWidth:'80%'});</script>
         
    <script src="/js/jquery.colorbox-min.js" type="text/javascript"></script>
	<!-- увелич картинка -->
	
            <div class="block-info">
             	<div class="rating-block">
                                                                                                  </div>
                    <div class="tgp-rating-sub">
						<span style="width: <?php echo $this->_tpl_vars['aRow']['rating_star']; ?>
%"></span>
					</div>
                <div class="name"><?php echo $this->_tpl_vars['aPartInfo']['name']; ?>
</div>
                <div class="code">(<?php echo $this->_tpl_vars['oLanguage']->getMessage('Code_product'); ?>
: <?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
)</div>
                                                <div class="clear"></div>
                <div class="name"><?php echo $this->_tpl_vars['aProductParent']['short_name']; ?>
</div>

                <div class="buy-wrap">
				
               <div class="label nocolor" style="padding-left:0;">
							 <?php $_from = $this->_tpl_vars['aPartInfo']['promo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItemP']):
?>
								<?php if ($this->_tpl_vars['aItemP']['i'] == 33): ?><br><?php endif; ?>
								<span href="/?action=promo&promo_id=<?php echo $this->_tpl_vars['aItemP']['ch_id']; ?>
" onmousedown="OnPromoClick('promo_<?php echo $this->_tpl_vars['aItemP']['ch_id']; ?>
'); return false;" id="promo_<?php echo $this->_tpl_vars['aItemP']['id_product']; ?>
_<?php echo $this->_tpl_vars['aItemP']['i']; ?>
" style="line-height: 22px;padding: 0 5px; border-radius: 5px 5px 0 5px;background-color: <?php echo $this->_tpl_vars['aItemP']['color']; ?>
;"><?php echo $this->_tpl_vars['aItemP']['name']; ?>
</span>
							 <?php endforeach; endif; unset($_from); ?>
			   </div>
					
                    <div class="wrap-favorite">
                        <a href="javascript:void(0);" id='fav_<?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
' class="link-favorite <?php if ($this->_tpl_vars['aPartInfo']['is_fav']): ?>active<?php endif; ?>"></a>
                    </div>

                    <form method="post" onsubmit="Cart.addToCart(this); return false;"  >
                    <div class="price">
				    <?php if ($this->_tpl_vars['aPartInfo']['promo']['0']['skidka'] != 0): ?>
						<a id="price_old_<?php echo $this->_tpl_vars['aPartInfo']['id_product']; ?>
" style="text-decoration: line-through;font-size: 24px;"><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aPartInfo']['price']); ?>
</a>
						<?php else: ?>
						<a> </a>
					<?php endif; ?>
                        <strong>
				   <span id="price_<?php echo $this->_tpl_vars['aPartInfo']['id_product']; ?>
"  
				   <?php if ($this->_tpl_vars['aPartInfo']['promo']['0']['skidka'] != 0): ?> style ="color:#ba0000;" <?php endif; ?>><?php if ($this->_tpl_vars['aPartInfo']['promo']['0']['skidka'] == 0): ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aPartInfo']['price']); ?>
 <?php else: ?> <?php if ($this->_tpl_vars['aPartInfo']['promo']['0']['id_type_skidka'] == 3): ?> <?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aPartInfo']['base_price']*$this->_tpl_vars['aPartInfo']['promo']['0']['skidka']); ?>
<?php else: ?><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aPartInfo']['price']*$this->_tpl_vars['aPartInfo']['promo']['0']['skidka']); ?>
  <?php endif; ?><?php endif; ?></span>
                                                    </strong>
                    </div>
                   
                         <div class="options">
                                                   </div>       
	                        
                  
                        
                        <div data-role="buy" class="item-prices" style="display: block;">

                            <div style="text-align: center;"> 
                               <input type='hidden' name='r[<?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
]' id='id_product_<?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
' value=''>
								<span id='add_link_<?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
'>
					<?php $this->assign('aRow', $this->_tpl_vars['aPartInfo']); ?>
                    <input type=text name ="n[<?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
]" id='number_<?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
' style="width:90px;" value="<?php if ($this->_tpl_vars['aPartInfo']['request_number']): ?><?php echo $this->_tpl_vars['aPartInfo']['request_number']; ?>
<?php else: ?>1<?php endif; ?>">

     
<span  id='add_link_<?php echo $this->_tpl_vars['aPartInfo']['id']; ?>
'>
<?php if ($this->_tpl_vars['aPartInfo']['stock'] >= $this->_tpl_vars['aRow']['min_stock']): ?>
<a href="javascript:;"
onclick="<?php echo 'xajax_process_browse_url(\'/?action=cart_add_cart_item&xajax_request=1&id_product='; ?><?php echo $this->_tpl_vars['aPartInfo']['id']; ?><?php echo '&link_id=add_link_'; ?><?php echo $this->_tpl_vars['aPartInfo']['id']; ?><?php echo '&number=\'+document.getElementById(\'number_'; ?><?php echo $this->_tpl_vars['aPartInfo']['id']; ?><?php echo '\').value);oCart.AnimateAdd(this);$(\'#qiuck_buy_popup\').fadeIn(1);$(\'#qiuck_buy_popup1\').fadeIn(1);$(\'#qiuck_buy_popup2\').fadeIn(1);return false;'; ?>
">
<?php endif; ?>
<button type="submit" class="btn btn-sm btn-primary <?php if ($this->_tpl_vars['aPartInfo']['stock'] < $this->_tpl_vars['aRow']['min_stock']): ?>missing<?php endif; ?>">
<?php if ($this->_tpl_vars['aPartInfo']['stock'] < $this->_tpl_vars['aRow']['min_stock']): ?><?php echo $this->_tpl_vars['oLanguage']->getMessage('isnot_store'); ?>

<?php else: ?><?php echo $this->_tpl_vars['oLanguage']->getMessage('buy'); ?>


<?php endif; ?>
</button>
</a>
</span>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
     <?php echo '
<script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement(\'script\'), g = \'getElementsByTagName\';
    s.type = \'text/javascript\'; s.charset=\'UTF-8\'; s.async = true;
    s.src = (\'https:\' == w.location.protocol ? \'https\' : \'http\')  + \'://w.uptolike.com/widgets/v1/uptolike.js\';
    var h=d[g](\'body\')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div style="    width: 200px;
    margin-left: 51%;" data-mobile-view="true" data-share-size="30" data-like-text-enable="false" data-background-alpha="0.0" data-pid="1741082" data-mode="share" data-background-color="#ffffff" data-share-shape="round-rectangle" data-share-counter-size="12" data-icon-color="#ffffff" data-mobile-sn-ids="fb.vk.tw.ok.wh.vb.tm." data-text-color="#000000" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-type="disable" data-orientation="horizontal" data-following-enable="false" data-sn-ids="fb.vk.tm.ps." data-preview-mobile="false" data-selection-enable="true" data-exclude-show-more="false" data-share-style="1" data-counter-background-alpha="1.0" data-top-button="false" class="uptolike-buttons" ></div> 
                <style>
                    .horizontal{
                        margin-left: 36px !important; 
                    }
                </style>
                '; ?>

                
                
                                
                <div class="product-terms fordesk" style="float: right;">
                    <hr>
                    <div class="product-term-box ">
                        <div class="term-title"><i class="fa fa-car" aria-hidden="true"></i>
                            <?php echo $this->_tpl_vars['oLanguage']->getMessage('Delivery'); ?>
</div>
                        <?php $_from = $this->_tpl_vars['aDelivery']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sDelivery']):
?>
                        <div class="product-term" <?php if ($this->_tpl_vars['aAuthUser']['id_customer_group'] != '28' && $this->_tpl_vars['sDelivery']['id'] == '1'): ?> style="display:none;"<?php endif; ?>><div class="name"><?php echo $this->_tpl_vars['sDelivery']['name']; ?>
</div>
                            <div class="desc">
                                   <?php echo $this->_tpl_vars['sDelivery']['description']; ?>

                            </div>
                        </div>
                        <br>
                        <?php endforeach; endif; unset($_from); ?>
                    </div>

                    <div class="product-term-box">
                        <div class="term-title"><i class="fa fa-usd" aria-hidden="true"></i>
                            <?php echo $this->_tpl_vars['oLanguage']->getMessage('Oplata'); ?>

                        </div>
                        <?php $_from = $this->_tpl_vars['aOplata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sOplata']):
?>
                        <div class="product-term">
                            <div class="name"><?php echo $this->_tpl_vars['sOplata']['name']; ?>
</div>
                                <div class="desc"><?php echo $this->_tpl_vars['sOplata']['description']; ?>
</div>
                        </div>
                        <br>
                        <?php endforeach; endif; unset($_from); ?>
                    </div>
                    <br>
            </div>
                
             </div>

            <div class="clear"></div>

                    </div>
   
<script type="text/javascript" src="/js/cart.js"></script>  


    
   
   
   
   
   
   
   
   
   
   
   