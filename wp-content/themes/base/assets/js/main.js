jQuery(document).ready(function ($) {

    /**
     * Painel Principal ( Home )
     */
    var swiper = new Swiper('.s1', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        paginationClickable: true,
        // spaceBetween:0,
        //centeredSlides: true,
        loop: true,
        autoplay: 4000,
        effect: 'fade',
        preventClicks: true,
        autoplayDisableOnInteraction: false
    });


    /**
     * Logos ( Carousel )
     */
    var swiper = new Swiper('.s2', {
        slidesPerView: 5,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        paginationClickable: true,
        loop: true,
        autoplay: 2000,
        autoplayDisableOnInteraction: false,
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 40
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });


    /**
     * Fancybox
     */
    $(".gal-item a").addClass('fancybox');
    $(".fancybox").attr('rel', 'gallery');

    $(".fancybox").fancybox({
        maxWidth: 1200,
        maxHeight: 768,
        fitToView: false,
        width: '100%',
        height: '100%',
        autoSize: false,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none'
    });


    /**
     * Se for mobile insere not-hover nos elementos setados
     */
    /*
     if(is_Mobile()) {
         jQuery(document).ready(function($) {
            $('a').addClass('not-hover');
         });
     }
     */


    /**
     * Menu do bootstrap com hover ao inves de click
     */
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });


    /**
     * Fancybox e form com callback exemplo
     */
    $("a.form-fancy").on('click', function () {
        $.fancybox(
            $('.formulario').html(),
            {
                'maxWidth': 990,
                'maxHeight': 768,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'hideOnContentClick': false,
                afterShow: function () {

                    $('.telefone input').focusout(function () {
                        var phone, element;
                        element = $(this);
                        element.unmask();
                        phone = element.val().replace(/\D/g, "");
                        if (phone.length > 10) {
                            element.mask('(99) 99999-9999');
                        } else {
                            element.mask('(99) 9999-99999');
                        }
                    }).trigger('focusout');

                    $(".ida input").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        onClose: function (selectedDate) {
                            $(".volta input").datepicker("option", "minDate", selectedDate);
                        }
                    });

                    $(".volta input").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        onClose: function (selectedDate) {
                            $(".ida input").datepicker("option", "maxDate", selectedDate);
                        }
                    });

                }
            }
        );
    });


    /**
     * Adiciona classe no menu
     */
    $('.menu-item > a').addClass('menu-link');


    /**
     * Alert nos forms
     */
    $('.wpcf7-form-control-wrap span').addClass('bg-danger');


    /**
     * Lazy load para carregamento de imagens
     */
    $(".lazy").lazyload({effect: "fadeIn"});


    /**
     * Colocando active no menu on page
     */
    /*$('.navbar li').click(function(e) {
     $('ul.nav > li').click(function (e) {
     e.preventDefault();
     $('ul.nav > li').removeClass('active');
     $(this).addClass('active');
     });
     })*/


    /**
     * Filtro do select2 pra pagina representantes
     */
    /*$(".js-example-placeholder-single").select2({
     placeholder: "Selecione a cidade",
     allowClear: true,
     language: "pt_PT"
     });

     $(".js-states").select2({
     placeholder: "Selecione o estado",
     allowClear: true,
     language: "PT"
     });*/


    /**
     * js pra mudar de cor e add class adicional no header
     */
    $(window).scroll(function () {
        if ($(document).scrollTop() > 120) {
            $('nav').addClass('shrink');
        } else {
            $('nav').removeClass('shrink');
        }
    });


    /**
     * active dos marcadores no menu
     */

    // add a class
    $('.menu-item').addClass('menu__item');
    $('.menu__item a').addClass('menu__link');
    $('.menu__item a').addClass('menu__link');

    // add a class active no 1 item "a"
    $('.menu-item-4 a').addClass('menu__link--active');

    // remove class padrao do bt
    $('.menu-item').removeClass('active');

    /*começa a magia dos actives*/
    $('.menu__link').on('click', function () {
        //c.preventDefault();

        var id = $(this).attr('href'), targetOffset = $(id).offset().top;

        // add
        $('.menu__item a').removeClass('menu__link--active');
        $(this).addClass('menu__link--active');

        // anima
        $('html,body').animate({
            scrollTop: targetOffset - 100
        }, 500);
    });
    
    // Início do código de Aumentar/ Diminuir a letra
 
// Para usar coloque o comando:
// "javascript:mudaTamanho('tag_ou_id_alvo', -1);" para diminuir
// e o comando "javascript:mudaTamanho('tag_ou_id_alvo', +1);" para aumentar
 
var tagAlvo = new Array('p'); //pega todas as tags p//
 
// Especificando os possíveis tamanhos de fontes, poderia ser: x-small, small...
var tamanhos = new Array( '12px','13px','14px','15px','16px' );
var tamanhoInicial = 2;
 
function mudaTamanho( idAlvo,acao ){
if (!document.getElementById) return
var selecionados = null,tamanho = tamanhoInicial,i,j,tagsAlvo;
tamanho += acao;
if ( tamanho < 0 ) tamanho = 0;
if ( tamanho > 6 ) tamanho = 6;
tamanhoInicial = tamanho;
if ( !( selecionados = document.getElementById( idAlvo ) ) ) selecionados = document.getElementsByTagName( idAlvo )[ 0 ];
 
selecionados.style.fontSize = tamanhos[ tamanho ];
 
for ( i = 0; i < tagAlvo.length; i++ ){
tagsAlvo = selecionados.getElementsByTagName( tagAlvo[ i ] );
for ( j = 0; j < tagsAlvo.length; j++ ) tagsAlvo[ j ].style.fontSize = tamanhos[ tamanho ];
}
}
// Fim do código de Aumentar/ Diminuir a letra



});
function goBack() {
    window.history.back();
}
