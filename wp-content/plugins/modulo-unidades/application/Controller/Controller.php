<?php

namespace application\Controller;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use application\Model\Model;
use application\View\View;

class Controller{

    private $Model;
    private $View;

    public function __construct(){
        $this->Model = new Model();
        $this->View = new View();

        // Sele��o de Registro de Tabelas
        add_filter('select_table', array($this->Model, 'select_table'), 10, 1);

        // Sele��o de Registro de Tabelas por ID
        add_filter('select_table_id', array($this->Model, 'select_table_id'), 10, 2);

        // Salva Unidades
        add_action('wp_ajax_save_unities', array($this->Model, 'save_unities'));

        // Salva Regi�o
        add_action('wp_ajax_save_regions', array($this->Model, 'save_regions'));

        // json regi�es
        add_action('wp_ajax_display_cities', array($this->Model, 'get_cities'));
        add_action('wp_ajax_nopriv_display_cities', array($this->Model, 'get_cities'));

        // json unidades
        add_action('wp_ajax_display_unity', array($this->Model, 'get_unity'));
        add_action('wp_ajax_nopriv_display_unity', array($this->Model, 'get_unity'));

        // Exclui Registro
        add_action('wp_ajax_delete_reg', array($this->Model, 'delete_reg'));

        // Chamadas Front
        add_action('wp_enqueue_scripts', array($this->View, 'call_front'));

        // Chamadas Back
        add_action('admin_enqueue_scripts', array($this->View, 'call_back'));

        // Menu Admin
        add_action('admin_menu', array($this->View, 'options_menu_admin'));
    }

    public function get_model(){
        return $this->Model;
    }

    public function get_view(){
        return $this->View;
    }

    public function install(){
        $this->Model->create_tables();
    }

    public function uninstall(){
        $this->Model->drop_tables();
    }

}