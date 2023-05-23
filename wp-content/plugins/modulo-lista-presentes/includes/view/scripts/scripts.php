<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MLP_Scripts
{

    public static function init()
    {
        add_action('wp_enqueue_scripts', array(__CLASS__, 'calls_front'));
        add_action('admin_enqueue_scripts', array(__CLASS__, 'calls_back'));
    }

    public static function calls_front()
    {

        if(is_page(
            array('pagename'=>'checkout')
        )){

            $url_pagseguro  = (get_option('enable_ratification') == 'on') ? 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js' : 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';
            $url_pagseguro_manual = (get_option('enable_ratification') == 'on') ? 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=' : 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=';

            wp_enqueue_script( 'checkout_pagseguro', $url_pagseguro);
            wp_enqueue_script( 'checkout_pagseguro_exec', MLP()->plugin_url() . "/assets/js/checkout.js", array('jquery') );
            wp_localize_script( 'checkout_pagseguro_exec', "checkout", array(
                'pagseguro_method' => admin_url( 'admin-ajax.php?action=pagseguro_method' ),
                'pagseguro_notification' => admin_url( 'admin-ajax.php?action=pagseguro_notification' ),
                'pagseguro_manual' => $url_pagseguro_manual,
                'url_lista' => get_home_url()
            ));

        };

        wp_enqueue_script( 'cart', MLP()->plugin_url() . "/assets/js/cart.js", array('jquery'));
        wp_localize_script( 'cart', 'cart', array(
            'cart_method' => admin_url( 'admin-ajax.php?action=cart_method' ),
            'url_checkout' => get_home_url() . '/checkout'
        ));
    }

    public static function calls_back(){
        wp_enqueue_style("styles", MLP()->plugin_url() . "/assets/css/style.css");
        wp_enqueue_style( "style-statistic",  MLP()->plugin_url() . "/assets/css/style-statistic.css" );
        wp_enqueue_script( "data-tables",  MLP()->plugin_url() . "/assets/js/jquery.dataTables.min.js", array('jquery') );
        wp_enqueue_script( "script-coupon",  MLP()->plugin_url() . "/assets/js/script-logs-back.js" );
    }

}

MLP_Scripts::init();