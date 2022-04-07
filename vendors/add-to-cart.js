(function($){
    $('a.ajax_add_to_cart').on('click', function(e) { 
        e.preventDefault();
        $btn = $(this);
        console.log("Add to cart func added");

        var data = {
            action: 'wprig_woocommerce_ajax_add_to_cart',
            qty: 1,
            id: $btn.data("product-id"),
        }

        console.log(data)

        $.ajax({
            type:'post',
            url:wprig_admin.ajax_url,
            data:data,
            beforeSend:function(resp){
                $btn.removeClass('added').addClass('loading');
            },
            complete: function (response) {
                $btn.addClass('added').removeClass('loading');
            },
            success: function (response) { 
               
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $btn]);
            }
        })
    });
})(jQuery)