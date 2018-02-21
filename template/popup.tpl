<div class="ak-popup-company js-popup-company" style="display: none;">
    <div class="popup-bg"></div>
    <div class="wrapp">
        <div class="head">
            <div id="popup_title"> {$sTitlePopup} </div>
            <div class="close"></div>
        </div>
        <div class="content" id="popup_form">
{if $sUrlFrame}<iframe frameborder=0 src="{$sUrlFrame}" width="100%" height="100%" align="left">! </iframe>{/if}
{include file="catalog/form_stars.tpl"}
        </div>
    </div>
</div>

{literal}
<script>
function ShowPopup(h){
	$('.js-popup-company').fadeIn(500);
	return false;
};

function ClosePopup() {
	$('.js-popup-company').fadeOut(500);
	return false;
};
	$('.js-popup-company .close').click(function(){
		$('.js-popup-company').fadeOut(500);
	});
	$('.js-popup-company .popup-bg').click(function(){
		$('.js-popup-company').fadeOut(500);
	});
</script>
{/literal}
{*
<div id="opaco" style="display:none; background-color: #777; z-index: 10; left:0; top:0; position: absolute; width: 100%;"></div>
<div id="div_popup">
<div id="popup_form">
{if $sUrlFrame}<iframe frameborder=0 src="{$sUrlFrame}" width="100%" height="100%" align="left">! </iframe>{/if}
</div>
{literal}
<script>
function ClosePopup() {
	$('#opaco').hide();
	$('#div_popup').fadeOut(500);
	return false;
};
function ShowPopup(h){
	h = h || '60%';
	$('#opaco').height($(document).height());
	$('#opaco').show();
	$('#opaco').fadeTo(100, 0.6);
	$('#div_popup').height(h);
	$('#div_popup').fadeIn(500);
	return false;
};
</script>
{/literal}
<a id="close_popup" href="#" onclick="ClosePopup();return false;" style="display: inline;"></a>
</div>
*}