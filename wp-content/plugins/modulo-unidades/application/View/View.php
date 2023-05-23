<?php

namespace application\View;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class View{

    private $html;

    public function render($file) {

        $file = dirname(__FILE__) . '/' . $file . '.phtml';

        if (file_exists($file)) :

            ob_start();
            require($file);
            $this->html = ob_get_clean();
            //ob_end_flush();

        else :

            $this->html = "O arquivo $file não existe";

        endif;

        return $this->html;

    }

    public function call_front(){

        // json
        wp_enqueue_script( "json_unities" , plugin_dir_url( __FILE__ ) . "build/js/get_json.js", array('jquery'), "1.0", true);
        // json regiões e unidades
        wp_localize_script( "json_unities", "unities", array(
            'display_city' => admin_url( 'admin-ajax.php?action=display_cities' ),
            'display_unity' => admin_url( 'admin-ajax.php?action=display_unity' )
        ));

    }

    public function call_back(){

        // Scripts Gerais
        wp_enqueue_style( "style_list" , plugin_dir_url( __FILE__ ) . "build/css/style-list.css", array(), "1.0", false);

        // Data Table
        wp_enqueue_script( "datatables" , plugin_dir_url( __FILE__ ) . "build/js/jquery.dataTables.min.js", array('jquery'), "1.0", true);

        // Cidades/Estados
        wp_enqueue_script( "cities-states" , plugin_dir_url( __FILE__ ) . "build/js/cidades-estados-1.4.js", array(), "1.0", false);

        // Scripts Gerais
        wp_enqueue_script( "general" , plugin_dir_url( __FILE__ ) . "build/js/script.js", array(), "1.0", true);

    }

    public function msg_alert($index = null, $msg = null){
        $msg_alert = array(
            "reg_insert" => "Registro salvo com sucesso!",
            "reg_update" => "Registro atualizado com sucesso!",
            "reg_del" => "Registro excluído com sucesso!",
            "reg_personal" => $msg
        );

        if($index === null || !array_key_exists($index, $msg_alert)) return false;

        $container = "<div class='updated'><p>$msg_alert[$index]</p></div>";
        return $container;
    }

    public function options_menu_admin(){
        add_menu_page(
            'Cadastro de unidades',
            'Cadastro de unidades',
            'unities',
            'unities',
            array($this, 'unities'),
            'dashicons-yes'
        );
    }

    public function unities(){

        echo $this->render('forms/unities');

    }

}