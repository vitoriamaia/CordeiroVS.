<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class post_type_popup
{

    public static function init()
    {
        add_action("init", array(__CLASS__, "popup_post_type"));
    }

    public static function popup_post_type()
    {
        $labels = array(
            'name' => 'Popups',
            'singular_name' => 'Popup',
            'menu_name' => 'Popups',
            'parent_item_colon' => 'Popup Pai:',
            'all_items' => 'Todos Popups',
            'view_item' => 'Ver Popup',
            'add_new_item' => 'Adicionar Novo Popup',
            'add_new' => 'Novo Popup',
            'edit_item' => 'Editar Popup',
            'update_item' => 'Atualizar Popup',
            'search_items' => 'Buscar Popup',
            'not_found' => 'Nenhum Popup Encontrado',
            'not_found_in_trash' => 'Nenhum Popup Encontrado na Lixeira',
        );
        $rewrite = array(
            'slug' => 'popup',
            'with_front' => false,
            'pages' => false,
            'feeds' => false,
        );
        $args = array(
            'label' => 'Popups',
            'description' => 'Popup',
            'labels' => $labels,
            'supports' => array('title', 'editor'),
            'taxonomies' => array(),
            'hierarchical' => false,
            'public' => false,
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
            'query_var' => 'popup',
            'rewrite' => $rewrite,
            'capability_type' => 'post',
        );
        register_post_type('popup', $args);
    }

}

post_type_popup::init();