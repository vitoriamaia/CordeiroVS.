<?php

/*
Plugin Name: Módulo Equipe
Plugin URI: http://www.bindigital.com.br
Description: Cria Área de Equipe (Por Departamento) e Ficha Funcional (Tudo Restrito).
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

define('ClassNameStaff','Tao_Staff');

class Tao_Staff
{

	// Checa se Existe a Página de Equipe
	public static function install()
    {
    	global $wpdb;
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='equipe'", ARRAY_N);
		if(empty($pageRel)){
			$arg = array(
				'post_name'=>'equipe',
				'post_title' => 'Equipe',
				'post_status' => 'private',
				'post_type' => 'page',
				'menu_order' => 100,
				'post_content' => '[tao_staff]'
			);
			wp_insert_post( $arg );
		}
    }


    // Checa se Existe a Página de Equipe e Deleta
	public static function uninstall()
    {
    	global $wpdb;
		$pageRel = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name='equipe'", ARRAY_N);

		if(!empty($pageRel)){
			$pageRel = $pageRel[0][0];
			$wpdb->query("DELETE FROM $wpdb->posts WHERE ID = $pageRel");
		}
    }


	// Ficha Funcional
	public static function ficha_funcional() {
		$labels = array(
			'name'                => 'Ficha Funcional',
			'singular_name'       => 'Ficha Funcional',
			'menu_name'           => 'Ficha Funcional',
			'parent_item_colon'   => 'Ficha Funcional Superior:',
			'all_items'           => 'Todas as Fichas Funcionais',
			'view_item'           => 'Ver Ficha Funcional',
			'add_new_item'        => 'Adicionar Nova Ficha Funcional',
			'add_new'             => 'Nova Ficha Funcional',
			'edit_item'           => 'Editar Ficha Funcional',
			'update_item'         => 'Atualizar Ficha Funcional',
			'search_items'        => 'Buscar Ficha Funcional',
			'not_found'           => 'Nenhuma Ficha Funcional Encontrada',
			'not_found_in_trash'  => 'Nenhuma Ficha Funcional Encontrada na Lixeira',
		);
		$rewrite = array(
			'slug'                => 'ficha-funcional',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => false,
		);
		$args = array(
			'label'               => 'Ficha Funcional',
			'description'         => 'Ficha Funcional Operários',
			'labels'              => $labels,
			'supports'            => array( 'title','thumbnail', 'editor', 'author' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => "dashicons-media-text",
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'query_var'           => 'ficha-funcional',
			'rewrite'             => $rewrite,
			'capability_type'	  => 'post'
		);
		register_post_type( 'ficha_funcional', $args );

		$args = array(
		'label' 					 => ('Departamentos'),
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite' 					 => array( 'slug' => 'departamentos' )
		);
		register_taxonomy( 'departamentos', array( 'ficha_funcional' ), $args );

	}


	// Restrições a Taxonomia
	public static function tao_restrict() {

		if(is_tax('departamentos') && !is_user_logged_in()) {
			wp_die(
				'Área Restrita. Você não tem permissão para acessar. 
				<br /> Favor faça loggin.'
			);
		}
		
	}


	// Salva Fichas Funcionais em Modo Privado
	public static function save_record_restrict( $post_id ) 
	{

		$post_type = get_post_type( $post_id );

		if($post_type!="ficha_funcional"){

			return;

		} else {

			remove_action('save_post', array(ClassNameStaff, 'save_record_restrict'));
		
			$args_archive = array(
				'ID'          => $post_id,
				'post_status' => 'private',
			);

			wp_update_post( $args_archive );

		}

	}


	// Shortcode Staff
	public static function staff_content() {
		$args = array(
		    'orderby'           => 'name', 
		    'order'             => 'ASC',
		    'hide_empty'        => false, 
		    'hierarchical'      => true, 
		    'child_of'          => 0,
		); 
		$terms = get_terms('departamentos', $args);

		if(!empty($terms)) {
			foreach ($terms as $term) {

				$slug = $term->slug;
				$name = $term->name;
				$id = $term->term_id;

				$num_members = count( get_posts( 
					array(
						'post_type' => 'ficha_funcional',
						'post_status' => 'private',
						'tax_query' => array(
							array(
					        'taxonomy' => 'departamentos',
					        'field' => 'term_id',
					        'terms' => $id
					        )
					    ),
				    ) 
				));

				if($num_members>=1){
					echo "<a href='". get_home_url() ."/departamentos/". $slug ."' class='departamentos'>". $name ."</a><br />";
				}

			}
		}

	}
		
}


// Chama Método Instalação
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array(ClassNameStaff , 'install'));

// Chama Método de Desinstalação
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array(ClassNameStaff , 'uninstall'));

// Ficha Funcional
add_action( 'init', array( ClassNameStaff , 'ficha_funcional' ));

// Restrições
add_action( 'wp_head', array( ClassNameStaff , 'tao_restrict' ));

// Ficha Funcional Privada
add_action( 'save_post', array( ClassNameStaff , 'save_record_restrict' ));

// Inserir em uma página o seguinte código shortcode [tao_staff] para que seja exibido a lista de departamentos
add_shortcode('tao_staff', array(ClassNameStaff, 'staff_content'));