/**
 * Área Restrita
 * */

jQuery(document).ready(function ($) {

    // adiciona a classe 'active' no no primeiro link da lista
    $('.restrict-services li:first-child a').addClass('active');

    var dataFrist = $('.restrict-services li:first-child a').data('link');
    $('.content-tab__item').hide();

    $('.content-tab #' + dataFrist).fadeIn('slow');
    $('.content-tab #init').fadeIn('slow');

    // ao clicar dispara funcoes
    $('.restrict-services li a').on('click', function (e) {

        // bloqueia ação de click
        e.preventDefault();

        // retira classe 'active' de onde tem
        $('.restrict-services li a').removeClass('active');

        // adciona classe 'active' no link atual ( Clicado )
        $(this).addClass('active');

        // pega current data
        var dataCurrent = $(this).data('link');

        $('.content-tab__item').hide();

        $('.content-tab #' + dataCurrent).fadeIn('slow');

    });

    var document = webservice.document;

    if( document.length > 0 ) {

        //var ip = webservice.ip_doc;
        var ip = '189.45.104.91';
        var url = 'http://' + ip + ':4502/api/contrato?documento=' + document;

        $.ajax({
            type: 'post',
            dataType: 'html',
            data: {'url': url},
            url: webservice.ajaxWebservice,
            crossDomain: true,
            xhrFields: {
                withCredentials: false
            }

        }).done(function (data) {

            data = JSON.parse(data);

            var return_data = data.length;

            if(return_data > 0){
                execute_docs(data, ip);
            } else {
                erro_Boletos();
            }

        }).fail(function (xhr, textStatus, errorThrown) {
            erro_Boletos();
        });

    }

    function erro_Boletos() {
        $('.gen_boleto').html('Sem boletos a gerar');
        $('.gen_extrato').html('Sem extrato a gerar');
        $('#credentials').html('<b>Erro.</b> Não foi possível encontrar o cliente na base de dados!');
    }

    function execute_docs(data, ip){

        data = data[0];
        var nome = data.Nome;
        var contrato = data.Contrato[0];
        var nu_contrato = contrato.Contrato;
        var situacao = contrato.Situacao;
        var empreendimento = contrato.Empreendimento;
        var empresa = contrato.Empresa;

        var credentials = '<p><b>Nome: </b>' + nome + '</p>';
        credentials += '<p><b>Número Contrato: </b>' + nu_contrato + '</p>';
        credentials += '<p><b>Situação: </b>' + situacao + '</p>';
        credentials += '<p><b>Empreendimento: </b>' + empreendimento + '</p>';
        credentials += '<p><b>Empresa: </b>' + empresa + '</p>';

        $('#credentials').html(credentials);

        var parcelas = contrato.Parcela;
        var nu_parcela = parcelas.length;

        var links_boleto = '';
        var href_boleto = '';

        for(var i=0; i<nu_parcela; i++){
            var nu_parcela_doc = parcelas[i].Parcela;
            var nu_parcela_tipo = parcelas[i].Tipo;

            href_boleto = 'http://' + ip + ':4502/api/avisobancariocontrato?' +
                'contrato=' + nu_contrato +
                '&parcela=' + nu_parcela_doc +
                '&tipo=' + nu_parcela_tipo;

            links_boleto += '<a href="'+ href_boleto +'" class="gen_boleto btn_gerar_boleto" target="_blank">' +
                'PARCELA '+ nu_parcela_doc + '</a>';
        }

        $('.gen_boleto_content').html(links_boleto);

        var href_extrato = 'http://'+ ip +':4502/api/extratocontrato?contrato=' + nu_contrato;
        $('.gen_extrato').attr('href', href_extrato).html('VISUALIZAR EXTRATO');

    }

});