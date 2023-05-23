<?php

/*
Plugin Name: Tao Form Ajax
Plugin URI: http://www.bindigital.com.br
Description: Tao Form Ajax BinDigital
Version: 1.5
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

class Tao_Form
{
	public static function callall()
	{
		wp_enqueue_script( "request-tao-form", plugin_dir_url( __FILE__ ) . "html/js/ajax.js", array('jquery') );  
		wp_localize_script( "request-tao-form", "TaoAjax", array( 
			'ajaxSave' => admin_url( 'admin-ajax.php?action=save_form' )
		));
	}

	public static function table()
	{
		global $wpdb;
		$table = $wpdb->prefix."tao_form";
		return $table;	
	}

    public static function install()
    {
    	global $wpdb;
		$table = self::table();
        $wpdb->query("CREATE TABLE IF NOT EXISTS $table ( id int NOT NULL Auto_Increment, nome varchar(50), email varchar(50), Data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");
    }

    public static function uninstall()
    {
		global $wpdb;
        $table = self::table();
		$wpdb->query("DROP TABLE IF EXISTS $table");
    }

    public static function save_form()
    {
        global $wpdb;
        $table = self::table();
	    $dados = array();
	    $dados['nome'] = $_POST['nome'];
	    $dados['email'] = $_POST['email'];
	    $wpdb->insert($table, $dados, '%s');
        die($wpdb->last_error);
    }
	
	public static function reg_num()
	{
		global $wpdb;
        $table = self::table();
        $reg_num = count($wpdb->get_results("SELECT id FROM $table"));
		return $reg_num;
	}

	public static function delete_mails()
	{
		global $wpdb;
        $table = self::table();
        $wpdb->query("DELETE FROM $table");
        wp_redirect(admin_url( 'admin.php?page=export_contact&m=del'));
        exit;
	}
	
	public static function exportMysqlToCsv()
	{
		global $wpdb;
		$table = self::table();
	    
	    $csv_separator = ";";
	    $csv_enclosed = '"';
	    $csv_escaped = "\\";
	    $csv_terminated = "\n";
	    $schema_insert = "";
	    $out = array();

	    $sql_query = $wpdb->get_results("SELECT * FROM $table", ARRAY_N);

	    foreach ($sql_query as $line) {

	    	foreach ($line as $element) {

				$schema_insert .= 
	    			$csv_enclosed . 
	    				str_replace( $csv_enclosed, $csv_escaped . $csv_enclosed, stripslashes($element) ) .
	    			$csv_enclosed;
	    		$schema_insert .= $csv_separator;

		    }

		    $schema_insert = trim(substr($schema_insert, 0, -1));
		    $schema_insert .= $csv_terminated;

		    $out[] = $schema_insert;

		    $schema_insert = "";

	    }

    	foreach ($out as $out_finish) {
			$schema_insert .= $out_finish;	    	
	    }

		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Content-Length: " . strlen($schema_insert));
	    header("Content-type: text/csv");
	    header("Content-Disposition: attachment; filename='registros.csv'");
	    echo $schema_insert;
	    exit;
	}

}

# -----------------------------------------------------------------------------#
// Chama Métode Instalação
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Tao_Form', 'install'));
// Chama Métode Desinstalação
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Tao_Form', 'uninstall'));

# -----------------------------------------------------------------------------#
// Função Salva Formulário
add_action('wp_ajax_save_form', array('Tao_Form', 'save_form'));
add_action('wp_ajax_nopriv_save_form', array('Tao_Form', 'save_form'));

// Função Exporta Cadastros Registrados
add_action('wp_ajax_exportMysqlToCsv', array('Tao_Form', 'exportMysqlToCsv'));

// Função Deleta Registros
add_action('wp_ajax_delete_mails', array('Tao_Form', 'delete_mails'));

# -----------------------------------------------------------------------------#
// Widget Formulário Cadastro
class Tao_Form_WG extends WP_Widget {

	public function __construct() {
		// Identificador do widget
    	$id_base = 'tao_form';
    	// Nome do Widget que será exibido
    	$name = 'Formulário Mailling';
    	// Adicionado Descrição do widget
    	$widget_options = array('description' => 'Formulário Captura de Emails');
		
		parent::__construct($id_base, $name, $widget_options);
	}
	
	public function widget($args, $instance) {
		require_once (dirname(__FILE__).'/html/form-cadastro.php');
	}
	
}

// Função para registar o widget
function tao_form(){
    //Registra o widget que criamos
     register_widget( 'Tao_Form_WG' );
}

// Com função add_action, atribuimos uma função, usando o gancho widgets_init
add_action( 'widgets_init', 'tao_form' );

// Insira em uma página o seguinte código [form_mailing] para que seja exibido o formulario
add_shortcode('form_mailing', array( 'Tao_Form_WG', 'widget' ));

// Scripts e Styles
add_action( 'wp_enqueue_scripts', array( 'Tao_Form', 'callall'));

// Formulário Back-end
require_once (dirname(__FILE__).'/html/form-export.php');
