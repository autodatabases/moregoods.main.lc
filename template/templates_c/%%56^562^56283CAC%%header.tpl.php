<?php /* Smarty version 2.6.18, created on 2018-02-19 23:33:24
         compiled from index_include/header.tpl */ ?>
                     <script>
                     $('body').removeClass().addClass('<?php echo $this->_tpl_vars['sClassBrand']; ?>
');
                     </script>
                     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "catalog/cart_popup.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="gm-block-brand-color"></div>

<div class="gm-block-preheader">
    <div class="gm-mainer">
    
                                <div class="block-phones"  id ="block-phones" style="float: right; font-size: 30px;"><i class="fa fa-phone-square" aria-hidden="true"></i>
                            <?php echo $this->_tpl_vars['oLanguage']->GetConstant('global:project_phone'); ?>

        </div>

        <span class="top_links"><?php echo $this->_tpl_vars['oLanguage']->GetText('top_links'); ?>
</span>

        <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'customer'): ?>
            <?php echo '<style>
                .chosen-drop{
                    display:none;
                }
            </style>'; ?>

        <?php endif; ?>
        <div class="clear"></div>
    </div>
</div>

<header class="gm-block-header">
    <div class="gm-mainer">
        <div class="block-logo"><a href="/"><img src="/image/_images/logo2.png" alt="" width=120 height= 120></a>
        </div>
        <div class="block-toggle js-block-left-curtain-toggle"></div>
        	<div class="words" id="wrap1"><h2  style="margin-bottom: 26px;"><a class="mainlog" href="/">Роспись футболок акрилом</a></h2>
                <h6><em><center>(сделано с душой)</center></em></h6>
					<div class="post-detail">
            				<span class="post-info">
                      			<span>				<?php echo $this->_tpl_vars['currentDate']; ?>
							</span>
            </span>
    </div></div>
        <?php echo '<style type="text/css">

@keyframes anim{
from {margin-left:-603px;}
to {margin-left:0px;}
}
@-moz-keyframes anim{
from {margin-left:-603px;}
to {margin-left:0px;}
}
@-webkit-keyframes anim{
from {margin-left:-603px;}
to {margin-left:0px;}
}
#wrap1{
animation:anim 0.5s 1;
-webkit-animation:anim 0.5s 1;
}
</style>'; ?>

        
        

        <div class="block-auth">
            <a class="link-favorite" href="/pages/favourites"><i class="fa fa-heart" aria-hidden="true"></i><span  id="ifav_id" class="count"><?php echo $this->_tpl_vars['favNum']; ?>
</span></a>
            <a class="link-basket" href="/pages/cart_cart"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i><span id="icart_id" class="count avail"><?php echo $this->_tpl_vars['aTemplateNumber']['cart_total']; ?>
</span></a>&nbsp;
                        <?php if ($this->_tpl_vars['aAuthUser']['id'] && ! ( $this->_tpl_vars['oContent']->IsChangeableLogin($this->_tpl_vars['aAuthUser']['login']) )): ?>
            <div class="drop-wrap">
                <a href="#"><span class="gm-link-dashed"><?php echo $this->_tpl_vars['oLanguage']->getMessage('my_dash'); ?>
</span></a>
                <div class="sub">
                <?php $_from = $this->_tpl_vars['aAccountMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aItem']):
?>
                <a href="/pages/<?php if (! $this->_tpl_vars['aItem']['link']): ?><?php echo $this->_tpl_vars['aItem']['code']; ?>
<?php else: ?><?php echo $this->_tpl_vars['aItem']['code']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['aItem']['name']; ?>

                            <?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>
                                <?php if ($this->_tpl_vars['aItem']['code'] == 'message'): ?><?php if ($this->_tpl_vars['aTemplateNumber']['message_number']): ?> <span class="count">(<?php echo $this->_tpl_vars['aTemplateNumber']['message_number']; ?>
)</span><?php endif; ?><?php endif; ?>
                                <?php if ($this->_tpl_vars['aItem']['code'] == 'message_change_current_folder'): ?><?php if ($this->_tpl_vars['aTemplateNumber']['message_number']): ?> <span class="count">(<?php echo $this->_tpl_vars['aTemplateNumber']['message_number']; ?>
)</font><?php endif; ?><?php endif; ?>
                                <?php if ($this->_tpl_vars['aItem']['code'] == 'vin_request_manager'): ?><?php if ($this->_tpl_vars['iNotViewedVins']): ?> <span class="count">(<?php echo $this->_tpl_vars['iNotViewedVins']; ?>
)</span><?php endif; ?><?php endif; ?>
                                <?php if ($this->_tpl_vars['aItem']['code'] == 'manager_package_list'): ?><?php if ($this->_tpl_vars['iNotViewedOrders']): ?> <span class="count">(<?php echo $this->_tpl_vars['iNotViewedOrders']; ?>
)</span><?php endif; ?><?php endif; ?>
                            <?php endif; ?></a>
                            <?php endforeach; endif; unset($_from); ?>
                            <a href="/pages/user_logout"><?php echo $this->_tpl_vars['oLanguage']->GetMessage('exit'); ?>
</a>
                </div>
            </div>
            <div class="user-name" style="text-align: right;padding: 4px 0 0 0;"><?php echo $this->_tpl_vars['aAuthUser']['name']; ?>
<?php if ($this->_tpl_vars['aAuthUser']['type_'] == 'manager'): ?>&nbsp;&nbsp;&nbsp;(<?php echo $this->_tpl_vars['sCustomerGroup']; ?>
) <?php echo $this->_tpl_vars['sCustomerPartner']; ?>
<?php endif; ?>
            </div>
            <?php else: ?>
            <a class=" login_to_personal_area log2" href="javascript:void(0);" onclick="popupOpen('.js-popup-auth');"><?php echo $this->_tpl_vars['oLanguage']->getMessage('enter_cab'); ?>
/ <br><?php echo $this->_tpl_vars['oLanguage']->getMessage('new registration'); ?>
</a>
            
            <?php endif; ?>
                    </div>
        <div class="graf" style=""></div>
                
        <div class="clear"></div>

    </div>
</header>

<nav class="gm-block-category-nav">
    <div class="gm-mainer">
    <ul>
    <?php $_from = $this->_tpl_vars['EcBrandGroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['BrandGroup']):
?>
    <?php if ($_GET['group'] == $this->_tpl_vars['id']): ?>
    <li class="gm_item selected">
        <?php elseif ($_REQUEST['action'] == 'catalog_product'): ?>
                <?php if ($this->_tpl_vars['iIdBrandGroup']): ?>
                    <?php if ($this->_tpl_vars['iIdBrandGroup'] == $this->_tpl_vars['id']): ?>
                     <li class="gm_item selected">
                     <?php else: ?>
                     <li class="gm_item">
                     <?php endif; ?>
                <?php else: ?>
                <li class="gm_item">
                <?php endif; ?>
            <?php else: ?>
            <li class="gm_item">
            <?php endif; ?>
            <a class="gm_brand_group" id="<?php echo $this->_tpl_vars['BrandGroup']['name']; ?>
" href="/?action=catalog_vid&group=<?php echo $this->_tpl_vars['id']; ?>
"><?php echo $this->_tpl_vars['BrandGroup']['name']; ?>
</a>
            <?php if ($this->_tpl_vars['OLD_Interface']): ?>
                                <?php if ($this->_tpl_vars['BrandGroup']['sub']): ?>
                <div class="sub">
                <?php $_from = $this->_tpl_vars['BrandGroup']['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id2'] => $this->_tpl_vars['Item']):
?>
                    <a class="child-element" href="/?action=catalog_brand&group=<?php echo $this->_tpl_vars['id']; ?>
&brand=<?php echo $this->_tpl_vars['Item']['id_brand']; ?>
">
                        <span class="image"><span><img src=<?php echo $this->_tpl_vars['Item']['image']; ?>
 alt="<?php echo $this->_tpl_vars['Item']['brand']; ?>
"></span></span>
                        <span class="name gm-link-dashed"><?php echo $this->_tpl_vars['Item']['brand']; ?>
</span>
                    </a>
                <?php endforeach; endif; unset($_from); ?>
                <span class="child-empty"></span>
                    <span class="child-empty"></span>
                    <span class="child-empty"></span>
                    <span class="child-empty"></span>
                    <span class="child-empty"></span>
                    <span class="child-empty"></span>
                </div>
                <?php endif; ?>
            <?php else: ?>
                        <div class="gm_vids" style="display: none !important;">
             <div class="gm_columns">
              <div class="gm_column left-list">
                <ul class="gm_column-left-list">                 <?php $_from = $this->_tpl_vars['BrandGroup']['biglist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aBigListItem']):
?>
                    <?php if (! $this->_tpl_vars['B2C_Interface'] || $this->_tpl_vars['B2C_Interface'] == 1 && $this->_tpl_vars['aBigListItem']['types'] != 4 || ( $_REQUEST['brand'] == $this->_tpl_vars['aBigListItem']['id'] && $this->_tpl_vars['aBigListItem']['types'] == 4 )): ?>
                    <ul class="gm_column-left-list__item ">
                    <a class="gm_column-left-list__link  
                    <?php if (( $_REQUEST['promo'] == $this->_tpl_vars['aBigListItem']['id'] && $this->_tpl_vars['aBigListItem']['types'] == 1 && $_REQUEST['group'] == $this->_tpl_vars['aBigListItem']['id_group_br'] ) || ( $_REQUEST['brand'] == $this->_tpl_vars['aBigListItem']['id'] && $this->_tpl_vars['aBigListItem']['types'] == 4 )): ?>selected<?php endif; ?>" 
                    id="<?php echo $this->_tpl_vars['aBigListItem']['name']; ?>
"
                    href="<?php echo $this->_tpl_vars['aBigListItem']['href']; ?>
" style="white-space: nowrap;">
                                        <?php echo $this->_tpl_vars['aBigListItem']['name']; ?>
</a></ul>                           <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                </ul>
              </div>
              <?php $_from = $this->_tpl_vars['BrandGroup']['col']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aColItem']):
?> 
                <div class="gm_column"> 
                    <?php $_from = $this->_tpl_vars['aColItem']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aListItem']):
?> 
                        <a class="gm_column-mainvid  <?php if ($_REQUEST['vid'] == $this->_tpl_vars['aListItem']['id']): ?>selected<?php endif; ?>" id="<?php echo $this->_tpl_vars['aListItem']['name']; ?>
" href="<?php echo $this->_tpl_vars['aListItem']['href']; ?>
"><?php echo $this->_tpl_vars['aListItem']['name']; ?>
</a>                            <?php if ($this->_tpl_vars['aListItem']['sublist']): ?><ul class="gm_column-childvid"><?php endif; ?>
                            <?php $_from = $this->_tpl_vars['aListItem']['sublist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aSubListItem']):
?>
                                <ul class="gm_column-childvid__item"><a class="gm_column-childvid__link  <?php if ($_REQUEST['vid'] == $this->_tpl_vars['aSubListItem']['id']): ?>selected<?php endif; ?>" id="<?php echo $this->_tpl_vars['aSubListItem']['name']; ?>
" href="<?php echo $this->_tpl_vars['aSubListItem']['href']; ?>
"><?php echo $this->_tpl_vars['aSubListItem']['name']; ?>
</a></ul> 
                            <?php endforeach; endif; unset($_from); ?>
                        <?php if ($this->_tpl_vars['aListItem']['sublist']): ?></ul><?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
              <?php endforeach; endif; unset($_from); ?>
             </div>
            </div>
                    </li>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?> 
    </ul>
    </div>
</nav>
<?php echo '
  <script src="/js/chosen.jquery.js?1" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function() {
    var config = {
      \'.chosen-select\'           : {no_results_text:\'Не найдено\'},
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    $(\'.chosen-select\').on(\'change\', function(evt, params) {
        //do_something(evt, params);
        xajax_process_browse_url(\'/?action=user_change_region&id_region=\'+params.selected);
        return false;
    });
});
  </script>
'; ?>