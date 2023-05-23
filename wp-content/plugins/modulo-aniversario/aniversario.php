<?php

/*
Plugin Name: Módulo Aniversário
Plugin URI: http://www.bindigital.com.br
Description: Módulo de exibição de prefeitos e municípios aniversariantes
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class Birthday
{

    protected static $_instance = null;

    protected $Model = null;
    protected $View = null;

    public function __construct()
    {
        $this->includes();
        $this->init();
    }

    public function init(){
        // HTML Aniversário
        add_shortcode('birthday', array($this, 'get_birthday'));

        // Chamadas de Scripts
        add_action('wp_enqueue_scripts', array($this->View, 'call_birthday'));

        // Lista de aniversários JSON
        add_action('wp_ajax_birthday_all', array($this->Model, 'birthday_all'));
        add_action('wp_ajax_nopriv_birthday_all', array($this->Model, 'birthday_all'));
    }

    public static function instance(){

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    public function plugin_url() {
        return untrailingslashit( plugins_url( '/', __FILE__ ) );
    }

    public function plugin_assets() {
        return $this->plugin_url() . '/application/html/assets';
    }

    public function includes(){

        include_once('application/Model.php');
        include_once('application/View.php');

        if ( is_null( $this->Model ) ) $this->Model = new Model_Birthday();

        if ( is_null( $this->View ) ) $this->View = new View_Birthday();

    }

    public function get_birthday(){
        return $this->View->render('html/birthday');
    }

}

function MBDay(){
    return Birthday::instance();
}

MBDay();