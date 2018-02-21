<?php /* Smarty version 2.6.18, created on 2018-02-19 23:27:29
         compiled from favourites/row_favourites.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'round', 'favourites/row_favourites.tpl', 28, false),)), $this); ?>
<hr>
<div class="gm-product-line-element">
    <div class="cell-check">
        <input type="checkbox">
    </div>
    <div class="cell-image">
        <a href="#" class="block-image">
            <span class="wrap">
<span class="image"><img src="<?php echo $this->_tpl_vars['aRow']['image']; ?>
" alt=""></span>
            </span>
        </a>
    </div>
    <div class="cell-name">
        <a href="/?action=catalog_product&product=<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"><?php echo $this->_tpl_vars['aRow']['name']; ?>
</a>
        <span>(Код товара: <?php echo $this->_tpl_vars['aRow']['id_product']; ?>
) </span>
    </div>
    <div class="cell-favorite">
        <a href="javascript:void(0)" id="fav_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
" class="link-favorite active"></a>
    </div>
    <div class="cell-price"><?php echo ((is_array($_tmp=$this->_tpl_vars['aRow']['price'])) ? $this->_run_mod_handler('round', true, $_tmp, 2) : round($_tmp, 2)); ?>
 грн</div>
    <div class="cell-counter">
        <div class="gm-block-counter js-block-count">
            <span class="plus"></span>
            <span class="minus"></span>
            <input class="count" type="text" value="1">
        </div>
    </div>
    <div class="cell-button">
        <a href="javascript:void(0)" class="gm-icon-buy" id="buy_<?php echo $this->_tpl_vars['aRow']['id_product']; ?>
"></a>
    </div>
</div>