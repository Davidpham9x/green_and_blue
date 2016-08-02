'use strict';
var gbCompany = window.gbCompany || {}; //global namespace for YOUR gbCompany, Please change gbCompany to your gbCompany name

var isMobile = {
    isAndroid: function() {
        return navigator.userAgent.match(/Android/i);
    },
    isBlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    isiOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    isOpera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    isWindows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.isAndroid() || isMobile.isBlackBerry() || isMobile.isiOS() || isMobile.isOpera() || isMobile.isWindows());
    }
};

(function($) {
    gbCompany.Global = {
        modalSubmitVideo: null,

        init: function() { //initialization code goes here
            $.support.cors = true;
            this.initFormElements();
            this.initMasheadSlider();
            this.initSliderProduct();
            this.initRemoveProduct();
            this.initToogleMenu();
            this.initHandleWebsiteResize();
        },

        initFormElements: function() {
            $('input, textarea').placeholder();

            $(".radio-wrapper .input-radio").each(function() {
                if ($(this).is(":checked")) {
                    $('.input-radio[name="' + $(this).attr('name') + '"]').parents(".radio-selected").removeClass("radio-selected");
                    $(this).parents('.radio-wrapper').addClass("radio-selected");
                }
            });

            $(document).on('change', ".radio-wrapper .input-radio", function() {

                $('input[name="' + $(this).attr('name') + '"]').each(function() {
                    if ($(this).not(':checked')) {
                        $(this).parent().removeClass("radio-selected");
                    }
                });

                if ($(this).is(":checked")) {
                    $(this).parents('.radio-wrapper').addClass("radio-selected");
                }
            });

            //Checkbox Wrapper
            $('.checkbox-wrapper .input-checkbox').each(function() {
                if ($(this).is(':checked')) {
                    $(this).parents('.checkbox-wrapper').addClass('checked');
                }
            });

            $(document).on('click', '.checkbox-wrapper .input-checkbox', function() {

                if ($(this).is(':checked')) {
                    $(this).parents('.checkbox-wrapper').addClass('checked');
                } else if ($(this).not(':checked')) {
                    $(this).parents('.checkbox-wrapper').removeClass('checked');
                }
            });

            //Select Wrapper
            $('.select-wrapper').each(function() {
                if ($(this).find('span').length <= 0) {
                    $(this).prepend('<span>' + $(this).find('select option:selected').text() + '</span>');
                }
            });

            $(document).on('change', '.select-wrapper select', function() {
                $(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
            });
        },

        initMasheadSlider: function() {
            if ($('.masthead__banner').length && $('.masthead__banner').children().length > 2) {
                $('.masthead__banner').slick({
                    infinite: true,
                    speed: 500,
                    fade: true,
                    cssEase: 'linear',
                    dots: true,
                    appendArrows: $('.masthead__arrow > .container'),
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i></button>'
                });
            }
        },

        initSliderProduct: function() {
            if ($('#slider-product').length) {
                var sliderContent = $('#slider-product > .product__img--big'),
                    listThumbs = $('#slider-product').find('.product__img--list').children();

                sliderContent.slick({
                    infinite: true,
                    speed: 500,
                    fade: true,
                    arrows: false,
                    cssEase: 'linear'
                });

                listThumbs.each(function(idx, elm) {
                    var _this = $(this);

                    _this.off('click').on('click', function() {
                        sliderContent.slick('slickGoTo', idx);
                        listThumbs.removeClass('active');
                        listThumbs.eq(idx).addClass('active');
                    });
                })
            }
        },

        initSliderService: function() {
            if ($('.list-service').length) {
                var sliderContent = $('.list-service > .columns'),
                    listThumbs = $('.list-service').find('.item').children();

                sliderContent.slick({
                    infinite: true,
                    speed: 500,
                    fade: false,
                    arrows: false,
                    dots: true,
                    cssEase: 'linear',
                    slidesToShow: 2
                });
            }
        },

        initRemoveProduct: function() {
            if ($('#table-cart').length) {
                var tableContent = $('#table-cart'),
                    tableFooter = tableContent.find('tfoot'),
                    removeTags = tableContent.find('.remove-product');

                function getTotalPrice() {
                    var price = 0;

                    tableContent.find('.remove-product').each(function(idx, elm) {
                        price = price + parseInt($(elm).data('price'), 10);
                    });

                    return price;
                }

                removeTags.each(function() {
                    var _this = $(this);
                    _this.off('click').on('click', function(e) {
                        e.preventDefault();
                        _this.parents('tr').remove();
                        setTimeout(function() {
                            var price = getTotalPrice();
                            var string = numeral(price).format('0,0');

                            tableFooter.find('td:last-child').text(string + ' VND');
                        });
                    });
                });
            }
        },

        initToogleMenu: function() {
            var aTag = $('.toggle-menu'),
                contentMenuMobile = $('.main-nav');

            aTag.off('click').on('click', function(e) {
                e.preventDefault();

                if ($(this).hasClass('active')) {
                    contentMenuMobile.slideUp();
                    $(this).removeClass('active');
                } else {
                    contentMenuMobile.slideDown();
                    $(this).addClass('active');
                }
            });
        },

        initHandleWebsiteResize: function() {
            window.windowWidth = 0;

            $(window).resize(function() {
                window.windowWidth = $(window).width();

                if (window.windowWidth <= 640) {
                    gbCompany.Global.initSliderService();
                } else {
                    $('.list-service > .columns').slick('unslick');
                }
            }).trigger('resize');
        }
    };
})(jQuery);

$(document).ready(function() {
    $(document).foundation();
    gbCompany.Global.init();
});
