jQuery(document).ready(function($){

    $('.checkout_finish').on('click', function(e){
        e.preventDefault();

        /**
         * @type {*|jQuery|HTMLElement}
         * @Nome
         */

        var name = $('#name');
        if(name.val() == ""){
            name.addClass('error');
            name.focus();
            return false;
        }

        /**
         * @type {*|jQuery|HTMLElement}
         * @Email
         */

        var email = $('#email');
        var index_of = email.val().indexOf("@");
        var length = email.val().length;
        if (!(index_of >= 3 && length >= 9) || email.val() == "") {
            email.addClass('error');
            email.focus();
            return false;
        }

        /**
         * @type {*|jQuery|HTMLElement}
         * @Mensagem
         */

        var message = $('#message');

        /**
         * @type {*|jQuery|HTMLElement}
         * @ID Cliente
         */

        var client = $('#client');

        /**
         * Processamento da compra
         */

        $(this).text("Carregando...");

        $.ajax({

            /**
             * Envia para o PagSeguro o XML para valida��o
             */

            type: 'post',
            url: checkout.pagseguro_method,
            data: {
                name: name.val(),
                email: email.val(),
                message: message.val(),
                client: client.val()
            },
            success : function(data){

                var data = JSON.parse(data);

                if(data.error_status == 0){
                    checkoutCode = data.msg;
                    isOpenLightbox = PagSeguroLightbox({
                        code: checkoutCode
                    }, {
                        success : function(transactionCode) {
                            notifications(transactionCode, checkoutCode, client.val());
                        },

                        abort : function() {
                            window.location = checkout.url_lista;
                        }

                    });

                    if (!isOpenLightbox){ location.href = checkout.pagseguro_manual + checkoutCode; }

                } else {

                    alert(data.msg);
                    location.reload();

                }

            }

        });

    });

    function notifications(transactionCode, checkoutCode, id_client){

        $.ajax({
            type: 'post',
            url: checkout.pagseguro_notification,
            data: {
                transactionCode: transactionCode,
                checkoutCode: checkoutCode,
                id_client: id_client
            },
            success: function(data){
                window.location = data;
            }

        });

    }

})