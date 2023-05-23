function date_html($, data, type, current_month){

    var content_type = "content_"+type;
    var data_month = data.main[content_type][current_month];

    var options = "";

    $.each(data_month, function (key, val) {

        for (var i = 0; i < val['content'].length; i++) {
            options += val['content'][i];
        };

    });

    $('#'+type).html(options);

}

jQuery(document).ready(function($) {

    var date = new Date();
    var current_month = date.getMonth()+1;

    $.getJSON(birthday.listin, function(data) {

        // Prefeitos
        date_html($, data, "major", current_month);

        // Cidades
        date_html($, data, "city", current_month);

    });

    // Ação de click no mês
    $('.nav_month a').on('click', function(e){

        e.preventDefault();

        $(this).closest('.nav_month').find('li').removeClass('active');
        $(this).parent().addClass('active');

        var type = $(this).data('type');
        var current_month = $(this).data('month');

        $('#'+type).html('').addClass('loading');

        $.getJSON(birthday.listin, function(data) {

            // Geral
            date_html($, data, type, current_month);

            $('#'+type).removeClass('loading');

        });
    })

});