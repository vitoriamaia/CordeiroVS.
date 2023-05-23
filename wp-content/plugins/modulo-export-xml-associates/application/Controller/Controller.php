<?php

include_once(BASE . '/application/Model/Model.php');
include_once(BASE . '/application/View/View.php');

class Controller_XML_Associates extends Model_XML_Associates
{

    private $Model;
    private $View;

    public function __construct()
    {

        // Carrega o Model e View
        $this->Model = new Model_XML_Associates();
        $this->View = new View_XML_Associates();

        // Chama Métode Instalação
        register_activation_hook( BASE . DIRECTORY_SEPARATOR . FILE, array( $this->Model , 'install'));
        // Chama Métode Desinstalação
        register_deactivation_hook( BASE . DIRECTORY_SEPARATOR . FILE, array( $this->Model , 'uninstall'));

        // Campos dos médicos
        add_action ("init", array ($this->Model, "get_fields_acf"));

        // Função Exporta Cadastros Registrados
        add_action('wp_ajax_ExportMysqlToXML', array($this->Model, 'ExportMysqlToXML'));

        // Menu Admin (Exportação XML)
        add_action('admin_menu', array($this, 'options_menu_admin'));

        // Scripts
        add_action('admin_enqueue_scripts', array($this->View, 'call_back'));

    }

    // Menu Admin
    public function options_menu_admin() {
        add_menu_page(
            'Exportar XML',
            'Exportar XML',
            'export_xml',
            'export_xml',
            array($this, 'get_options_menu_admin'),
            'dashicons-yes'
        );
    }

    // Get Menu Admin
    public function get_options_menu_admin(){

        echo $this->View->render('form/options_menu_admin');

    }

}