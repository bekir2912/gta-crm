/**
 * Created by lexcorp on 20.09.2017.
 */
$(document).on('ready pjax:success pjax:error', function () {

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

    $('.delete_image').on('click', function () {
        var button = $(this);
        $.ajax({
            url: "/product/delete-image",
            data: {'product_id': $(this).data('productid'), 'image_id': $(this).data('imageid')}, //data: {}
            type: "get",
            success: function (t) {
                t = JSON.parse(t);
                if (t.error !== true) {
                    button.parent().remove();
                }
            }
        });
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
});