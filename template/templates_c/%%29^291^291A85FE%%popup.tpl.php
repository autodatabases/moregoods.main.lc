<?php /* Smarty version 2.6.18, created on 2017-05-15 18:46:18
         compiled from popup.tpl */ ?>
<div class="ak-popup-company js-popup-company" style="display: none;">
    <div class="popup-bg"></div>
    <div class="wrapp">
        <div class="head">
            <div id="popup_title"> <?php echo $this->_tpl_vars['sTitlePopup']; ?>
 </div>
            <div class="close"></div>
        </div>
        <div class="content" id="popup_form">
<?php if ($this->_tpl_vars['sUrlFrame']): ?><iframe frameborder=0 src="<?php echo $this->_tpl_vars['sUrlFrame']; ?>
" width="100%" height="100%" align="left">! </iframe><?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "catalog/form_stars.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
    </div>
</div>

<?php echo '
<script>
function ShowPopup(h){
	$(\'.js-popup-company\').fadeIn(500);
	return false;
};

function ClosePopup() {
	$(\'.js-popup-company\').fadeOut(500);
	return false;
};
	$(\'.js-popup-company .close\').click(function(){
		$(\'.js-popup-company\').fadeOut(500);
	});
	$(\'.js-popup-company .popup-bg\').click(function(){
		$(\'.js-popup-company\').fadeOut(500);
	});
</script>
'; ?>
