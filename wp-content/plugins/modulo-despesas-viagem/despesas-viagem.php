<?php

/*
Plugin Name: Módulo Despesas de Viagem (Insttale)
Plugin URI: http://www.bindigital.com.br
Description: Despesa de Viagem criado por Tiago Pires
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

class Despesas
{
	public static function scripts_back(){
		wp_enqueue_style( "style-expense", plugin_dir_url( __FILE__ )."html/css/style-expense.css" );
		wp_enqueue_script( "script-expense-back", plugin_dir_url( __FILE__ ) . "html/js/script-expense-back.js", array('jquery-ui-datepicker') );
		wp_localize_script( "script-expense-back", "TaoExt", array('url_plugin' => plugin_dir_url( __FILE__ )));
		wp_enqueue_script( "datepicker-pt-BR", plugin_dir_url( __FILE__ ) . "html/js/datepicker-pt-BR.js" );
		wp_enqueue_script( "dataTables", "//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js" );
	}
	
	public static function tables($table){
		global $wpdb;
		$tables = array(
			"viagem" => $wpdb->prefix . "despesas_viagem",
			"gastos" => $wpdb->prefix . "despesas_gastos",
			"cat" => $wpdb->prefix . "despesas_categoria",
			"user" => $wpdb->prefix . "users",
		);
		return $tables[$table];
	}
	
	public static function install()
    {
    	# Cria Tabela Despesas de Viagem
    	global $wpdb;
		$viagem = self::tables('viagem');
		$itens = self::tables('gastos');
		$cat = self::tables('cat');

        $wpdb->query("CREATE TABLE IF NOT EXISTS $viagem ( id int(11) NOT NULL Auto_Increment, identificador varchar(16), criado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, destino text, data_ida date, data_volta date, assunto text, empresa varchar(200), funcionario int(11) NOT NULL, adiantamento decimal(15,2) NOT NULL DEFAULT '0.00', PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");
		$wpdb->query("CREATE TABLE IF NOT EXISTS $itens ( id int(11) NOT NULL Auto_Increment, id_cat int(2), id_viagem int(11), data_despesa date, doc varchar(10), nr_doc varchar(10), pagamento varchar(20), historico varchar(200), valor decimal(7,2) NOT NULL DEFAULT '0.00', PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");
		$wpdb->query("CREATE TABLE IF NOT EXISTS $cat ( id int(11) NOT NULL Auto_Increment, categoria varchar(200), PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");
		
		# Permissão para acesso a Despesas de Viagem
		$admin_role = get_role( 'administrator' );
		$admin_role->add_cap( 'expense' );
    }

	public static function uninstall()
    {
    	# Deleta Tabela Despesas de Viagem
    	global $wpdb;
		$viagem = self::tables('viagem');
		$itens = self::tables('gastos');
		$cat = self::tables('cat');
		
		$wpdb->query("DROP TABLE IF EXISTS $viagem");
		$wpdb->query("DROP TABLE IF EXISTS $itens");
		$wpdb->query("DROP TABLE IF EXISTS $cat");
				
		# Remoção de Acesso a Despesas de Viagem
		$admin_role = get_role( 'administrator' );
		$admin_role->remove_cap( 'expense' );
    }
    
    public static function msgAlert($indice){
    	$msgAlert = array(
    		"reg_ok" => "<p class='msg msg_ok'>Registro salvo com sucesso!</p>",
    		"reg_update" => "<p class='msg msg_ok'>Registro atualizado com sucesso!</p>",
    		"reg_del" => "<p class='msg msg_erro'>Registro excluído com sucesso!</p>",
    	);
    	return $msgAlert[$indice];
    }
    
	public static function users(){
		global $wpdb;
		$user = self::tables('user');
	 	$result = $wpdb->get_results("SELECT ID, user_nicename as Name FROM $user ORDER BY Name ASC ", OBJECT);
	 	$users = "";
		foreach ($result as $value) {
			$users .= "<option value='$value->ID'>$value->Name</option>"; 
		}
		return $users;
	}
	
	public static function user_by_id($id){
		global $wpdb;
		$user = self::tables('user');
	 	$result = $wpdb->get_results("SELECT user_nicename as Name FROM $user WHERE ID='$id' ORDER BY Name ASC ", OBJECT);
	 	$user = "";
		foreach ($result as $value) {
			$user .= $value->Name; 
		}
		return $user;
	}
	
	public static function cat_by_id($id){
		global $wpdb;
		$cat = self::tables('cat');
	 	$result = $wpdb->get_results("SELECT categoria as Cat FROM $cat WHERE id='$id'", OBJECT);
	 	$user = "";
		foreach ($result as $value) {
			$user .= $value->Cat; 
		}
		return $user;
	}
	
	public static function select_table($table){
		global $wpdb;
		$tabela = self::tables($table);
		return $wpdb->get_results( "SELECT * FROM $tabela ORDER BY id DESC", OBJECT );
	}
	
	public static function save_expense()
    {
        global $wpdb;
        $table = self::tables('viagem');

        $dados = array();
		$dados['destino'] = $_POST['destino'];
		$dados['data_ida'] = TK_Convert::date2Sql($_POST['data_ida']);
		$dados['data_volta'] = TK_Convert::date2Sql($_POST['data_volta']);
		$dados['assunto'] = $_POST['assunto'];
		$dados['empresa'] = $_POST['empresa'];
		$dados['adiantamento'] = TK_Convert::val_br2am($_POST['adiantamento']);
		
		if(!isset($_POST['id'])){
			$dados['funcionario'] = $_POST['funcionario'];
			$dados['identificador'] = $_POST['identificador'];
			$wpdb->insert($table, $dados, '%s');
        	wp_redirect( admin_url( 'admin.php?page=despesas&tab=viagem&msg=reg_ok'));
		} else {
			$id = $_POST['id'];
			$wpdb->update($table, $dados, array( 'id' => $id ), array( '%s', '%d' ), array( '%d' ) );
			wp_redirect( admin_url( "admin.php?page=despesas&tab=edit_itens&id=$id&msg=reg_update"));
		}
		
		exit;
   	}
	
	public static function save_expense_item()
    {
        global $wpdb;
        $table = self::tables('gastos');
		
		$id_viagem = $_POST['id_viagem'];

        $dados = array();
		$dados['id_cat'] = $_POST['categoria'];
		$dados['id_viagem'] = $id_viagem;
		$dados['data_despesa'] = TK_Convert::date2Sql($_POST['data_cat']);
		$dados['doc'] = $_POST['tipo_doc'];
		$dados['nr_doc'] = $_POST['nr_doc'];
		$dados['pagamento'] = $_POST['forma_pagamento'];
		$dados['historico'] = $_POST['historico'];
		$dados['valor'] = TK_Convert::val_br2am($_POST['valor_item']);
		
	    $wpdb->insert($table, $dados, '%s');
        wp_redirect( admin_url( "admin.php?page=despesas&tab=edit_itens&id=$id_viagem&msg=reg_ok"));
		
		exit;
   	}
	
	public static function save_cat()
    {
        global $wpdb;
        $table = self::tables('cat');

        $dados = array();
		$dados['categoria'] = $_POST['categoria'];
		
		if(isset($_POST['id'])){
			
			$wpdb->update($table, $dados, array( 'id' => $_POST['id'] ), array( '%s', '%d' ), array( '%d' ) );
			wp_redirect( admin_url( 'admin.php?page=despesas&tab=cat&msg=reg_update'));
			
		} else {
			
			$wpdb->insert($table, $dados, '%s');
			wp_redirect( admin_url( 'admin.php?page=despesas&tab=cat&msg=reg_ok'));
			
		}
		
		exit;
   	}
	
	public static function delete_reg(){
		$table_ref = $_GET['table'];
		$id = $_GET['id'];
		$id_item = $_GET['id_item'];
		
		if(!empty($table_ref) && !empty($id)) :
		
			global $wpdb;
			$table = self::tables($table_ref);
	        $wpdb->query("DELETE FROM $table WHERE id='$id'");
			
			if($table_ref=="gastos"){
				$table_ref = "edit_itens&id=$id_item";
			}
			
			wp_redirect( admin_url( "admin.php?page=despesas&tab=$table_ref&msg=reg_del"));

		endif;

		exit;
	}
	
}

# ----------------------------------------------------------------------------- #

// Call Metode create Data Base
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Despesas', 'install'));

// Call Metode drop Data Base
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Despesas', 'uninstall'));

// Call Scripts and Styles
add_action('admin_enqueue_scripts', array('Despesas', 'scripts_back'));

# ----------------------------------------------------------------------------- #


// Function Registra Fatura
add_action('wp_ajax_save_expense', array('Despesas', 'save_expense'));

// Function Registra Fatura
add_action('wp_ajax_save_expense_item', array('Despesas', 'save_expense_item'));

// Function Registra Fatura
add_action('wp_ajax_save_category', array('Despesas', 'save_cat'));

// Function Export Register Cadastre
add_action('wp_ajax_delete_reg', array('Despesas', 'delete_reg'));

# ----------------------------------------------------------------------------- #

// Faturamento Back
require_once (dirname(__FILE__).'/html/expense_back.php');
