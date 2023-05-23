<?php

/*
Plugin Name: Módulo Gravação Logs
Plugin URI: http://www.bindigital.com.br
Description: Tao Record Logs criado por Tiago Pires
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/


class Record_Logs
{
	public static function table_logs(){
		global $wpdb;
		$table = $wpdb->prefix."table_logs";
		return $table;
	}
	
	public static function install()
    {
    	# Cria Tabela table_logs
    	global $wpdb;
		$table = self::table_logs();
        $wpdb->query("CREATE TABLE IF NOT EXISTS $table ( id int(11) NOT NULL Auto_Increment, data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, restaurante varchar(20), associado varchar(30), termo varchar(20), PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");
    }

	public static function uninstall()
    {
    	# Deleta Tabela table_logs
    	global $wpdb;
		$table = self::table_logs();
		$wpdb->query("DROP TABLE IF EXISTS $table");
    }
	
	public static function scripts_back(){
		wp_enqueue_style( "style-logs", plugin_dir_url( __FILE__ )."html/css/style-logs.css" );

		wp_enqueue_script( "dataTables", plugin_dir_url( __FILE__ ) . "html/js/jquery.dataTables.min.js", array('jquery') );
		wp_enqueue_script( "script-logs-back", plugin_dir_url( __FILE__ ) . "html/js/script-logs-back.js" );
		wp_localize_script( "script-logs-back", "TaoExt", array('url_plugin' => plugin_dir_url( __FILE__ )));
	}

	public static function exportMysqlToCsv()
	{

		global $wpdb;
		$table = self::table_logs();
	    
	    $csv_separator = ";";
	    $csv_enclosed = '"';
	    $csv_escaped = "\\";
	    $csv_terminated = "\n";
	    $schema_insert = "";
	    $out = array();

	    $resto = $_GET['id'];

	    $sql_query = $wpdb->get_results("SELECT data, associado, termo FROM $table WHERE restaurante = '$resto'", ARRAY_N);

	    $out[] = "Data pesquisa" . $csv_separator . "Associado" . $csv_separator . "Termo buscado" . $csv_terminated;

	    foreach ($sql_query as $line) {

	    	foreach ($line as $element) {

				$schema_insert .= 
	    				str_replace( $csv_enclosed, $csv_escaped . $csv_enclosed, stripslashes($element) );
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

# ----------------------------------------------------------------------------- #

// Call Metode create Data Base
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Record_Logs', 'install'));
// Call Metode drop Data Base
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Record_Logs', 'uninstall'));

// Call Scripts and Styles
add_action('admin_enqueue_scripts', array('Record_Logs', 'scripts_back'));

// Exporte Registers
add_action('wp_ajax_exportMysqlToCsv', array('Record_Logs', 'exportMysqlToCsv'));

# ----------------------------------------------------------------------------- #

// Record_Logs Back
require_once (dirname(__FILE__).'/html/record-logs-back.php');