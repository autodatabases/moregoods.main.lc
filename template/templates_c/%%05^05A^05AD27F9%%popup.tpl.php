<?php /* Smarty version 2.6.18, created on 2017-05-15 18:53:00
         compiled from cart/popup.tpl */ ?>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	//popup close
	$(\'.pt-popup-block .close\').click(function() {
		$(this).parent().parent().parent().fadeOut(\'slow\');
		return false;
	});
});
</script>
'; ?>

<div id="opaco2" style="display:none; background-color: #777; z-index: 101; left:0; top:0; position: fixed; width: 100%;height: 4000px;
	 filter:progid:DXImageTransform.Microsoft.Alpha(opacity=50);-moz-opacity: 0.5;-khtml-opacity: 0.5;opacity: 0.5;"></div>
<div class="pt-popup-block" id="popup_id" style="display: none;">
    <div class="dark">&nbsp;</div>
    <div class="block">
        <div class="caption drag">
            <a href="#" class="close">&nbsp;</a>
            <span id="popup_caption_id"><?php if ($this->_tpl_vars['sPopupCaption']): ?><?php echo $this->_tpl_vars['sPopupCaption']; ?>
<?php else: ?>Popup<?php endif; ?></span>
        </div>
        <div class="content">
			<div id="popup_content_id">
            	<?php echo $this->_tpl_vars['sPopupContent']; ?>

			</div>
        </div>
    </div>
</div>