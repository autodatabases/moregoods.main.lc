<?php /* Smarty version 2.6.18, created on 2018-02-19 20:54:56
         compiled from cart/cart_onepage_delivery.tpl */ ?>

<div class="head" id='delivery2'><?php echo $this->_tpl_vars['oLanguage']->getMessage('Delivery methods'); ?>
:</div>
                <div id='delivery2_2' class="block-labels js-block-label">
                <?php $_from = $this->_tpl_vars['aDeliveryType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['aItem']):
        $this->_foreach['foo']['iteration']++;
?>
                 
                    <label    <?php if ($this->_tpl_vars['aUser']['customer_group_name'] != 'PERSONAL' && $this->_tpl_vars['aItem']['id'] == 1): ?> style="display:none;"<?php endif; ?>><div class="label <?php if (! $this->_tpl_vars['bAlreadySelectedDelivery']): ?>selected<?php endif; ?>">
                        <input type="radio" style="-webkit-appearance: radio;" name="id_delivery_type"
                        value="<?php echo $this->_tpl_vars['aItem']['id']; ?>
"
            
            <?php if ($this->_tpl_vars['aItem']['description']): ?> onclick="<?php echo 'show_delivery_description(\'delivery_description_'; ?><?php echo $this->_tpl_vars['aItem']['id']; ?><?php echo '\');xajax_process_browse_url(\'?action=delivery_set&xajax_request=1&id_delivery_type='; ?><?php echo $this->_tpl_vars['aItem']['id']; ?><?php echo '\');'; ?>
" <?php endif; ?>
            <?php if (! $this->_tpl_vars['bAlreadySelectedDelivery']): ?>
                <?php $this->assign('bAlreadySelectedDelivery', 1); ?>
                checked
            <?php endif; ?>>
                        <span class="caption"><?php echo $this->_tpl_vars['aItem']['name']; ?>
</span>
                    </div></label>
                    <div <?php if ($this->_tpl_vars['aUser']['customer_group_name'] != 'PERSONAL' && $this->_tpl_vars['aItem']['id'] == 1): ?> style="display:none;"<?php endif; ?> class="delivery_description delivery_description_<?php echo $this->_tpl_vars['aItem']['id']; ?>
 del_<?php echo $this->_tpl_vars['aItem']['code']; ?>
" 
<?php if (($this->_foreach['foo']['iteration'] <= 1)): ?>style="display:block;"<?php else: ?>
                    style="display:none;"<?php endif; ?>>
                        <?php echo $this->_tpl_vars['aItem']['description']; ?>

                    </div>
                     
                <?php endforeach; endif; unset($_from); ?>
<br>
                                  
               <span id="gone2" style="display:none;">
                
                <br>
                 <input type=hidden class="novaposta" id="novaposta" name="novaposta" value="">
             </span>
                </div>

                <?php echo '<script type="text/javascript">
function show_delivery_description(id_show) {
    $(\'div.delivery_description\').hide();
    $(\'.\'+id_show).show();
    if ($(\'.del_NovaPoshta\').is(\':visible\')){
        $(\'span#gone\').css(\'display\',\'inline-block\');
        $(\'.\'+id_show).css(\'display\',\'inline-block\');
        $(\'span#gone2\').css(\'display\',\'block\');
        $(\'#for_np\').css(\'display\',\'none\');
    }
    else{
       $(\'span#gone\').css(\'display\',\'none\');
       $(\'span#gone2\').css(\'display\',\'none\'); 
       $(\'#for_np\').css(\'display\',\'block\');
    }
     if ($(\'.del_kurer\').is(\':visible\')){
        $(\'.nova\').css(\'display\',\'none\');
    }
}
$(function(){
        $(\'#npw-map-sidebar-ul\').on(\'click\', \'li\', function(){
      var viddil = $(this).find(\'.npw-list-warehouse\').html()
      event.preventDefault();
       $( ".novaposta" ).val( viddil );
    });  
  
});
</script>
<style>
    #npw-map-wrapper{
    top: 3% !important;
    left: 30% !important;
    position: fixed !important;
    }

    @media (max-width: 800px){
#npw-map-wrapper{
width: 294px;
    top: 3% !important;
    left: 5% !important;
}

#npw-map-sidebar {
    height: 100% !important;
    width: 50% !important;
    float: left !important;
}

#npw-map {
    height: 100% !important;
    width: 49% !important;
    float: left !important;
}
#step_2_3{
    margin:0 !important;
}
}

</style>
'; ?>


<?php echo '<script type=\'text/javascript\' src=\'https://apimgmtstorelinmtekiynqw.blob.core.windows.net/content/MediaLibrary/Widget/Map/dist/map.min.js\'></script>
<script type=\'text/javascript\' src=\'https://apimgmtstorelinmtekiynqw.blob.core.windows.net/content/MediaLibrary/Widget/Calc/dist/calc.min.js\'></script>'; ?>