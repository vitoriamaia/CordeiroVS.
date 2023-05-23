jQuery(document).ready(function($){

    $('.checkout_product').on('click', function(e){

        e.preventDefault();

        $(this).prepend('<div class="wrap">&nbsp;</div>');

        var id_client = $(this).data('client');
        var id_product = $(this).data('product');
        var action = $(this).data('action');

        $.ajax({
            type: 'post',
            url: cart.cart_method,
            data: {
                id_client: id_client,
                id_product: id_product,
                action_checkout: action
            },
            success: function() {
                window.location = cart.url_checkout;
            },
            fail: function(){
                alert("Erro ao processar sua compra, \nfavor tente novamente mais tarde");
            },
            complete: function(){

            }
        })

    });

});