<?php

/*
Plugin Name: Módulo Associados
Plugin URI: http://www.bindigital.com.br
Description: Cria Área Associados.
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

define('ClassNameAssociated','Tao_Associated');

class Tao_Associated
{

	// Checa se Existe a Página de Equipe
	public static function install()
    {
    	global $wpdb;
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='associados'", ARRAY_N);
		if(empty($pageRel)){
			$arg = array(
				'post_name'=>'associados',
				'post_title' => 'Associados',
				'post_status' => 'private',
				'post_type' => 'page',
				'menu_order' => 100,
				'post_content' => '[tao_associated]',
				'page_template' => 'area-restrita.php'
			);
			wp_insert_post( $arg );
		}
    }


    // Checa se Existe a Página de Equipe e Deleta
	public static function uninstall()
    {
    	global $wpdb;
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='associados'", ARRAY_N);

		if(!empty($pageRel)){
			$pageRel = $pageRel[0][0];
			$wpdb->query("DELETE FROM $wpdb->posts WHERE ID = $pageRel");
		}
    }


	// Shortcode Associated
	public static function associated_content() {

		$users = get_users( 'orderby=display_name' );
        echo '<h3 class="titulo_restrito">Associsados</h3>';
		echo '<table class="table table-bordered">';
			echo '<tbody>';

				echo '<tr>';
					echo '<td class="header"> <strong>Nome do Associado</strong> </td>';
					echo '<td class="header"> <strong>Telefone </strong></td>';
					echo '<td class="header"> <strong>Empresa</strong> </td>';
					echo '<td class="header"> <strong>E-Mail</strong></td>';
				echo '</tr>';

			foreach ( $users as $user ) {
				echo '<tr class="content-associated">';
					echo '<td>' . esc_html( $user->display_name ) . '</td>';
					echo '<td>' . get_the_author_meta('telefone', $user->ID ) . '</td>';
					echo '<td>' . get_the_author_meta('empresa', $user->ID ) . '</td>';
					echo '<td class="email"><a href="mailto:' . esc_html( $user->user_email ) . '"> ' . esc_html( $user->user_email ) . ' </a></td>';
				echo '</tr>';
			}

			echo '</tbody>';
		echo '</table>';
	}
		
}


// Chama Método Instalação
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array(ClassNameAssociated , 'install'));

// Chama Método de Desinstalação
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array(ClassNameAssociated , 'uninstall'));

// Inserir em uma página o seguinte código shortcode [tao_associated] para que seja exibido a lista de departamentos
add_shortcode('tao_associated', array(ClassNameAssociated, 'associated_content'));