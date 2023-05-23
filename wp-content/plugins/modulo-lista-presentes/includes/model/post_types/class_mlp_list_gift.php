<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class MLP_List_Gift
{

    public static function init()
    {
        add_action("init", array(__CLASS__, "gift"));
        add_action("init", array(__CLASS__, "fields_acf"));
    }

    /* Post_type Presentes */
    public static function gift()
    {
        $labels = array(
            'name' => 'Item na Lista de Presentes',
            'singular_name' => 'Item na Lista de Presente',
            'menu_name' => 'Item na Lista de Presentes',
            'parent_item_colon' => 'Item na Lista de Presente Superior:',
            'all_items' => 'Todos os Item na Lista de Presentes',
            'view_item' => 'Ver Item na Lista de Presente',
            'add_new_item' => 'Adicionar Novo Item na Lista de Presente',
            'add_new' => 'Novo Item na Lista de Presente',
            'edit_item' => 'Editar Item na Lista de Presente',
            'update_item' => 'Atualizar Item na Lista de Presente',
            'search_items' => 'Buscar Item na Lista de Presente',
            'not_found' => 'Nenhum Item na Lista de Presente Encontrado',
            'not_found_in_trash' => 'Nenhum Item na Lista de Presente Encontrado na Lixeira',
        );
        $rewrite = array(
            'slug' => 'lista_presentes',
            'with_front' => false,
            'pages' => false,
            'feeds' => false,
        );
        $args = array(
            'label' => 'Item na Lista de Presentes',
            'description' => 'Item na Lista de Presentes Gerais',
            'labels' => $labels,
            'supports' => array('title', 'thumbnail'),
            'taxonomies' => array(),
            'hierarchical' => false,
            'public' => false,
            '_builtin' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => true,
            'menu_icon' => "dashicons-products",
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'query_var' => 'lista_presentes',
            'rewrite' => $rewrite,
            'capability_type' => 'list_gift',
            'map_meta_cap' => true
        );
        register_post_type('lista-presentes', $args);
    }

    public static function fields_acf()
    {

        if (function_exists("register_field_group")) {
            register_field_group(array(
                'id' => 'acf_produtos',
                'title' => 'Produtos',
                'fields' => array(
                    array(
                        'key' => 'field_56533e8b1982a',
                        'label' => 'Preço',
                        'name' => 'preco',
                        'type' => 'number',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => 'R$',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'lista-presentes',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array(
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array(),
                ),
                'menu_order' => 0,
            ));
        }

    }

}

MLP_List_Gift::init();