<?php

/*
Plugin Name: Módulo Perfil
Plugin URI: http://www.bindigital.com.br
Description: Tao Profile BinDigital
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/


class Tao_Profile{

	// Checa se Existe Página Inicial da Área Restrita
	public static function install()
    {
    	global $wpdb;
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='perfil'", ARRAY_N);
		if(empty($pageRel)){
			$arg = array(
				'post_name'=>'perfil',
				'post_title' => 'Perfil',
				'post_status' => 'private',
				'post_type' => 'page',
				'menu_order' => 100,
				'post_content' => '[tao_edit_profile]',
				'page_template' => 'area-restrita.php'
			);
			wp_insert_post( $arg );
		}
    }

    // Checa se Existe Página Inicial da Área Restrita e Deleta
	public static function uninstall()
    {
    	global $wpdb;
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='perfil'", ARRAY_N);

		if(!empty($pageRel)){
			$pageRel = $pageRel[0][0];
			$wpdb->query("DELETE FROM $wpdb->posts WHERE ID = $pageRel");
		}
    }
	
	// Script Save Profile
	public static function user(){
		if(!wp_script_is( "mask", $list = 'registered' )){
			wp_register_script( "mask" , plugin_dir_url( __FILE__ ) . "html/js/mask.js", array(), '1.0', true);
		}
		if(is_user_logged_in()) :
			wp_enqueue_script( "mask" );
			wp_enqueue_script( "saveProfile", plugin_dir_url( __FILE__ ) . "html/js/save.js", array('jquery') );
			wp_localize_script( "saveProfile", "TaoAjaxSaveProfile", array( 
				'ajaxSaveProfile' => admin_url( 'admin-ajax.php?action=save_user_restrict' ),
				'url' => get_home_url()
			));
		endif;
	}

	// Save Profile in Ajax
	public static function save_user_restrict()
	{

		$user_id = get_current_user_id();

		$date = esc_attr($_POST['nascimento']);
		$dataArr = explode('/', $date);
		$dataArr = array_reverse($dataArr);
		$date = implode('', $dataArr);
		
		update_user_meta($user_id, 'display_name', esc_attr($_POST['nome']));
		update_user_meta($user_id, 'telefone', esc_attr($_POST['telefone']));
		update_user_meta($user_id, 'cpf', esc_attr($_POST['cpf']));
		update_user_meta($user_id, 'empresa', esc_attr($_POST['empresa']));
		update_user_meta($user_id, 'nascimento', $date);
		
		wp_update_user( array( 'ID' => $user_id, 'user_email' => esc_attr($_POST['email']) ) );
		
		if($_POST['password'] != ""){

			wp_set_password( esc_attr( $_POST['password'] ), $user_id );
			echo "reloggin";

		}

		exit;

	}

	// Form Edit Profile
	public static function edit_profile()
	{
		$authorid = get_current_user_id();
		include_once( dirname(__FILE__)."/html/form_edit_profile.php" );
	}

}

// Inserir em uma página o seguinte código shortcode [tao_edit_profile] para que seja exibido o formulário de perfil
add_shortcode('tao_edit_profile', array('Tao_Profile', 'edit_profile'));

// Script Salvar Perfil
add_action('wp_enqueue_scripts', array('Tao_Profile', 'user'));

// Salva Dados dos Usuários
add_action('wp_ajax_save_user_restrict', array('Tao_Profile', 'save_user_restrict'));

// Chama Método Instalação
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Tao_Profile', 'install'));

// Chama Método de Desinstalação
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array('Tao_Profile', 'uninstall'));