$(window).bind('load resize ready', function(){
    adaptivity();
});

$(function() {
    // location popup
    $('.js-location-toggle').click(function(){
        $('.js-location-sub').fadeToggle();
    });

    // index banner carousel
    if ($('.js-banner-index').length) {
        $('.js-banner-index .wrapper').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true,
            swipe: false,
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
            arrows: false,
            dots: true,
            swipe: false,
            infinite: false,
            responsive: [
                {
                    breakpoint: 1180,
                    settings: {
                        slidesToShow: 3
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
                        slidesToShow: 3
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
        if ($(this).hasClass('plus')) {
            value = value + 1;
        } else {
            if (value > 1) {
                value = value - 1;
            }
        }
        $blockValue.val(value);
    });

    // change view
    $('.js-change-view a').click(function(){
        var currentType= $(this).data('type');
        $('.js-change-view a').removeClass('selected');
        $(this).addClass('selected');

        $('.js-product-thumb-list, .js-product-line-list, .js-product-list-list').hide();
        $('.js-product-'+ currentType +'-list').show();
        return false;
    });

    if ($('.gm-product-thumb-element').length) {
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

    // cabinet-menu-toggle
    $('.js-cabinet-menu-toggle').click(function(){
        $(this).toggleClass('open');
        $(this).next().toggle();
    });

    // order toggle
    $('.js-order-toggle').click(function(){
        $(this).closest('.gm-order-element').toggleClass('open');
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