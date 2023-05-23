<?php

/*
Plugin Name: Módulo Agenda
Plugin URI: http://www.bindigital.com.br
Description: Tao Diary BinDigital
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

define('ClassNameDiary','Tao_Diary');

class Tao_Diary
{

    // Post_Type Arquivos
	public static function post_type_diary() {
		$labels = array(
			'name'                => "Agenda",
			'singular_name'       => "Agenda",
			'menu_name'           => "Agenda",
			'parent_item_colon'   => "Agenda Pai:",
			'all_items'           => "Todos as Agenda",
			'view_item'           => "Ver Agenda",
			'add_new_item'        => "Adicionar Nova Agenda",
			'add_new'             => "Nova Agenda",
			'edit_item'           => "Editar Agenda",
			'update_item'         => "Atualizar Agenda",
			'search_items'        => "Buscar Agenda",
			'not_found'           => "Nenhum Agenda Encontrada",
			'not_found_in_trash'  => "Nenhum Agenda Encontrada na Lixeira",
		);
		$rewrite = array(
			'slug'                => "agenda",
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => false,
		);
		$args = array(
			'label'               => "agenda",
			'description'         => "agenda",
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 15,
			'menu_icon'           => 'dashicons-calendar',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'query_var'           => "agenda",
			'rewrite'             => $rewrite,
			'capability_type'     => "post",
		);
		register_post_type( 'agenda', $args );

		// Add day archive (and pagination)
		add_rewrite_rule("([0-9]{4})/([0-9]{2})/([0-9]{2})/page/?([0-9]{1,})/?",'index.php?post_type=agenda&year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]','top');
		add_rewrite_rule("([0-9]{4})/([0-9]{2})/([0-9]{2})/?",'index.php?post_type=agenda&year=$matches[1]&monthnum=$matches[2]&day=$matches[3]','top');

		// Add month archive (and pagination)
		add_rewrite_rule("([0-9]{4})/([0-9]{2})/page/?([0-9]{1,})/?",'index.php?post_type=agenda&year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]','top');
		add_rewrite_rule("([0-9]{4})/([0-9]{2})/?",'index.php?post_type=agenda&year=$matches[1]&monthnum=$matches[2]','top');

		// Add year archive (and pagination)
		add_rewrite_rule("([0-9]{4})/page/?([0-9]{1,})/?",'index.php?post_type=agenda&year=$matches[1]&paged=$matches[2]','top');
		add_rewrite_rule("([0-9]{4})/?",'index.php?post_type=agenda&year=$matches[1]','top');

	}


	// Save Diary in Model Private
	public static function save_diary( $post_id ) 
	{

		$post_type = get_post_type( $post_id );

		if($post_type!="agenda"){
			return;
		}

		$status = get_post_status($post_id);

		if(isset($_GET['action']) != 'trash' && $status != 'auto-draft'){

			remove_action('save_post', array(ClassNameDiary, 'save_diary'));

			$args_diary = array(
			  'ID'          => $post_id,
			  'post_status' => 'private',
			);

			wp_update_post( $args_diary );

		}

	}

}


// Post_Type Diário
add_action( 'init', array(ClassNameDiary, 'post_type_diary') );

// Restrição nos singles Diário
add_action( 'save_post', array( ClassNameDiary, 'save_diary' ));