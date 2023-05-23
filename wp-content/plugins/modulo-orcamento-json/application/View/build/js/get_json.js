// Seleção das marcas
jQuery(function($){
    $('#marca_colchao').html("<option value=''>Aguarde</option>");
    $.getJSON(json_mattress.mattress_mark, function(data){

        var options = '<option value="">Selecione a Marca</option>';

        $.each( data, function( key, val ) {
            options += '<option data-id="' + val.mattress_mark.id + '" value="' + val.mattress_mark.name + '">' + val.mattress_mark.name + '</option>';
        });

        $('#marca_colchao').html(options);
    });
});

// Seleção dos colchões
jQuery(function($){
    $('#colchao').html("<option value=''>---</option>");

    $('#marca_colchao').change(function(){
        if( $(this).val() ) {

            var mattress_mark_id = $(this).find(':selected').data('id');

            $.getJSON(json_mattress.mattress,{mattress: mattress_mark_id, ajax: 'true'}, function(data){

                var options = '<option value="">Selecione o colchão</option>';

                $.each( data, function( key, val ) {
                    options += '<option value="' + val.mattress + '">' + val.mattress + '</option>';
                });

                $('#colchao').html(options).show();
            });

        } else {

            $('#colchao').html("<option value=''>Aguardando Marca</option>");

        }
    });
});