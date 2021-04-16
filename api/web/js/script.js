$(function() {
    $('#add_performance').on('click', function () {
        var $Obj = $('.performance-block');
        $Obj.first().clone().appendTo( "#performance_block" );
        return false;
    });
    $('#add_performance_uz').on('click', function () {
        var $Obj = $('.performance-block-uz');
        $Obj.first().clone().appendTo( "#performance_block_uz" );
        return false;
    });
    $('#add_performance_en').on('click', function () {
        var $Obj = $('.performance-block-en');
        $Obj.first().clone().appendTo( "#performance_block_en" );
        return false;
    });
    $('#add_additional_image').on('click', function () {
        var $Obj = $('.additional_image');
        $Obj.first().clone().appendTo( "#additional_image_row" );
        return false;
    });

    $('#product-price_type').on('change', function () {
        if($(this).val().toString() === '0') {
            $('#wholesale_block').css('visibility', 'hidden');
            $('#wholesale_block').css('position', 'absolute');
            $('#product-price').parent().parent().css('visibility', 'visible');
            $('#product-price').parent().parent().css('position', 'static');
        }
        if($(this).val().toString() === '1') {
            $('#product-price').parent().parent().css('visibility', 'hidden');
            $('#product-price').parent().parent().css('position', 'absolute');
            $('#wholesale_block').css('visibility', 'visible');
            $('#wholesale_block').css('position', 'static');
            // $('#product-price').prop('value', '0');
        }
        if($(this).val().toString() === '2') {
            $('#product-price').parent().parent().css('visibility', 'visible');
            $('#product-price').parent().parent().css('position', 'static');
            $('#wholesale_block').css('visibility', 'visible');
            $('#wholesale_block').css('position', 'static');
        }
    });

    $('#product-unit_id').on('change', function () {
        if($(this).val().toString() === '0') {
            $('.unit_place').text('(шт.)');
        }
        else {
            $('.unit_place').text('('+ $(this).find("option:selected").text() +')');
        }
    });

    $('#add_wholesale').on('click', function () {
        var parent =  $('#wholesale_parent_block');
        var row =  parent.find('.row:last');

        row.clone().appendTo( parent );
        return false;
    });
    $('#def_price').on('click', function () {
        if($(this).is(':checked')) {
            // $('#price_block').css('visibility', 'hidden');
            $('#price_block').css('height', '0');
            $('#price_block').css('overflow', 'hidden');
        }
        else {
            // $('#price_block').css('visibility', 'visible');
            $('#price_block').css('height', 'unset');
            $('#price_block').css('overflow', 'unset');
        }
    });
    setTimeout(function () {
        if($('#product-unit_id').val() != undefined){
            if($('#product-unit_id').val().toString() === '0') {
                $('.unit_place').text('(шт.)');
            }
            else if($('#product-unit_id').val().toString() !== '0') {
                $('.unit_place').text('('+ $('#product-unit_id').find("option:selected").text() +')');
            }
        }

        if($('#product-price_type').val() != undefined){
            if($('#product-price_type').val().toString() === '0') {
                $('#wholesale_block').css('visibility', 'hidden');
                $('#wholesale_block').css('position', 'absolute');
                $('#product-price').parent().parent().css('visibility', 'visible');
                $('#product-price').parent().parent().css('position', 'static');
            }
            else if($('#product-price_type').val().toString() === '1') {
                $('#product-price').parent().parent().css('visibility', 'hidden');
                $('#product-price').parent().parent().css('position', 'absolute');
                $('#wholesale_block').css('visibility', 'visible');
                $('#wholesale_block').css('position', 'static');
                // $('#product-price').prop('value', '0');
            }
            else if($('#product-price_type').val().toString() === '2') {
                $('#product-price').parent().parent().css('visibility', 'visible');
                $('#product-price').parent().parent().css('position', 'static');
                $('#wholesale_block').css('visibility', 'visible');
                $('#wholesale_block').css('position', 'static');
            }
        }


        if($('#def_price').is(':checked')) {
            // $('#price_block').css('visibility', 'hidden');
            $('#price_block').css('height', '0');
            $('#price_block').css('overflow', 'hidden');
        }
        else {
            // $('#price_block').css('visibility', 'visible');
            $('#price_block').css('height', 'unset');
            $('#price_block').css('overflow', 'unset');
        }
    }, 1000);

    $('.header__button_menu').click(function(){
        $('.navigation').toggleClass('navigation_open');
    });

    $(document).click(function (e) {
        var target = $(e.target);
        if (target.closest('.header__button_menu').length > 0) {
            return;
        }
        var container = $(".navigation");
        if (!target.closest('.navigation').length > 0){
            $('.navigation').removeClass('navigation_open');
        }
    });

    $('.navigaton__exit-button').click(function(){
        $('.navigation').removeClass('navigation_open');
    });


    // 1) ASSIGN EACH 'DOT' A NUMBER
    var dotcount = 1;

    var owlDot = $('.car-description .owl-dot');


    owlDot.each(function() {
        $(this).addClass( 'dotnumber' + dotcount);
        $(this).attr('data-info', dotcount);
        dotcount=dotcount+1;
    });

    // 2) ASSIGN EACH 'SLIDE' A NUMBER
    slidecount = 1;

    $('.photo-gallery__slider .owl-item').not('.cloned').each(function() {
        $( this ).addClass( 'slidenumber' + slidecount);
        slidecount=slidecount+1;
    });

    $('.photo-gallery__slider .cloned').each(function() {
        $( this ).find( '[data-fancybox="gallery"]').removeAttr('data-fancybox');
    });


    // SYNC THE SLIDE NUMBER IMG TO ITS DOT COUNTERPART (E.G SLIDE 1 IMG TO DOT 1 BACKGROUND-IMAGE)
    owlDot.each(function() {

        grab = $(this).data('info');

        slidegrab = $('.slidenumber'+ grab +' img').attr('src');

        $(this).css("background-image", "url("+slidegrab+")");

    });

    // THIS FINAL BIT CAN BE REMOVED AND OVERRIDEN WITH YOUR OWN CSS OR FUNCTION, I JUST HAVE IT
    // TO MAKE IT ALL NEAT
    amount = owlDot.length;
    gotowidth = 100/amount;

    owlDot.css("width", 75);
    newwidth = owlDot.width();
    owlDot.css("height", 55);


    $('.datepicker').datepicker({
        format: "d.m.yyyy",
        endDate : '-18y'
    });


        $("#file").click(function(){
            $("#image").click();
        });
    if($(".dialog__top")[0]) {
        $(".dialog__top").scrollTop($(".dialog__top")[0].scrollHeight);
    }


    $('.dialog__back').click(function () {
        $('.lk-message__message-bar').addClass('lk-message__message-bar--active');
    });
    $('.message-bar__item').click(function () {
        $('.lk-message__message-bar').removeClass('lk-message__message-bar--active');
    });

    $('.add_fav').on('click', function () {
        var button = $(this);
        $.ajax({
            url: "/favorite/add",
            data: {'action': $(this).data('action'), 'id': $(this).data('prodId')}, //data: {}
            type: "post",
            success: function (t) {
                t = JSON.parse(t);
                if (t.error !== true) {
                    if (button.data('action') === 'add') {
                        button.data('action', 'remove');
                        button.css('background', '#d91b30');
                        button.find('i').css('color', '#fff');
                    }
                    else {
                        button.data('action', 'add');
                        button.css('background', 'transparent');
                        button.find('i').css('color', '#333');
                    }
                }
            }
        });
        return false;
    });

    $('.show_phone').on('click', function () {
        link = $(this);
        $.ajax({
            url: "/site/show-number",
            data: {'id': link.attr('data-prod')}, //data: {}
            type: "post",
            success: function (t) {
                link.html('<i class="flaticon-auricular-phone-symbol-in-a-circle"></i> ' + t);
                link.removeClass('show_phone');
            }
        });
    });
    $('.show_shop_phone').on('click', function () {
        link = $(this);
        $.ajax({
            url: "/site/show-shop-number",
            data: {'shop': link.attr('data-shop')}, //data: {}
            type: "post",
            success: function (t) {
                link.html('<i class="flaticon-auricular-phone-symbol-in-a-circle"></i> ' + t);
                link.removeClass('show_shop_phone');
            }
        });
    });

    $('.announcements__button-switch').on('click', function () {
        btn = $(this);
        id = btn.attr('data-prod');
        st = btn.attr('data-status');
        $.ajax({
            url: "/announcement/switch",
            data: {'id': id, 'status': st}, //data: {}
            type: "post",
            success: function () {
                if(st == 1) {
                    btn.attr('data-status', '0');
                    btn.removeClass('announcements__button-item-not-active');
                } else {
                    btn.attr('data-status', '1');
                    btn.addClass('announcements__button-item-not-active');
                }
            }
        });
    });

});
$('#slider').owlCarousel({
    loop: true,
    nav: true,
    //autoplay: true,
    navText: ["<i class='flaticon-back'>", "<i class='flaticon-next'>"],
    //autoplayTimeout: 3000,
    //autoplayHoverPause: true,
    items: 1

});
$('.sale-block .owl-carousel').owlCarousel({
    loop: true,
    nav: true,
    margin: 15,
    autoplay: true,

    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1
        },
        450: {
            items: 2
        },
        650: {
            items: 3
        },
        768: {
            items: 3
        },
        1200: {
            items: 4
        }
    }

});
