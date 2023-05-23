// Seleção das regiões
jQuery(function($){
    $('#unidade').html("<option value=''>Aguardando Cidade</option>");
    $.getJSON(unities.display_city, function(data){

        var options = '<option value="">Selecione sua Cidade</option>';

        $.each( data, function( key, val ) {
            options += '<option value="' + val.city + '">' + val.city + '</option>';
        });

        $('#regiao').html(options);
    });
});

// Seleção das unidades
jQuery(function($){
    $('#regiao').change(function(){
        if( $(this).val() ) {

            $.getJSON(unities.display_unity,{cidade: $(this).val(), ajax: 'true'}, function(data){

                var options = '';

                $.each( data, function( key, val ) {
                    options += '<option value="' + val.unidade + '">' + val.unidade + '</option>';
                });

                $('#unidade').html(options).show();
            });

        } else {

            $('#unidade').html("<option value=''>Aguardando Cidade</option>");

        }
    });
});