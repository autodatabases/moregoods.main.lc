jQuery.browser = {
		
//		//productimage carousel in product card
//	    if $('.js-productimage-block').length {
//	        $('.js-productimage-block .line').jCarouselLite({
//	        	circular: false,
//	        	scroll: 1, 
//	            visible: 1,
//	            btnGo: ".js-productimage-block .control li"
//	        });
//	    }
};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
   
})();
$(function() {
	$('.phone').mask("(099)999-99-99",{placeholder:"_"});
	
    //ie detection
    if ($.browser.msie && $.browser.version == 10) {
        $("html").addClass("ie10");
    }
    if ($.browser.msie && $.browser.version == 9) {
        $("html").addClass("ie9");
    }
    if ($.browser.msie && $.browser.version == 8) {
        $("html").addClass("ie8");
    }
    if ($.browser.msie && $.browser.version == 7) {
        $("html").addClass("ie7");
    }
    //toggle description
    $('.js-toggle-description').click(function(){
        $(this).toggleClass('active');
        $(this).prev().toggleClass('show');
    });

    //toggle comment-form
    $('.js-add-comment-link').click(function(){
        $(this).next('.js-add-comment-form').slideToggle(150);
    });
});
/* incorrect with colorbox in view info part
$(function() {
    //product image carousel init
    $('.image-block .big .line').jCarouselLite({
        circular: true,
	scroll: 1,
        visible: 1,
        btnGo: $('.image-block .control a')
    });
});
*/

