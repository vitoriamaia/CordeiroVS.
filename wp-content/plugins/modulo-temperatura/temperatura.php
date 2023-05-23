<?php

/*
Plugin Name: Módulo Temperatura
Plugin URI: http://www.bindigital.com.br
Description: Formulário de integração de repasse Aprece
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class Module_Temperature
{

    protected static $_instance = null;

    public function __construct()
    {
        $this->init();
    }

    public static function instance(){

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

    }

    public function init(){
        // Chamadas de Scripts
        add_action('wp_enqueue_scripts', array($this, 'scripts'));
    }

    public function scripts(){
        wp_register_script("ajax_service_temperature", plugins_url( '/', __FILE__ ) . "/assets/js/tempo.js",
            array("jquery"), false, true);
        wp_enqueue_script("ajax_service_temperature");
        wp_localize_script("ajax_service_temperature", "service_temperature",
            array(
                'ip'  => $_SERVER['REMOTE_ADDR']
            )
        );
    }

}

Module_Temperature::instance();