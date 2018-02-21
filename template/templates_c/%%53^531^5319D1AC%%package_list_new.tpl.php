<?php /* Smarty version 2.6.18, created on 2018-02-19 23:24:12
         compiled from cart/package_list_new.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'cart/package_list_new.tpl', 50, false),)), $this); ?>
            <div class="gm-ordermobile-link-filter">
                <a href="#" class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage("Фильтры"); ?>
</a>
            </div>
            

            <div class="gm-order-list">
            <?php if ($this->_tpl_vars['aCartPackage']): ?>
<?php $_from = $this->_tpl_vars['aCartPackage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aRow']):
?>
                <div class="gm-order-element">
                    <div class="head">
                        <div class="toggle js-order-toggle"></div>
                        <div class="name">
                            <strong>№ <?php echo $this->_tpl_vars['aRow']['id']; ?>
</strong>  |  <?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price_total'],1); ?>
  |  <?php echo $this->_tpl_vars['aRow']['date_delivery']; ?>

                            <span class="description"><?php echo $this->_tpl_vars['aRow']['post_date']; ?>
 | <?php echo $this->_tpl_vars['aRow']['delivery_point']; ?>
</span>
                        </div>
                                                <div class="status">
                            <?php echo $this->_tpl_vars['oLanguage']->getOrderStatus($this->_tpl_vars['aRow']['order_status']); ?>

                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="body">
                        <table>
                            <thead>
                                <tr>
                                    <td>Наименование</td>
                                    <td>Цена грн.</td>
                                    <td>Кол-во шт</td>
                                    <td>Сумма грн.</td>
                          
                                </tr>
                            </thead>
                            <?php $_from = $this->_tpl_vars['aRow']['aCart']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aCart']):
?>
                                                        <tr>
                                <td>
                                    <a href="#" class="block-image">
                                        <span class="wrap">
                                                                                        <span class="image"><img src="<?php echo $this->_tpl_vars['aCart']['image']; ?>
" alt=""></span>
                                        </span>
                                    </a>
                                    <div class="name">
                                        <a href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aCart']['id_product']; ?>
"><?php echo $this->_tpl_vars['aCart']['name_translate']; ?>
</a>
                                        <span class="description">ID: <?php echo $this->_tpl_vars['aRow']['id']; ?>
)&nbsp;(Артикул : <?php echo $this->_tpl_vars['aRow']['code']; ?>
) (Штрихкод: <?php echo $this->_tpl_vars['aRow']['barcode']; ?>
) </span>
                                    </div>
                                </td>
                                <td class="count"><div class="thead-m">Цена грн.</div><?php echo ((is_array($_tmp=$this->_tpl_vars['aCart']['price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ' ') : number_format($_tmp, 2, ".", ' ')); ?>
</td>
                                <td class="count"><div class="thead-m">Кол-во шт.</div><?php echo $this->_tpl_vars['aCart']['number']; ?>
</td>
                                <td class="count"><div class="thead-m">Сумма грн.</div><strong><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aCart']['price']*$this->_tpl_vars['aCart']['number']); ?>
</strong></td>
                         
                            </tr>
                            <?php endforeach; endif; unset($_from); ?>
                        </table>
                        <div class="block-delivery">
                            <div class="delivery">
                                                            </div>
                            <div class="summ">Стоимость доставки: <strong><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['price_delivery'],1); ?>
</strong></div><br>
                             <?php if ($this->_tpl_vars['aRow']['bonus'] > 0): ?>
                             <div class="summ"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Bonus'); ?>
: <strong><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aRow']['bonus'],1); ?>
</strong></div>
                             <br>
                            <?php endif; ?>
                        </div>
                      
                        <div class="block-total" onLoad="document.getElementById('redirect').click">
                            <div class="summ">
                                Итого: <strong><?php echo $this->_tpl_vars['oCurrency']->PrintPrice($this->_tpl_vars['aCart']['price']*$this->_tpl_vars['aCart']['number']); ?>
</strong>
                            </div>


                           
                            
                            
                        
                        <?php if ($this->_tpl_vars['aRow']['is_payed'] == '0' && $this->_tpl_vars['aRow']['id_payment_type'] == 4 && $this->_tpl_vars['sAlreadySent']): ?>
                       <a onclick="window.open('/pages/cart_package_list', '_blank');"><?php echo $this->_tpl_vars['aRow']['html']; ?>
</a>
                       <?php elseif ($this->_tpl_vars['aRow']['is_payed'] == '1'): ?>
                       <span class="sale">
                        <a class="button" style="text-decoration:none;"><?php echo $this->_tpl_vars['oLanguage']->getMessage('Already paid'); ?>
</a></span>
                        <?php endif; ?>



                            <div class="clear"></div>
                        </div>
						<?php if ($this->_tpl_vars['aRow']['customer_comment']): ?>
                        <div class="block-comment">
                            <strong>Комментарий:</strong><br />
                            <?php echo $this->_tpl_vars['aRow']['customer_comment']; ?>

                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>

                <br />

            </div>
        