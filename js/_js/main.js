$(window).bind('load resize ready', function(){
    adaptivity();
});

function switchMap(set_geo,lgeo,blk,kom){
    if(set_geo==lgeo)
    {
    }
    else
    {
        b=document.getElementById(blk);
        b.style.visibility=kom;
    }
}

$(function() {
	$('.phone').mask("(099)999-99-99",{placeholder:"_"});
    // location popup
    $('.js-location-yes').click(function(){
        $('.js-location-sub').fadeToggle();
        xajax_process_browse_url('/?action=user_geo_yes');
    });
    $('.js-location-no').click(function(){
        $('.js-location-sub').fadeToggle();
        $('.chosen-container.chosen-container-single').addClass('chosen-with-drop');
        $('.chosen-container.chosen-container-single').addClass('chosen-container-active');
//		$(location).attr('href', '/pages/contact_form'); //http://moregoods.com.ua
    });
  //toggle description
    $('.js-toggle-description').click(function(){
        $(this).toggleClass('active');
        $(this).prev().toggleClass('show');
    });
   $('.js-city1').mouseenter(function(){
        $(this).toggleClass('active');
    });
   $('.js-map1').mouseenter(function(){
        //$(this).toggleClass('active');
        var $this = $(this);
        var $geo_city_id=$this["0"].attributes['set_geo_city_id'].nodeValue;
   		$b=$this.find('.map_city.'+$geo_city_id);

        $b.addClass('selected');

    });
    
	  
    //toggle comment-form
    $('.js-add-comment-link').click(function(){
        $(this).next('.js-add-comment-form').slideToggle(150);
    });
    // index banner carousel
    if ($('.js-banner-index').length) {
        $('.js-banner-index .wrapper').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true,
            swipe: false,
            autoplay:true,
            responsive: [
                {
                    breakpoint: 1180,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        focusOnSelect: true,
                        centerPadding: '0',
                        slidesToShow: 3,
                        swipe: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                        swipe: true
                    }
                }
            ]
        });
    }

    // product carousel
    if ($('.js-product-carousel').length) {
        $('.js-product-carousel .wrapper').slick({
            slidesToShow: 5,
            slidesToScroll: 5,
            swipe: true,
//            arrows: false,
            dots: true,
//            swipe: false,
            infinite: false,
            responsive: [
                {
                    breakpoint: 1180,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        swipe: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        swipe: true
                    }
                }
            ]
        });


        $('.js-product-carousel .element').mouseleave(function(){
            var $this = $(this);
            setTimeout(function(){
                if (!$this.find('.gm-select').hasClass('hover')) {
                    $this.removeClass('open');
                }
            }, 50);
        });

        $('.js-product-carousel .js-uniform').hover(function(){
            $(this).closest('.element').addClass('open');
        });
    }

    // product carousel portal
    if ($('.js-product-carousel-portal').length) {
        $('.js-product-carousel-portal .wrapper').slick({
            slidesToShow: 4,
            arrows: true,
            dots: true,
            swipe: false,
            infinite: false,
            responsive: [
                {
                    breakpoint: 1180,
                    settings: {
                        slidesToShow: 3,
                        arrows: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        swipe: true,
                        arrows: false
                    }
                }
            ]
        });


        $('.js-product-carousel-portal .element').mouseleave(function(){
            var $this = $(this);
            setTimeout(function(){
                if (!$this.find('.gm-select').hasClass('hover')) {
                    $this.removeClass('open');
                }
            }, 50);
        });

        $('.js-product-carousel-portal .js-uniform').hover(function(){
            $(this).closest('.element').addClass('open');
        });
    }

    // sales carousel
    try {
    if ($('.js-block-sales').length) {
        $('.js-block-sales .wrapper').slick({
            slidesToShow: 5,
            arrows: false,
            dots: true,
            swipe: false,
            infinite: false,
            responsive: [
                {
                    breakpoint: 1180,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        swipe: true
                    }
                }
            ]
        });
    }
    } catch (err) {

    	  // обработка ошибки

    	}

    // modern uniform
    if ($('.js-uniform').length) {
        $('.js-uniform').uniform({
            selectClass: 'gm-select'
        });
    }

    // aside curtain
    $('.js-block-left-curtain .toggle').click(function(){
        $(this).closest('li').toggleClass('open');
        return false;
    });

    $('.js-block-left-curtain-toggle').click(function(){
        $('.js-block-left-curtain').toggleClass('close');
    });

    $('.js-block-left-filter-toggle').click(function(){
        $('.js-block-left-filter').toggleClass('close');
    });

    // count block
    $('.js-block-count .plus, .js-block-count .minus').click(function(){
        var $blockValue = $(this).parent().find('.count');
        var value = parseFloat($blockValue.val());
		if($(this).parent().parent().hasClass('line')) 
		 $min=0;
		else
		 $min=1;
		
		if ($(this).hasClass('minus') && !value) return;
		 
		if (!value) value=0;
        if ($(this).hasClass('plus')) {
            value = value + 1;
        } else {
            if (value > $min) {
                value = value - 1;
            }
        }
		if (value==0) value='';
        $blockValue.val(value);
        $(this).parent().find('.count').keyup();

		$butt=$(this).parent().parent().parent();
		$btt=$butt.find('.gm-icon-buy');
        if ($btt) {
			if(!$btt.hasClass('change')){
				$btt.addClass('change');
			}
		}

	});

    // change view
    $('.js-change-view a').click(function(){
        /*var currentType= $(this).data('type');
        $('.js-change-view a').removeClass('selected');
        $(this).addClass('selected');

        $('.js-product-thumb-list, .js-product-line-list, .js-product-list-list').hide();
        $('.js-product-'+ currentType +'-list').show();*/
        //return false;
    });

    if ($('.gm-product-thumb-element').length) {
        $('.gm-product-thumb-element').mouseenter(function(){
		//проставить цену и т.д. согласно выделенного товара
            var $this = $(this);
			$price=$this.find('.price')['0'].children['1'].id;
			$pricemain=$this.find('.button')['0'].id;
			$image=$this.find('.image')['0'].children['0'].id; 
			$id_a=$this.find('.options').find('.selected')['0'].id; 
			$select=$this.find('.options')['0'].id;			
			OnPriceThumb3($price, $id_a, $pricemain, $image, $select);
		});
        $('.gm-product-thumb-element').mouseleave(function(){
            var $this = $(this);
            setTimeout(function(){
                if (!$this.find('.gm-select').hasClass('hover')) {
                    $this.removeClass('open');
                }
            }, 50);
        });

        $('.gm-product-thumb-element .js-uniform').hover(function(){
            $(this).closest('.gm-product-thumb-element').addClass('open');
        });
    }

    // product images
    if ($('.js-product-images').length) {
        $('.js-product-images .big').slick({
            slidesToShow: 1,
            arrows: false,
            dots: false,
            swipe: false,
            asNavFor: '.js-product-images .small',
            responsive: [
                {
                    breakpoint: 1180,
                    settings: {
                        dots: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        swipe: true ,
                        dots: true
                    }
                }
            ]
        });

        $('.js-product-images .small').slick({
            slidesToShow: 4,
            arrows: false,
            dots: false,
            vertical: true,
            asNavFor: '.js-product-images .big',
            focusOnSelect: true,
            swipe: false
        });
    }

    // product tabs
    $('.js-product-tabs a').click(function(){
        var currentTab = $(this).data('tab');

        $('.js-product-tabs a').removeClass('selected');
        $(this).addClass('selected');

        $('.js-block-description').hide();
        $('.js-block-description').prev().removeClass('selected');
        $('.js-block-description[data-block="'+ currentTab +'"]').show();
        $('.js-block-description[data-block="'+ currentTab +'"]').prev().addClass('selected');
        return false
    });

    $('.js-block-description-toggle').click(function(){
        $(this).toggleClass('selected');
        $(this).next().toggle();
    });

    // delivery labels
    $('.js-block-label input[type="radio"]').change(function(){
        $('.js-block-label .label').removeClass('selected');
        $(this).closest('.label').addClass('selected');
    });

    $('.js-block-label .label').click(function(){
        $(this).find('input[type="radio"]').attr('checked', 'checked');
        $(this).find('input[type="radio"]').change();
    });

    // delivery labels
    $('.js-block-label2 input[type="radio"]').change(function(){
        $('.js-block-label2 .label').removeClass('selected');
        $(this).closest('.label').addClass('selected');
    });

    $('.js-block-label2 .label').click(function(){
        $(this).find('input[type="radio"]').attr('checked', 'checked');
        $(this).find('input[type="radio"]').change();
    });

    // cabinet-menu-toggle
    $('.js-cabinet-menu-toggle').click(function(){
        $(this).toggleClass('open');
        $(this).next().toggle();
    });

    // order toggle
    $('.js-order-toggle').click(function(){
        $(this).closest('.gm-order-element').toggleClass('open');
    });
    
    //favorite
    
    $('.link-favorite').click(function(){
    	obj = $(this);
    	if(obj.hasClass('active')){
    		obj.removeClass('active');
    		id = obj.attr('id').replace('fav_','');
    		xajax_process_browse_url('/?action=favourites_delete&id='+id);
    	}
    	else{
    		obj.addClass('active');
    		id = obj.attr('id').replace('fav_','');
    		xajax_process_browse_url('/?action=favourites_add&id='+id);
    	}
    	updateFav();
    	return false;
    });



    $('.gm-icon-buy').click(function(){
    	obj= $(this);
		if(!obj.hasClass('missing')){
			if(obj.hasClass('change')){
			obj.removeClass('change');
			}
			id= obj.attr('id').replace('buy_','');
			number = obj.parent().parent().find('.count').val();
			if(number=='') {
				number=0;
			}
			if(obj.hasClass('already') || number==0){
				if(!obj.hasClass('already')) {
						number=1;
						xajax_process_browse_url('/?action=cart_add_cart_item&xajax_request=1&id_product='+id+'&link_id=add_link_'
                            +id+'&number='+number);
                        oCart.AnimateAdd(this);
                $('#qiuck_buy_popup').fadeIn(1);
                $('#qiuck_buy_popup1').fadeIn(1);
                $('#qiuck_buy_popup2').fadeIn(1);
                        obj.addClass('already');
                       // obj.text('В корзині');
                        }
                        return false;

						}
					else	
						xajax_process_browse_url('/?action=cart_set_cart_item&xajax_request=1&id_product='+id+'&link_id=add_link_'+id+'&number='+number);
					
                    if (number==0)	obj.removeClass('already');
					else
					{
						if(!obj.hasClass('already')) obj.addClass('already');
						obj.parent().parent().find('.count').val(number);
					}
			}
			else
			{
				if (!number==0){
					xajax_process_browse_url('/?action=cart_add_cart_item&xajax_request=1&id_product='+id+'&link_id=add_link_'+id+'&number='+number);
					obj.addClass('already');
				}
			}
			if (number==0){
			obj.parent().parent().find('.count').val('');
			}
		
    	return false;
    });
    
    var Cart=function (data) {
    //this.data=data;
};

Cart.prototype.AnimateAdd = function (oCallerElement)
{
    // add the picture to the cart
    var $element = $(oCallerElement).find('img');

    if ($element) {
        var $picture = $element.clone();
        var pictureOffsetOriginal = $element.offset();

        if ($picture.size()) $picture.css({'position': 'absolute', 'top': pictureOffsetOriginal.top, 'left': pictureOffsetOriginal.left});

        var pictureOffset = $picture.offset();
        var cartBlockOffset = $('#cart_block').offset();

        // Check if the block cart is activated for the animation
        if (cartBlockOffset != undefined && $picture.size())
        {
            $picture.appendTo('body');
            $picture.css({ 'position': 'absolute', 'top': $picture.css('top'), 'left': $picture.css('left') })
            .animate({ 'width': $element.attr('width')*0.9, 'height': $element.attr('height')*0.9, 'opacity': 0.5
            , 'top': cartBlockOffset.top + 30, 'left': cartBlockOffset.left + 55 }, 1000)
            .fadeOut(100, function() {
            });
        }
    }
}

var oCart=new Cart();


    $('.gm-button-buy').click(function(){
    	obj= $(this);
//        if(!obj.hasClass('already'))
		if(!obj.hasClass('missing')){
			var $this = $(this).parent().parent().parent();
			price=$this.find('.price')['0'].children['1'].textContent;
    	id= obj.attr('id').replace('buy_','');
    	number = 1;
    	xajax_process_browse_url('/?action=cart_add_cart_item&xajax_request=1&id_product='+id+'&link_id=add_link_'
            +id+'&number='+number+'&price='+price);
        oCart.AnimateAdd(this);
$('#qiuck_buy_popup').fadeIn(1);
$('#qiuck_buy_popup1').fadeIn(1);
$('#qiuck_buy_popup2').fadeIn(1);
    	obj.addClass('already');
    	obj.text('В корзині');
		}
    	return false;
    });
    

    

    $('#datestart,#dateend').datepicker({ dateFormat:"yy-mm-dd",
        minDate:+1,
         beforeShowDay: nonWorkingDates,
         firstDay: 1
    });
    $('#datestart_time').datetime({ 
       dateFormat:"yy-mm-dd",
       timeFormat: "hh:mm tt",
       firstDay: 1,
       userLang : 'ru'
    });
    $('input.datetime').datetime({
         userLang : 'ru'
     });
    
    $('.addAddress').click(function(){
    	var obj = $(this);
    	obj.parent().append("<div class='outer'><textarea name='data[addreses][]' value='' style='width:88%' ></textarea><div class='remove_btn inner'><a href='javascript:void(0)' onclick='$(this).parent().parent().remove();' class='link-delete rmAddress'></a></div></div>");
    });

    $('.rmAddress').click(function(){
    	var obj = $(this);
    	obj.parent().remove();
    });
    
    $('#continue_cart').click(function(){
    	$('#step_2').toggle();
    	$('#step_2_2').toggle();
    	$('#payment_types').toggle();
    	$('#payment_types_2').toggle();
    	$('.step').removeClass('selected');
    	$('.step:last').addClass('selected');
    	$('#continue_cart').toggle();
    	$('#end_cart').toggle();
    	
    });
    $('#continue_cart2').click(function(){
    	$('.testForm .block-info').toggle();
    	$('#payment_types').toggle();
    	$('#payment_types_2').toggle();
    	$('#delivery2').toggle();
    	$('#delivery2_2').toggle();
        $('#delivery2_3').toggle();
    	$('.step:last').addClass('selected');
    	$('#continue_cart2').toggle();
    	$('#end_cart').toggle();
    	
    });
    
    $('#cart_register').click(function(){
    	$('#delivery_new_account').toggle();
    	$('#btn_new_account').toggle();
    	$('.gm-makeorder-auth').toggle();
    });
    
    $('.gm-portal-menu li').click(function(){
    	var obj = $(this);
    	if($(window).width() < 767 ){
    		if(obj.hasClass('with-sub')){
    			if(obj.find('ul').css('display')!='block'){
    				$('.gm-portal-menu > ul ul').css({'display':'none'});
    			}
    				obj.find('ul').css({'position':'static'}).toggle();
    		}
    	}
    });
    
});

// popup open
function popupOpen(e) {
    $(e).fadeIn();
    var popupBlock = $(e).find('.block-popup');
    var popupHeight = popupBlock.height();
    popupBlock.css({
        'top' : - popupHeight
    });
    popupBlock.animate({
        'top': 0
    }, 300);
}

// popup close
function popupClose(e) {
    var popupBlock = $(e).find('.block-popup');
    var popupHeight = popupBlock.height();
    var popupTopPadding = 150;
    popupBlock.animate({
        'top': - popupHeight - popupTopPadding
    }, 300);
    setTimeout(function(){
        $(e).fadeOut();
    }, 300);
}
function reloadimg(form_id) {
	if (form_id == null)
		var form_id = 'capcha';

	var img = document.getElementById(form_id);
	img.src = "/lib/captcha/captcha.image.php" + "?" + (new Date()).getTime();
}
// adaptive
function adaptivity() {
    var bodyWidth = $(window).width();
    if ($('.js-product-description').length) {
        if (bodyWidth < 1180) {
            $('.js-product-description div').appendTo('.js-product-description-tablet');
        } else {
            $('.js-product-description-tablet div').appendTo('.js-product-description');
        }
    }
}

function updateFav(){
    	xajax_process_browse_url('/?action=favourites_update&xajax_request=1');
}
/* not set circular=true incorrect total images */
$(function() {
    //product image carousel init
    $('.image-block .big .line').jCarouselLite({
        circular: false,
    scroll: 1,
        visible: 1,
        speed: 900,
        btnGo: $('.image-block .control a')
    });
    
    $('.addPhone').click(function(){
        var obj = $(this);
        obj.parent().append("<div><input type=text name='phone[]' value='' style='width:270px'><input type='button' class='rmPhone' onclick='$(this).parent().remove();' value='-'></div>");
    });
    
    $('.rmPhone').click(function(){
        var obj = $(this);
        obj.parent().remove();
    });
});

function OnPrice(price, id_selecta, stock, code, art, barcode, image, pricemain) {
	var e = document.getElementById(id_selecta);
	var strPrice = e.options[e.selectedIndex].value;
	var split_arr = strPrice.split("_");
	document.getElementById(price).innerHTML = Number(split_arr[0]).toFixed(2)+' грн.';
	document.getElementById(stock).innerHTML = '('+Number(split_arr[1]).toFixed(0)+' шт.)';
	document.getElementById(code).innerHTML = '(Код: '+Number(split_arr[2])+')';
	document.getElementById(art).innerHTML = '(Артикул: '+split_arr[3]+')';
	document.getElementById(barcode).innerHTML = '(Штрих-код: '+Number(split_arr[4])+')';

	var a = document.getElementById(pricemain).getElementsByTagName("a");
	if (Number(split_arr[1]).toFixed(2)-Number(split_arr[6]).toFixed(2)<0)
		$(a).addClass("missing");
	else
		$(a).removeClass("missing");

	var im = document.getElementById(image).getElementsByTagName("img");
	$(a).attr('id','buy_'+split_arr[2]);
	$(im).attr('src',split_arr[5]);
 }

function OnPriceThumb(price, id_selecta, pricemain, image) {
	var e = document.getElementById(id_selecta);
	var strPrice = e.options[e.selectedIndex].value;
	var split_arr = strPrice.split("_");
	
	document.getElementById(price).innerHTML = Number(split_arr[0]).toFixed(2)+' грн.';

	var a = document.getElementById(pricemain).getElementsByTagName("a");
	if (Number(split_arr[3]).toFixed(2)-Number(split_arr[4]).toFixed(2)<0)
		$(a).addClass("missing");
	else
		$(a).removeClass("missing");
	if (split_arr[5]){
		if (!$(a).hasClass('already'))
		{
			$(a).addClass("already");
			$(a)[0].innerHTML = 'В корзині';
		}
	}
			else
	{
		if ($(a).hasClass('already'))
		{
		$(a).removeClass("already");
		$(a)[0].innerHTML = 'Придбати';
		}
	}	
	var im = document.getElementById(image).getElementsByTagName("img");
	$(a).attr('id','buy_'+split_arr[1]);
	$(im).attr('src',split_arr[2]);
 }

function OnPriceThumb2(price, id_a, pricemain, image, select){
	var e = document.getElementById(id_a);
	var strPrice = e.name;
	var split_arr = strPrice.split("_");
	var tmp_arr=price.split("_");
	var priceold='price_old_'+tmp_arr[1];

	var promo1='promo_'+tmp_arr[1]+'_1';
	var promo2='promo_'+tmp_arr[1]+'_2';
	var promo3='promo_'+tmp_arr[1]+'_3';
	var promo4='promo_'+tmp_arr[1]+'_4';
	var p1=document.getElementById(promo1);
	var p2=document.getElementById(promo2);
	var p3=document.getElementById(promo3);
	var p4=document.getElementById(promo4);
	if (p1 != null) {p1.textContent = split_arr[7];p1.style.backgroundColor=split_arr[8];}
	if (p2 != null) {p2.textContent = split_arr[9];p2.style.backgroundColor=split_arr[10];}
	if (p3 != null) {p3.textContent = split_arr[11];p3.style.backgroundColor=split_arr[12];}
	if (p4 != null) {p4.textContent = split_arr[13];p4.style.backgroundColor=split_arr[14];}

	document.getElementById(price).innerHTML = Number(split_arr[5]).toFixed(2)+' грн.';
	if (split_arr[7] == '' && split_arr[8] == '' && split_arr[9] == '' && split_arr[10] == '') {
		document.getElementById(price).style.color='rgb(0,0,0)';
		document.getElementById(price).style.fontSize='24px';
	}
	else
	{
		document.getElementById(price).style.color='rgb(186,0,0)';
		document.getElementById(price).style.fontSize='20px';
	}
	var a = document.getElementById(pricemain).getElementsByTagName("a");
	if (Number(split_arr[3]).toFixed(2)-Number(split_arr[4]).toFixed(2)<0)
		$(a).addClass("missing");
	else
		$(a).removeClass("missing");
	if (split_arr[6]){
		if (!$(a).hasClass('already'))
		{
			$(a).addClass("already");
			$(a)[0].innerHTML = 'В корзині';
		}
	}
			else
	{
		if ($(a).hasClass('already'))
		{
		$(a).removeClass("already");
		$(a)[0].innerHTML = 'Придбати';
		}
	}	
		
	var im = document.getElementById(image).getElementsByTagName("img");
	$(a).attr('id','buy_'+split_arr[1]);
	$(im).attr('src',split_arr[2]);
	
	var sel = document.getElementById(select).getElementsByTagName("a");
	$(sel).removeClass('selected');
	
	 var bodyWidth = $(window).width();
	 
	 if (bodyWidth < 1180) {
		    $(sel).click(function(){
			      $(sel).removeClass('selected');
				  $(this).addClass('selected');
		    });
	 }
	 else{
		 $(sel).hover(function(){
		      $(sel).removeClass('selected');
			  $(this).addClass('selected');
	    });
	 }
	if(document.getElementById(priceold)) {
		if (Number(split_arr[0]).toFixed(2)==Number(split_arr[5]).toFixed(2))
		document.getElementById(priceold).innerHTML = '';
		else
		document.getElementById(priceold).innerHTML = Number(split_arr[0]).toFixed(2)+' грн.';

	}

}

function OnPriceThumb3(price, id_a, pricemain, image, select){
	var e = document.getElementById(id_a);
	var strPrice = e.name;
	var split_arr = strPrice.split("_");
	var tmp_arr=price.split("_");
	var priceold='price_old_'+tmp_arr[1];
	
	var promo1='promo_'+tmp_arr[1]+'_1';
	var promo2='promo_'+tmp_arr[1]+'_2';
	var promo3='promo_'+tmp_arr[1]+'_3';
	var promo4='promo_'+tmp_arr[1]+'_4';
	var p1=document.getElementById(promo1);
	var p2=document.getElementById(promo2);
	var p3=document.getElementById(promo3);
	var p4=document.getElementById(promo4);
	if (p1 != null) {p1.textContent = split_arr[7];p1.style.backgroundColor=split_arr[8];}
	if (p2 != null) {p2.textContent = split_arr[9];p2.style.backgroundColor=split_arr[10];}
	if (p3 != null) {p3.textContent = split_arr[11];p3.style.backgroundColor=split_arr[12];}
	if (p4 != null) {p4.textContent = split_arr[13];p4.style.backgroundColor=split_arr[14];}

	document.getElementById(price).innerHTML = Number(split_arr[5]).toFixed(2)+' грн.';
	if (split_arr[7] == '' && split_arr[8] == '' && split_arr[9] == '' && split_arr[10] == '') {
		document.getElementById(price).style.color='rgb(0,0,0)';
		document.getElementById(price).style.fontSize='24px';
	}
	else
	{
		document.getElementById(price).style.color='rgb(186,0,0)';
		document.getElementById(price).style.fontSize='20px';
	}

	var a = document.getElementById(pricemain).getElementsByTagName("a");
	if (Number(split_arr[3]).toFixed(2)-Number(split_arr[4]).toFixed(2)<0)
		$(a).addClass("missing");
	else
		$(a).removeClass("missing");

		
	if (split_arr[6]){
		if (!$(a).hasClass('already'))
		{
			$(a).addClass("already");
			$(a)[0].innerHTML = 'В корзині';
		}
	}
			else
	{
		if ($(a).hasClass('already'))
		{
		$(a).removeClass("already");
		$(a)[0].innerHTML = 'Придбати';
		}
	}	
	var im = document.getElementById(image).getElementsByTagName("img");
	$(a).attr('id','buy_'+split_arr[1]);
	$(im).attr('src',split_arr[2]);
	
	var sel = document.getElementById(select).getElementsByTagName("a");
	//$(sel).removeClass('selected');
	
	 var bodyWidth = $(window).width();
	 
	 if (bodyWidth < 1180) {
		    $(sel).click(function(){
			      $(sel).removeClass('selected');
				  $(this).addClass('selected');
		    });
	 }
	 else{
		 $(sel).hover(function(){
		      $(sel).removeClass('selected');
			  $(this).addClass('selected');
	    });
	 }


	if(document.getElementById(priceold)) {
		if (Number(split_arr[0]).toFixed(2)==Number(split_arr[5]).toFixed(2))
		document.getElementById(priceold).innerHTML = '';
		else
		document.getElementById(priceold).innerHTML = Number(split_arr[0]).toFixed(2)+' грн.';

	}
}

function OnPriceThumbCheckPrice(price){
	var tmp_arr=price.split("_");
}

function OnPrice2(price, id_a, stock, code, art, barcode, image, pricemain, select) {
	var e = document.getElementById(id_a);
	var strPrice = e.name;
	var split_arr = strPrice.split("_");
	var tmp_arr=price.split("_");
	var priceold='price_old_'+tmp_arr[1];

	var promo1='promo_'+tmp_arr[1]+'_1';
	var promo2='promo_'+tmp_arr[1]+'_2';
	var promo3='promo_'+tmp_arr[1]+'_3';
	var promo4='promo_'+tmp_arr[1]+'_4';
	var p1=	document.getElementById(promo1);
	var p2=document.getElementById(promo2);
	var p3=document.getElementById(promo3);
	var p4=document.getElementById(promo4);
	if (p1 != null) {p1.textContent = split_arr[9];p1.style.backgroundColor=split_arr[10];}
	if (p2 != null) {p2.textContent = split_arr[11];p2.style.backgroundColor=split_arr[12];}
	if (p3 != null) {p3.textContent = split_arr[13];p3.style.backgroundColor=split_arr[14];}
	if (p4 != null) {p4.textContent = split_arr[15];p4.style.backgroundColor=split_arr[16];}
	
	document.getElementById(price).innerHTML = Number(split_arr[7]).toFixed(2)+' грн.';
	if(document.getElementById(priceold))
	document.getElementById(priceold).innerHTML = Number(split_arr[0]).toFixed(2)+' грн.';
	document.getElementById(stock).innerHTML = '('+Number(split_arr[1]).toFixed(0)+' шт.)';
	document.getElementById(code).innerHTML = '(Код: '+Number(split_arr[2])+')';
	document.getElementById(art).innerHTML = '(Артикул: '+split_arr[3]+')';
	document.getElementById(barcode).innerHTML = '(Штрих-код: '+Number(split_arr[4])+')';

	var a = document.getElementById(pricemain).getElementsByTagName("a");
	if (Number(split_arr[1]).toFixed(2)-Number(split_arr[6]).toFixed(2)<0)
		$(a).addClass("missing");
	else
		$(a).removeClass("missing");
	if (split_arr[8]){
		if (!$(a).hasClass('already'))
		{
			$(a).addClass("already");
			$(a)[0].innerHTML = 'В корзині';
		}
	}
			else
	{
		if ($(a).hasClass('already'))
		{
		$(a).removeClass("already");
		$(a)[0].innerHTML = 'Придбати';
		}
	}	
		
	var im = document.getElementById(image).getElementsByTagName("img");
	$(a).attr('id','buy_'+split_arr[2]);
	$(im).attr('src',split_arr[5]);

	var sel = document.getElementById(select).getElementsByTagName("a");
	$(sel).removeClass('selected');
	
	 var bodyWidth = $(window).width(); 
	 if (bodyWidth < 1180) {
		    $(sel).click(function(){
			      $(sel).removeClass('selected');
				  $(this).addClass('selected');
		    });
	 }
	 else{
		 $(sel).hover(function(){
		      $(sel).removeClass('selected');
			  $(this).addClass('selected');
	    });
	 }
 }