jQuery(document).ready(function ($) {

	/**
     * Tabs eventos
     **/

    // Adicionar class active para primeiro elemento da lista
    $('.tabs-head-packages li:first-child a').addClass('active');

    // get data-name of link with class active
    var link_current = $('.tabs-head-packages li a.active').data('content');

    // hide article
    $('.tabs-body-packages .tabs-body-packages__item').hide();

    console.log(link_current);

    // show in tab with id of data-name active link
    $('.tabs-body-packages .tabs-body-packages__item#'+link_current).show();

    // actions on click
    $('.tabs-head-packages .tabs-head-packages__item a').on('click', function(e){

        // no redirect action
        e.preventDefault();

        // hide article
        $('.tabs-body-packages .tabs-body-packages__item').hide();

        // remove class active of link
        $('.tabs-head-packages .tabs-head-packages__item a').removeClass('active');

        // add class active of link
        $(this).addClass('active');

        //show and hide tabs contents
        var data_current = $(this).data('content');



        $('.tabs-body-packages .tabs-body-packages__item#'+data_current ).fadeIn();


    });

});

