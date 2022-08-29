"use strict";

$(document).ready(function(){
    cssVars();
    $('body').on('submit','#quick_order_form',function(e){
        e.preventDefault();
        var error = 0;
        $(this).find('input').each(function () {
            $(this).removeClass('novalid');
            if($(this).val()==''){error = 1;$(this).addClass('novalid');}
        })
        if(error == 0){
            var url = $(this).attr('action');
            var successtext = $(this).data('success');
            var dataForm = $(this).serialize();
            getFormOneClick(name,url,dataForm,successtext);
        }
    });
    function getFormOneClick(name,url,data,successtext){
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(data){
                $.fancybox({content:'<div class="modalForm">'+successtext+'</div>',autoSize:true,padding	:0,helpers:{overlay:{locked: false}}});
            }
        });
    }
    $('.add-compare').on('click', function (event) {
        var ID = $(this).data("id");
        var URL = $(this).data('url');
        var ACTION;
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            ACTION = 'DELETE_FROM_COMPARE_LIST';
        }else{
            $(this).addClass('active');
            ACTION = 'ADD_TO_COMPARE_LIST';
        }
        $.ajax({
            url: URL+'?action='+ACTION+'&id='+ID,
            type: 'POST',
            data: "",
            success: function(data){
            }
        });
    });
    $('.add-favorites').on('click', function (event) {
        var ID = $(this).data("id");
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).find('.icon-heart').removeClass('icon-heart').addClass('icon-heart-outline');
        }else{
            $(this).addClass('active');
            $(this).find('.icon-heart-outline').removeClass('icon-heart-outline').addClass('icon-heart');
        }
        $.getJSON(SITE_DIR+'ajax/delay_basket.php',
            {
                ACTION: 'DELAY',
                ID: ID,
            },
            function (data) {

            }
        );
    });
    $(".hero__slider").owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 700,
        nav: true,
        navText: ['<i class="prymery-icon icon-angle-left"></i>', '<i class="prymery-icon icon-angle-right"></i>'],
    });
    $(".recomendation__slider").owlCarousel({
        margin: 30,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });

    $(".product-popular__slider").owlCarousel({
        items: 3,
        loop: false,
        smartSpeed: 700,
        margin: 30,

        responsive : {
            0 : {
                items: 1,
            },
            576 : {
                items: 2, 
            },
            992 : {
                items: 2,
            },
            1200 : {
                items: 3,
            }
        }
    });

    $(".hot-slider").owlCarousel({
        items: 1,
        loop: true,
        dots: false,
        smartSpeed: 700,
        nav: true,
        navText: ['<i class="prymery-icon icon-angle-left"></i>', '<i class="prymery-icon icon-angle-right"></i>'],
        navContainer: ".product-hot__navigation",
    });

    $(".hot-slider--small").owlCarousel({
        items: 1,
        loop: true,
        dots: false,
        smartSpeed: 700,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
    });

    $(".product__slider").owlCarousel({
        items: 3,
        loop: false,
        smartSpeed: 700,
        margin: 30,

        responsive : {
            0 : {
                items: 1,
            },
            576 : {
                items: 2,
            },
            1200 : {
                items: 3,
            }
        }
    });

    $(".partner__slider").owlCarousel({
        items: 5,
        loop: false,
        smartSpeed: 700,
        margin: 30,
        dots: false,

        responsive : {
            0 : {
                items: 1,
            },
            576 : {
                items: 2,
            },
            1200 : {
                items: 5,
            }
        }
    });

    $(".post__slider").owlCarousel({
        items: 3,
        loop: false,
        smartSpeed: 700,
        margin: 30,
        dots: true,

        responsive : {
            0 : {
                items: 1,
            },
            576 : {
                items: 2,
            },
            1200 : {
                items: 3,
            }
        }
    });
    $(".ajax-form").fancybox({
        fitToView	: false,
        autoSize	: true,
        padding	: 0,
        helpers : {
            title : null
        }
    });
    $('body').on('submit','.staticForm form',function(e){
        e.preventDefault();
        var dataForm = $(this).serialize()+'&web_form_submit=Y&TEMPLATE=static&FORM_ID='+$(this).attr('name');
        $('.staticForm').addClass('LoadingShow');
        getStaticForm(name, dataForm);
    });
    function getStaticForm(name,data){
        $.ajax({
            url: SITE_DIR+'form/staticForm.php',
            type: 'POST',
            data: data,
            success: function(data){
                $('.staticForm').parent().html(data);
            }
        });
    }
    $('body').on('submit','.modalFormAjax form',function(e){
        e.preventDefault();
        var dataForm = $(this).serialize()+'&web_form_submit=Y&FORM_ID='+$(this).attr('name');
        $.fancybox.showLoading();
        getForm(name,dataForm);
    });
    function getForm(name,data){
        $.ajax({
            url: SITE_DIR+'form/',
            type: 'POST',
            data: data,
            success: function(data){
                $.fancybox({content:data,autoSize:true,padding	:0,helpers:{overlay:{locked: false}}});
                $('.staticForm').removeClass('LoadingShow');
            }
        });
    }

    $('.widget-catalog ul.dropdown').each(function(){
        $(this).css('display', 'none');
    });

    $('.widget-catalog li.active ul.dropdown').each(function(){
        $(this).css('display', 'block');
    });

    $('.widget-catalog > ul > li:not(.dl-1) > a').on('click', function() {
        event.preventDefault();

        if ( $(this).parent().hasClass('active') ) {
            $('.widget-catalog ul.dropdown').each(function(){
                $(this).slideUp();
            });
            $('.widget-catalog li.active').each(function(){
                $(this).removeClass('active');
            });
        } else {
            $('.widget-catalog ul.dropdown').each(function(){
                $(this).slideUp();
            });
            $('.widget-catalog li.active').each(function(){
                $(this).removeClass('active');
            });

            if ( $(this).parent().hasClass('active') ) {
                $(this).next().slideUp().parent().removeClass('active');
            } else {
                $(this).next().slideDown().parent().addClass('active');
            }
        }
    });

    $(window).keydown(function (eventObject) {
        if (eventObject.which == 27) {
            if ($(".main-navigation__wrapper").hasClass('show')) {
                $(".main-navigation__wrapper").removeClass("show");
            }
        }
    });

    $('.close-menu').on('click', function(){
        $('.main-navigation__wrapper').removeClass('show');
    });

    $('.main-navigation').click(function(e){
        e.stopPropagation();
    });

    $(".main-navigation__wrapper").click(function(){
        $(this).removeClass('show');
    });

    $('.toggle-menu').on('click', function(){
        $('.main-navigation__wrapper').addClass('show');
    });
    $('.quantity-plus').click(function () {
        var quantity_plus = +$(this).prev().val() + 1;
        $(this).prev().val(quantity_plus);
        CalcTotalPrice($(this),quantity_plus);
    });
    $('.quantity-minus').click(function () {
        var quantity_minus = +$(this).next().val() - 1;
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1){
                $(this).next().val(quantity_minus);
            }
        }
        CalcTotalPrice($(this),quantity_minus);
    });
    function CalcTotalPrice(el,quantity){
        var id = el.parent().find('input').data('product');
        if(quantity > 1){
            $('#'+id+'_price_total').html($('#'+id+'_price').data('price')*quantity).parent().show();
        }else{
            $('#'+id+'_price_total').parent().hide();
        }
    }
    $('.deleteAllBasket').on('click', function (event) {
        $.getJSON(SITE_DIR+'ajax/deleteAll.php',
            {
                ACTION: 'DELETEALL'
            },
            function () {}
        );
    });
});