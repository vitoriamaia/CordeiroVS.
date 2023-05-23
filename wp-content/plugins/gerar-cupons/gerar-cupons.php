<?php

/*
Plugin Name: Módulo Gerador de Cupons
Plugin URI: http://www.bindigital.com.br
Description: Módulo Gerador de Cupons.
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

/* --------------------------------------------------------------------------------- */
/* Gerador de Cupons */
add_action( 'plugins_loaded', array( 'Coupons_Generate', 'init' ));

// Call Metode create Data Base
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Coupons_Generate', 'install'));

// Call Metode drop Data Base
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Coupons_Generate', 'uninstall'));

class Coupons_Generate{

	public static function tables($table){
		global $wpdb;
		$tables = array(
			"coupons" => $wpdb->prefix . "coupons",
			"coupons_down" => $wpdb->prefix . "coupons_down",
		);
		return $tables[$table];
	}

	public static function install()
	{
		# Cria Tabelas Necessárias
		global $wpdb;
		$coupons = self::tables('coupons');
		$coupons_down = self::tables('coupons_down');

		$wpdb->query("CREATE TABLE IF NOT EXISTS $coupons ( id int(11) NOT NULL Auto_Increment, code_coupon varchar(21), id_emporium int(4), id_user int(5), id_cat int(2), date_generate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");
		$wpdb->query("CREATE TABLE IF NOT EXISTS $coupons_down ( id int(11) NOT NULL Auto_Increment, id_coupon varchar(21), id_emporium int(4), id_user int(5), id_cat int(2), date_generate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");

		# Permissão para acesso as estatísticas
		$admin_role = get_role( 'administrator' );
		$admin_role->add_cap( 'coupons' );
		$admin_role->add_cap( 'record-logs' );

		# Cria Página Baixa
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='baixa'", ARRAY_N);
		if(empty($pageRel)){
			$arg = array(
				'post_name'=>'baixa',
				'post_title' => 'Baixa',
				'post_status' => 'publish',
				'post_type' => 'page',
				'menu_order' => 100,
				'post_content' => '[baixa]'
			);
			wp_insert_post( $arg );
		}
	}

	public static function uninstall()
	{
		# Deleta Tabelas Necessárias
		global $wpdb;
		$coupons = self::tables('coupons');
		$coupons_down = self::tables('coupons_down');

		$wpdb->query("DROP TABLE IF EXISTS $coupons");
		$wpdb->query("DROP TABLE IF EXISTS $coupons_down");

		# Remoção de Acesso a Despesas de Viagem
		$admin_role = get_role( 'administrator' );
		$admin_role->remove_cap( 'coupons' );
		$admin_role->remove_cap( 'record-logs' );
	}

	public static function init() {
		$class = __CLASS__;
		new $class;
	}

	public function __construct() {
		add_action('admin_enqueue_scripts', array($this, 'scripts_back'));

		// Redirecionamento na Página Baixa
		add_action('wp_head', array($this, 'redirect_down'));

		// Formulário de Baixa de Cupom
		add_shortcode('baixa', array( $this, 'form_coupon_down' ));

		// Baixa em Cupom
		add_action('wp_ajax_coupon_down', array($this, 'coupon_down'));
		add_action('wp_ajax_nopriv_coupon_down', array($this, 'coupon_down'));

		// Criar cupom
		add_action('wp_ajax_create_coupon', array($this, 'create_coupon'));
		add_action('wp_ajax_nopriv_create_coupon', array($this, 'create_coupon'));

		// Filtro de Mensagens da Baixa do Cupom
		add_filter('the_content', array($this, 'msg_return'));

		// Insere menu de Estatística
		add_action('admin_menu', array($this, 'options_admin'));

	}

	public function scripts_back(){
		wp_enqueue_style( "style-statistic", plugin_dir_url( __FILE__ )."html/css/style-statistic.css" );
		wp_enqueue_script( "data-tables", plugin_dir_url( __FILE__ )."html/js/jquery.dataTables.min.js" );
		wp_enqueue_script( "script-coupon", plugin_dir_url( __FILE__ )."html/js/script-logs-back.js" );
		wp_localize_script( "script-coupon", "CouponExt", array('url_plugin' => plugin_dir_url( __FILE__ )));
	}

	// Redirecionamento para dar baixa no cupom
	public function redirect_down(){
		if(is_page('baixa') && !is_user_logged_in()) :
			wp_redirect( Wp_Home . "/wp-login.php?redirect_to=" . Wp_Home . "/baixa" );
			exit;
		elseif (is_page('baixa') && is_user_logged_in() && !current_user_can('coupons')  ) :
			wp_redirect( Wp_Home );
			exit;
		endif;
	}

	// Formulário para dar baixa
	public function form_coupon_down(){
		ob_start();
		include_once( dirname(__FILE__) . '/html/form_coupon_down.php');
		$content = ob_get_clean();
		return $content;
	}

	// Função para dar baixa no cupom
	public function coupon_down(){

		global $wpdb;
		$coupon = self::tables('coupons');
		$coupon_down = self::tables('coupons_down');

		// Cupom
		$coupon_code = $_POST['coupon'];

		$year_now = date('Y');
		$month_now = date('m');
		$day_now = date('d');

		$result_coupon = $wpdb->get_results( "SELECT * FROM $coupon WHERE code_coupon='$coupon_code' AND YEAR(date_generate)= $year_now AND MONTH(date_generate)= $month_now AND DAY(date_generate)= $day_now" );

		if(!empty($result_coupon)) {

			$result_coupon_down = $wpdb->get_results( "SELECT id_coupon FROM $coupon_down WHERE id_coupon='$coupon_code'" );
			if(!empty($result_coupon_down)){

				wp_redirect( Wp_Home . "/baixa?result=no_down_coupon" );

			} else {

				$dados = array();
				$dados['id_coupon'] = $coupon_code;
				$dados['id_emporium'] = $result_coupon[0]->id_emporium;
				$dados['id_user'] = $result_coupon[0]->id_user;
				$dados['id_cat'] = $result_coupon[0]->id_cat;
				$wpdb->insert($coupon_down, $dados, '%s');
				wp_redirect( Wp_Home . "/baixa?result=down_coupon" );

			}

		} else {

			wp_redirect( Wp_Home . "/baixa?result=no_coupon" );

		}

		exit;

	}

	public function create_coupon()
	{

		if(!is_user_logged_in()){

			auth_redirect();

		} else {

			global $wpdb;
			$table = self::tables('coupons');
			$slug = basename($_GET['permalink']);

			// Pegar ID Promo
			$id_promo = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_name = '$slug'");
			$id_promo = $id_promo->ID;

			// ID Estabelecimento
			$id_emporium = get_field('estabelecimento', $id_promo);
			$id_emporium = $id_emporium->ID;

			// ID Cliente
			$current_user = wp_get_current_user();
			$id_user = $current_user->ID;
			$id_user = str_pad($id_user, 4, "0", STR_PAD_LEFT);

			// ID Cat
			$cat = get_the_category( $id_promo );
			$id_cat = $cat[0]->term_id;

			// ID Promo
			$id_promo = str_pad($id_promo, 4, "0", STR_PAD_LEFT);

			// Código do Cupom
			$data = date('d/m/Y');
			list($day, $month, $year) = explode('/', $data);
			$code_coupon = $year . "." . $month.$day . ".1." . $id_promo . "." . $id_user;

			$result_coupon = $wpdb->get_results( "SELECT code_coupon FROM $table WHERE code_coupon='$code_coupon'" );

			if(empty($result_coupon)){

				// Dados de Entrada
				$dados = array();
				$dados['code_coupon'] = $code_coupon;
				$dados['id_emporium'] = $id_emporium;
				$dados['id_user'] = $id_user;
				$dados['id_cat'] = $id_cat;

				$wpdb->insert($table, $dados, '%s');

			}

			include_once( dirname(__FILE__) . '/html/coupon_print.php');

			exit;

		}

	}

	public function msg_return($content){
		# Mensagens para Baixa de Cupons
		$my_msg = array(
			"no_down_coupon" => "<p class='msg-alert'>Este cupom j&aacute; foi dado baixa.</p>",
			"down_coupon" => "<p class='msg-alert'>Cupom dado baixa com sucesso.</p>",
			"no_coupon" => "<p class='msg-alert'>Cupom inexistente ou fora da validade, favor verificar o c&oacute;digo.</p>"
		);

		# Remoção de Tags do Conteúdo
		$array = array (
			'<pre>[' => '[',
			']</pre>' => ']',
			']<br />' => ']'
		);
		$content = strtr($content, $array);

		# Verifica se tem retorno e dá a mensagem correspondente
		if(isset($_GET['result'])){
			return $my_msg[$_GET['result']] . $content;
		} else {
			return $content;
		}
	}

	public function options_admin () {
		add_menu_page(
			'Estatísticas',
			'Estatísticas',
			'record-logs',
			'record-logs',
			array($this, 'options_functions'),
			'dashicons-chart-bar',
			50
		);
	}

	public function options_functions() {
		require_once (dirname(__FILE__).'/html/record-logs-back.php');
	}

}