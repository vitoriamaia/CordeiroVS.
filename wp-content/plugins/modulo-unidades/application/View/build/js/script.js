// Salvar regiões
jQuery(document).ready(function($){
    $('.register_regions .save').hide();
    $('.register_regions .edit').on('click', function(){
        $(this).hide();
        var form_current = $(this).parent();
        $(form_current).find('.regioes').removeAttr('readonly');
        $(form_current).find('.save').show();
        $(form_current).find('.save').on('click', function(){
            $(form_current).submit();
        });
    });
});


// Registro de unidades
jQuery(document).ready(function($){
    $('.register_unity').on('click', function(e){
        e.preventDefault();
        $(this).next().fadeToggle();
    });
});


// Data Tables
jQuery(document).ready(function($){
    $('.data').dataTable({
        paging: false,
        //searching: false,
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    });

});