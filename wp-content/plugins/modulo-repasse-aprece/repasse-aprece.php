<?php

/*
Plugin Name: Módulo Repasse
Plugin URI: http://www.bindigital.com.br
Description: Formulário de integração de repasse Aprece
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class Pass_Through
{

    protected static $_instance = null;

    protected $Model = null;
    protected $View = null;

    public function __construct()
    {
        $this->includes();
        $this->init();
        $this->init_hooks();
    }

    public static function instance(){

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    public function includes(){

        include_once('application/Model.php');
        include_once('application/View.php');

        if ( is_null( $this->Model ) ) $this->Model = new Model_Pass_Through();

        if ( is_null( $this->View ) ) $this->View = new View_Pass_Through();

    }

    public function init(){
        // Verificação POST
        $this->Model->v_post();
        
        // Envio de CSV
        add_action('wp_ajax_submit_csv', array($this->Model, 'submit_csv'));

        // Chamadas de Scripts
        add_action('admin_enqueue_scripts', array($this->View, 'call_pass_through'));

        // Menu Repasse
        add_action('admin_menu', array($this, 'options_admin_pass_through'));

        // Formulário de Pesquisa de Finanças
        add_shortcode('form_pass_through', array($this, 'get_form_pass_through'));

        // Finanças Post
        add_shortcode('form_pass_through_post', array($this, 'get_form_pass_through_post'));
    }

    private function init_hooks(){
        register_activation_hook( __FILE__, array( $this->Model, 'install' ) );
        register_activation_hook( __FILE__, array( $this->Model, 'uninstall' ) );
    }

    public function plugin_url() {
        return untrailingslashit( plugins_url( '/', __FILE__ ) );
    }

    public function plugin_assets() {
        return $this->plugin_url() . '/application/html/assets';
    }

    public function options_admin_pass_through() {
        add_menu_page(
            'Finanças Públicas',
            'Finanças Públicas',
            'manage_options',
            'financas',
            array($this, 'get_pass_through'),
            'dashicons-yes'
        );
    }

    // Formulário administrativo
    public function get_pass_through() {
        echo $this->View->render('html/form/options_menu_admin');
    }

    // Pega a lista de Prefeituras
    public function get_town_hall(){
        return $this->Model->town_hall();
    }

    // Pega tabelas
    public function get_tables($table){
        return $this->Model->tables($table);
    }

    // Pega resultado da consulta de finanças
    public function get_wherewithal(){
        return $this->Model->wherewithal();
    }

    // Pega atributos da consulta de repasse
    public function get_data_attributes(){
        return $this->Model->data_attributes();
    }

    // Formuário de Pesquisa
    public function get_form_pass_through(){
        return $this->View->render('html/form/form_pass_through');
    }

    // Formuário de Pesquisa com lista de repasse (Post)
    public function get_form_pass_through_post(){
        return $this->View->render('html/form/form_pass_through_post');
    }

    // Mostra os meses por extenso
    public function get_months(){
        return Array(
            1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho",
            7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro"
        );
    }

    // Essa função pega um número em formato americano e põe no nosso formato nacional!
    public function num_am2br($numero) {
        $elem_tmp = number_format($numero,2);
        $elem_tmp = str_replace(",",";",$elem_tmp);
        $elem_tmp = str_replace(".",",",$elem_tmp);
        $elem_tmp = str_replace(";",".",$elem_tmp);

        return ($elem_tmp != 0) ? $elem_tmp : "-";
    }

}

function MPThrough(){
    return Pass_Through::instance();
}

MPThrough();