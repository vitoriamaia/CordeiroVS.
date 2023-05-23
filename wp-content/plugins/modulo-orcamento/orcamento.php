<?php

/*
Plugin Name: Módulo Orçamento
Plugin URI: http://www.bindigital.com.br
Description: Budget Module by Tago Pires
Version: 1.0
Author: Tiago Pires (tao.tiago)
Author URI: http://www.bindigital.com.br
*/


class Budget
{

	public static function tables($table){
		global $wpdb;
		$tables = array(
			"receita" => $wpdb->prefix . "budget_income",
			"despesa" => $wpdb->prefix . "budget_expense",
			"cat" => $wpdb->prefix . "budget_category",
		);
		return $tables[$table];
	}
	
	public static function install()
    {
    	global $wpdb;

		# Cria Tabela Receita
		$table = self::tables("receita");
        $wpdb->query("CREATE TABLE IF NOT EXISTS $table (
			id int(11) NOT NULL Auto_Increment,
			data_executar date,
			data_executada date,
			valor decimal(15,2) NOT NULL DEFAULT '0.00',
			status varchar(20),
			PRIMARY KEY (id)
		) CHARACTER SET utf8 COLLATE utf8_general_ci;");

		# Cria Tabela Receita
		$table = self::tables("despesa");
		$wpdb->query("CREATE TABLE IF NOT EXISTS $table (
			id int(11) NOT NULL Auto_Increment,
			data_executar date,
			data_executada date,
			valor decimal(15,2) NOT NULL DEFAULT '0.00',
			multa decimal(5,2) NOT NULL DEFAULT '0.00',
			juros decimal(5,2) NOT NULL DEFAULT '0.00',
			status varchar(20),
			PRIMARY KEY (id)
		) CHARACTER SET utf8 COLLATE utf8_general_ci;");

		# Cria Tabela Receita
		$table = self::tables("cat");
		$wpdb->query("CREATE TABLE IF NOT EXISTS $table (
			id int(11) NOT NULL Auto_Increment,
			nome varchar(20),
			proto varchar(20),
			PRIMARY KEY (id)
		) CHARACTER SET utf8 COLLATE utf8_general_ci;");
		
		# Permissão para acesso ao Orçamento
		$admin_role = get_role( 'administrator' );
		$admin_role->add_cap( 'budget' );
    }

	public static function uninstall()
    {
		global $wpdb;
		$receita = self::tables('receita');
		$despesa = self::tables('despesa');
		$cat = self::tables('cat');

		$wpdb->query("DROP TABLE IF EXISTS $receita");
		$wpdb->query("DROP TABLE IF EXISTS $despesa");
		$wpdb->query("DROP TABLE IF EXISTS $cat");
    }

	// Converte os Meses em Formato Numérico p/ Formato em Extenso (Brasileiro).
	public static function month2Ext($month){
		$monthArr = Array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 =>"Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
		return $monthArr[$month];
	}
	
}

// Método Cria Tabelas do Banco de Dados
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Budget', 'install'));
// Método Apaga Tabelas do Banco de Dados
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Budget', 'uninstall'));

// Orçamento Back
if(is_admin()){
	require_once (dirname(__FILE__).'/html/budget_back.php');
}