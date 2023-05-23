<?php

/*
Plugin Name: Módulo Faturamento
Plugin URI: http://www.bindigital.com.br
Description: Tao Faturamento criado por Tiago Pires
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/


class Faturamento
{
	public static function table(){
		global $wpdb;
		$table = $wpdb->prefix."billing";
		return $table;
	}
	
	public static function install()
    {
    	# Cria Tabela Faturamento
    	global $wpdb;
		$table = self::table();
        $wpdb->query("CREATE TABLE IF NOT EXISTS $table ( id int(11) NOT NULL Auto_Increment, data date, fatura decimal(15,2) NOT NULL DEFAULT '0.00', empresa varchar(20), PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");
		
		# Cria Página Faturamento Privado
		$pageFatura = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='faturamento'");
		if(empty($pageFatura)){
			$arg = array(
				'post_name'=>'faturamento',
				'post_title' => 'Faturamento',
				'post_status' => 'private',
				'post_type' => 'page',
				'menu_order' => 1000,
				'post_content' => '[invoice]',
				'page_template' => 'padrao-restrito.php'
			);
			wp_insert_post( $arg );
		}
		
		# Cria Página Relatório Privado
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='relatorio'");
		if(empty($pageRel)){
			$arg = array(
				'post_name'=>'relatorio',
				'post_title' => 'Relatório de Faturamento',
				'post_status' => 'private',
				'post_type' => 'page',
				'menu_order' => 1001,
				'post_content' => '[report]',
				'page_template' => 'padrao-restrito.php'
			);
			wp_insert_post( $arg );
		}
		
		# Permissão para acesso ao Faturamento
		$admin_role = get_role( 'administrator' );
		$admin_role->add_cap( 'invoice' );
		$admin_role->add_cap( 'invoice_view' );
    }

	public static function uninstall()
    {
    	# Deleta Tabela Faturamento
    	global $wpdb;
		$table = self::table();
		$wpdb->query("DROP TABLE IF EXISTS $table");
		$wpdb->query("DELETE FROM $wpdb->posts WHERE post_name='faturamento' OR post_name='relatorio'");
			
		# Remoção de acesso ao Faturamento
		$admin_role = get_role( 'administrator' );
		$admin_role->remove_cap( 'invoice' );
		$admin_role->remove_cap( 'invoice_view' );
    }
	
	public static function scripts_back(){
		wp_enqueue_style( "style-fatura", plugin_dir_url( __FILE__ )."html/css/style-fatura.css" );

		wp_enqueue_script( "dataTables", "//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js" );

		wp_enqueue_script( "script-fatura-back", plugin_dir_url( __FILE__ ) . "html/js/script-fatura-back.js", array('jquery-ui-datepicker') );
		wp_localize_script( "script-fatura-back", "TaoExt", array('url_plugin' => plugin_dir_url( __FILE__ )));

		wp_enqueue_script( "datepicker-pt-BR", plugin_dir_url( __FILE__ ) . "html/js/datepicker-pt-BR.js" );
		wp_register_script( "formzin", plugin_dir_url( __FILE__ ) . "html/js/formzin-1.0.2.min.js", array(), "1.0", true );
		wp_enqueue_script( "formzin" );
	}
	
	public static function scripts_front(){

		if( is_page(array('pagename'=>'faturamento')) || is_page (array('pagename'=>'relatorio')) ){

			wp_enqueue_script( "script-fatura-graficos", plugin_dir_url( __FILE__ ) . "html/js/graficos.js" );
			wp_enqueue_script( "script-fatura-exec", plugin_dir_url( __FILE__ ) . "html/js/script-fatura-exec.js", array('jquery-ui-datepicker') );
			wp_enqueue_script( "datepicker-pt-BR", plugin_dir_url( __FILE__ ) . "html/js/datepicker-pt-BR.js" );
			wp_localize_script("script-fatura-exec", "ObjFat", array( 'ajaxFat' => admin_url( 'admin-ajax.php?action=api_fatura' )));
			wp_enqueue_style( "style-fatura-relatorio", plugin_dir_url( __FILE__ )."html/css/style-fatura-front.css" );
		
		} 
			
	}
	
	public static function save_fatura()
    {
        global $wpdb;
        $table = self::table();
		
		if($_POST['data']!="" && $_POST['faturamento']!="")
		{

			$dataStr = TK_Convert::date2Sql($_POST['data']);
			$year = substr($dataStr, 0, 4);
			$month = substr($dataStr, 4, 2);

			$empresa = $_POST['cliente'];

			$checkExists = $wpdb->get_results(" SELECT * FROM $table WHERE YEAR(data) = '$year' AND MONTH(data) = '$month' AND empresa = '$empresa' ");

			if(empty($checkExists))
			{
				$dados = array();
				$dados['data'] = $dataStr;

				$ano = substr($dados['data'], 0, 4);
			    $dados['fatura'] = TK_Convert::val_br2am($_POST['faturamento']);

			    $dados['empresa'] = $empresa;

			    $wpdb->insert($table, $dados, '%s');
		        wp_redirect( admin_url( "admin.php?page=faturamento&msg=ok&ano=$ano&id=$empresa"));
			} 
			
			else 
			{ 
				wp_redirect( admin_url( "admin.php?page=faturamento&msg=dataexist&id=$empresa"));
			}
			
		} 
		
		else 
		{
			wp_redirect( admin_url( "admin.php?page=faturamento&msg=erro&id=$empresa"));
		}
			
		exit;
    }
	
	public static function delete_fatura(){
		if(current_user_can('invoice')) {
			global $wpdb;
			$table = self::table();
			$id = $_GET['ID'];
			$user = $_GET['user'];
	        $wpdb->query("DELETE FROM $table WHERE id='$id'");
			wp_redirect( admin_url( "admin.php?page=faturamento&msg=delete&id=$user"));
		}
		exit;
	}
	
	public static function api_fatura(){
		if(current_user_can('invoice_view')) {
			global $wpdb;
			$table = self::table();
			$ano = date('Y');
			$empresa = get_current_user_id();
	        $result = $wpdb->get_results("SELECT Fatura, MONTH(data) FROM $table WHERE YEAR(data) = '$ano' AND empresa = '$empresa' ORDER BY MONTH(data) ASC", ARRAY_N);
			$result = json_encode($result);
			print $result;
		}
		exit;
	}
	
	public static function Faturamento_Front(){
		require_once (dirname(__FILE__).'/html/invoice_front.php');	
	}
	
	public static function Report_Front(){
		require_once (dirname(__FILE__).'/html/gen_report.php');	
	}

}

# ----------------------------------------------------------------------------- #

// Call Metode create Data Base
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Faturamento', 'install'));
// Call Metode drop Data Base
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Faturamento', 'uninstall'));

// Call Scripts and Styles
add_action('admin_enqueue_scripts', array('Faturamento', 'scripts_back'));
add_action('wp_enqueue_scripts', array('Faturamento', 'scripts_front'));

# ----------------------------------------------------------------------------- #

// Function Registra Fatura
add_action('wp_ajax_save_fatura', array('Faturamento', 'save_fatura'));

// Function Export Register Cadastre
add_action('wp_ajax_delete_fatura', array('Faturamento', 'delete_fatura'));

// Function Export Register Cadastre
add_action('wp_ajax_api_fatura', array('Faturamento', 'api_fatura'));

# ----------------------------------------------------------------------------- #

// Faturamento Back
require_once (dirname(__FILE__).'/html/invoice_back.php');

// Faturamento Front
add_shortcode('invoice', array( 'Faturamento', 'Faturamento_Front' ));

// Report Front
add_shortcode('report', array( 'Faturamento', 'Report_Front' ));
