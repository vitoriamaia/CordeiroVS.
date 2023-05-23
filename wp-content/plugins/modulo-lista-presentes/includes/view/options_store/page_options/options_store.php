<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MLP_Option_Store
{

    public static function init()
    {
        // Menu Opções da Loja
        add_action('admin_menu', array(__CLASS__, 'options_store'));

        // Campos da Página de Opções e Estatísticas
        add_action( 'admin_init', array(__CLASS__, 'options_store_settings' ));
    }

    public static function options_store(){

        add_menu_page(
            'Opções da Loja',
            'Configurações da Lista de Presentes',
            'options_store_list',
            'options_store',
            array(__CLASS__, 'options_store_html'),
            'dashicons-hammer',
            99
        );

    }

    public static function options_store_html(){
        include_once('options_store_html.php');
    }

    public static function options_store_settings() {
        register_setting( 'options_store_settings', 'email_pagseguro' );
        register_setting( 'options_store_settings', 'token_pagseguro' );
        register_setting( 'options_store_settings', 'percent_commission' );
        register_setting( 'options_store_settings', 'message_congratulations' );
        register_setting( 'options_store_settings', 'enable_ratification' );
        register_setting( 'options_store_settings', 'token_pagseguro_sendbox' );
    }

}

MLP_Option_Store::init();