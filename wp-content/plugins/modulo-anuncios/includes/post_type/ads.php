<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class post_type_ads{

    public static function init() {
        add_action("init", array(__CLASS__, "ads_post_type"));
        add_action("init", array(__CLASS__, "tax_local"));
        add_action("init", array(__CLASS__, "tax_type_cat"));
        add_action("init", array(__CLASS__, "tax_planner"));

        //add_action("pre_get_posts", array(__CLASS__, 'query_taxonomy_category'));

        //if(is_admin()) add_action('do_meta_boxes', array(__CLASS__, 'remove_metabox_admin'));
    }

    public static function ads_post_type()
    {
        $labels = array(
            'name' => 'Anúncios',
            'singular_name' => 'Anúncio',
            'menu_name' => 'Anúncios',
            'parent_item_colon' => 'Anúncio Pai:',
            'all_items' => 'Todos Anúncios',
            'view_item' => 'Ver Anúncio',
            'add_new_item' => 'Adicionar Novo Anúncio',
            'add_new' => 'Novo Anúncio',
            'edit_item' => 'Editar Anúncio',
            'update_item' => 'Atualizar Anúncio',
            'search_items' => 'Buscar Anúncio',
            'not_found' => 'Nenhum Anúncio Encontrado',
            'not_found_in_trash' => 'Nenhum Anúncio Encontrado na Lixeira',
        );
        $rewrite = array(
            'slug' => 'anuncios',
            'with_front' => false,
            'pages' => false,
            'feeds' => false,
        );
        $args = array(
            'label' => 'Anúncios',
            'description' => 'Anúncio',
            'labels' => $labels,
            'supports' => array('title', 'thumbnail', 'editor'),
            'taxonomies' => array(),
            'hierarchical' => false,
            'public' => true,
            '_builtin' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => true,
            'menu_icon' => 'dashicons-megaphone',
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'query_var' => 'anuncios',
            'rewrite' => $rewrite,
            'capability_type' => 'post',
        );
        register_post_type('anuncios', $args);
    }

    public static function tax_local()
    {
        $labels = array(
            'name' => 'Local',
            'singular_name' => 'Local',
            'menu_name' => 'Local',
            'all_items' => 'Todos os Locais',
            'parent_item' => 'Local Superior',
            'parent_item_colon' => 'Local Superior:',
            'new_item_name' => 'Novo Local',
            'add_new_item' => 'Adicionar Novo Local',
            'edit_item' => 'Editar Local',
            'update_item' => 'Atualizar Local',
            'view_item' => 'Ver Local',
            'separate_items_with_commas' => 'Separar itens com vírgula',
            'add_or_remove_items' => 'Adicionar ou remover itens',
            'choose_from_most_used' => 'Escolha entre os mais utilizados',
            'popular_items' => 'Locais Populares',
            'search_items' => 'Buscar Locais',
            'not_found' => 'Não Encontrado',
            'no_terms' => 'Nenhum Local',
            'items_list' => 'Lista de Locais',
            'items_list_navigation' => 'Navegação lista de itens',
        );
        $rewrite = array(
            'slug' => 'local',
            'with_front' => true,
            'hierarchical' => true,
        );
        $capabilities = array(
            'manage_terms' => 'manage_categories',
            'edit_terms' => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'edit_posts',
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'query_var' => 'local',
            'rewrite' => $rewrite,
            'capabilities' => $capabilities,
        );
        register_taxonomy('local', array('anuncios'), $args);
    }

    public static function tax_type_cat()
    {
        $labels = array(
            'name' => 'Categoria',
            'singular_name' => 'Categoria',
            'menu_name' => 'Categoria / Tipo',
            'all_items' => 'Todas as Categorias',
            'parent_item' => 'Categoria Superior',
            'parent_item_colon' => 'Categoria Superior:',
            'new_item_name' => 'Nova Categoria',
            'add_new_item' => 'Adicionar Nova Categoria',
            'edit_item' => 'Editar Categoria',
            'update_item' => 'Atualizar Categoria',
            'view_item' => 'Ver Categoria',
            'separate_items_with_commas' => 'Separar itens com vírgula',
            'add_or_remove_items' => 'Adicionar ou remover itens',
            'choose_from_most_used' => 'Escolha entre os mais utilizados',
            'popular_items' => 'Categorias Populares',
            'search_items' => 'Buscar Categoria',
            'not_found' => 'Não Encontrado',
            'no_terms' => 'Nenhuma Categoria',
            'items_list' => 'Lista de Categorias',
            'items_list_navigation' => 'Navegação lista de itens',
        );
        $rewrite = array(
            'slug' => 'categoria',
            'with_front' => true,
            'hierarchical' => true,
        );
        $capabilities = array(
            'manage_terms' => 'manage_categories',
            'edit_terms' => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'edit_posts',
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'query_var' => 'categoria',
            'rewrite' => $rewrite,
            'capabilities' => $capabilities,
        );
        register_taxonomy('categoria', array('anuncios'), $args);
    }

    public static function tax_planner()
    {
        $labels = array(
            'name' => 'Planos',
            'singular_name' => 'Plano',
            'menu_name' => 'Planos',
            'all_items' => 'Todos os Planos',
            'parent_item' => 'Item Superior',
            'parent_item_colon' => 'Item Superior:',
            'new_item_name' => 'Novo Plano',
            'add_new_item' => 'Adicionar Novo Plano',
            'edit_item' => 'Editar Plano',
            'update_item' => 'Atualizar Plano',
            'view_item' => 'Ver Plano',
            'separate_items_with_commas' => 'Separar itens com vírgula',
            'add_or_remove_items' => 'Adicionar ou remover itens',
            'choose_from_most_used' => 'Escolha entre os mais utilizados',
            'popular_items' => 'Planos Populares',
            'search_items' => 'Buscar Plano',
            'not_found' => 'Não Encontrado',
            'no_terms' => 'Nenhum Plano',
            'items_list' => 'Lista de Planos',
            'items_list_navigation' => 'Navegação lista de itens',
        );
        $rewrite = array(
            'slug' => 'plano',
            'with_front' => true,
            'hierarchical' => true,
        );
        $capabilities = array(
            'manage_terms' => 'manage_categories',
            'edit_terms' => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'edit_posts',
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'query_var' => 'plano',
            'rewrite' => $rewrite,
            'capabilities' => $capabilities,
        );
        register_taxonomy('plano', array('anuncios'), $args);
    }

    public static function query_taxonomy_category( $query ){

        if($query->is_tax && !is_admin()){

            if($query->tax_query->queries[0]["taxonomy"] == "categoria") $query->set( 'post_type', 'anuncios' );

        }

    }

    public static function remove_metabox_admin(){
        #remove_meta_box('planodiv', 'anuncios', 'side');
    }

}

post_type_ads::init();