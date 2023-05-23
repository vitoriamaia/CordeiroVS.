<?php

// Post Type Produtos
/*if (!function_exists('produtos')) {

    function produtos()
    {
        $labels = array(
            'name' => 'Produtos',
            'singular_name' => 'Produtos',
            'menu_name' => 'Produtos',
            'parent_item_colon' => 'Produtos',
            'all_items' => 'Todos os Produtos',
            'view_item' => 'Ver Produto',
            'add_new_item' => 'Adicionar novo produto',
            'add_new' => 'Novo produto',
            'edit_item' => 'Editar produto',
            'update_item' => 'Atualizar produto',
            'search_items' => 'Produto',
            'not_found' => 'Nenhum produto encontrado',
            'not_found_in_trash' => 'Nenhuma produto encontrado na lixeira',
        );

        $rewrite = array(
            'slug' => 'produto',
            'with_front' => true,
            'pages' => true,
            'feeds' => false,
        );

        $args = array(
            'label' => 'Produto',
            'description' => 'Produto',
            'labels' => $labels,
            'supports' => array('title', 'thumbnail','editor'),
            'taxonomies' => array(),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            //puxar o posttype para o menu e criar a sub sessão
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-cart',
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'query_var' => 'produto',
            'rewrite' => $rewrite,
            'capability_type' => 'post',
        );
        register_post_type('produto', $args);
    }

    add_action('init', 'produtos');
}*/

// Register Taxonomy for cardapio
/*if (!function_exists('tax_for_produto')) {
    function tax_for_produto()
    {
        register_taxonomy('categoria', 'produto', array(
                'label' => __('Categoria'),
                'rewrite' => array(
                    'slug' => 'produtos',
                    'with_front' => true,
                    'hierarchical' => true,
                ),
                'hierarchical' => true)
        );
    }
    add_action('init', 'tax_for_produto');
}*/
if (!function_exists('servicos')) {

function servicos()
{
    $labels = array(
        'name' => 'Servicos',
        'singular_name' => 'Servicos',
        'menu_name' => 'Servicos',
        'parent_item_colon' => 'Servicos',
        'all_items' => 'Todos os Servicos',
        'view_item' => 'Ver Servico',
        'add_new_item' => 'Adicionar novo servico',
        'add_new' => 'Novo servico',
        'edit_item' => 'Editar servico',
        'update_item' => 'Atualizar servico',
        'search_items' => 'Servico',
        'not_found' => 'Nenhum servico encontrado',
        'not_found_in_trash' => 'Nenhum servico encontrado na lixeira',
    );

    $rewrite = array(
        'slug' => 'servico',
        'with_front' => true,
        'pages' => true,
        'feeds' => false,
    );

    $args = array(
        'label' => 'Servico',
        'description' => 'Servico',
        'labels' => $labels,
        'supports' => array('title', 'thumbnail','editor'),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        //puxar o posttype para o menu e criar a sub sessão
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-cart',
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'query_var' => 'servico',
        'rewrite' => $rewrite,
        'capability_type' => 'post',
    );
    register_post_type('servico', $args);
}
add_action('init', 'servicos');
}


if (!function_exists('infos')) {

    function infos()
    {
        $labels = array(
            'name' => 'Infos',
            'singular_name' => 'Infos',
            'menu_name' => 'Infos',
            'parent_item_colon' => 'Infos',
            'all_items' => 'Todos os Infos',
            'view_item' => 'Ver Info',
            'add_new_item' => 'Adicionar novo info',
            'add_new' => 'Nova info',
            'edit_item' => 'Editar info',
            'update_item' => 'Atualizar info',
            'search_items' => 'Info',
            'not_found' => 'Nenhum info encontrado',
            'not_found_in_trash' => 'Nenhuma info encontrado na lixeira',
        );
    
        $rewrite = array(
            'slug' => 'info',
            'with_front' => true,
            'pages' => true,
            'feeds' => false,
        );
    
        $args = array(
            'label' => 'Info',
            'description' => 'Info',
            'labels' => $labels,
            'supports' => array('title', 'thumbnail','editor'),
            'taxonomies' => array(),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            //puxar o posttype para o menu e criar a sub sessão
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-cart',
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'query_var' => 'Info',
            'rewrite' => $rewrite,
            'capability_type' => 'post',
        );
        register_post_type('Info', $args);
    }
    add_action('init', 'Infos');
    }


    if (!function_exists('dicas')) {

        function dicas()
        {
            $labels = array(
                'name' => 'Dicas',
                'singular_name' => 'Dicas',
                'menu_name' => 'Dicas',
                'parent_item_colon' => 'Dicas',
                'all_items' => 'Todos as Dicas',
                'view_item' => 'Ver Dica',
                'add_new_item' => 'Adicionar nova dica',
                'add_new' => 'Nova dica',
                'edit_item' => 'Editar dica',
                'update_item' => 'Atualizar dica',
                'search_items' => 'Dica',
                'not_found' => 'Nenhum dica encontrado',
                'not_found_in_trash' => 'Nenhuma dica encontrado na lixeira',
            );
        
            $rewrite = array(
                'slug' => 'dica',
                'with_front' => true,
                'pages' => true,
                'feeds' => false,
            );
        
            $args = array(
                'label' => 'Dica',
                'description' => 'Dica',
                'labels' => $labels,
                'supports' => array('title', 'thumbnail','editor'),
                'taxonomies' => array(),
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                //puxar o posttype para o menu e criar a sub sessão
                'show_in_nav_menus' => true,
                'show_in_admin_bar' => true,
                'menu_position' => 6,
                'menu_icon' => 'dashicons-cart',
                'can_export' => true,
                'has_archive' => false,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'query_var' => 'Dica',
                'rewrite' => $rewrite,
                'capability_type' => 'post',
            );
            register_post_type('Dica', $args);
        }
        add_action('init', 'Dicas');
        }


        if (!function_exists('atividades')) {

            function atividades()
            {
                $labels = array(
                    'name' => 'Atividades',
                    'singular_name' => 'Atividades',
                    'menu_name' => 'Atividades',
                    'parent_item_colon' => 'Atividades',
                    'all_items' => 'Todos os Atividades',
                    'view_item' => 'Ver Atividades',
                    'add_new_item' => 'Adicionar novo atividade',
                    'add_new' => 'Nova atividade',
                    'edit_item' => 'Editar atividade',
                    'update_item' => 'Atualizar atividade',
                    'search_items' => 'Atividade',
                    'not_found' => 'Nenhuma atividade encontrado',
                    'not_found_in_trash' => 'Nenhuma atividade encontrado na lixeira',
                );
            
                $rewrite = array(
                    'slug' => 'atividade',
                    'with_front' => true,
                    'pages' => true,
                    'feeds' => false,
                );
            
                $args = array(
                    'label' => 'Atividade',
                    'description' => 'Atividade',
                    'labels' => $labels,
                    'supports' => array('title', 'thumbnail','editor'),
                    'taxonomies' => array(),
                    'hierarchical' => false,
                    'public' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    //puxar o posttype para o menu e criar a sub sessão
                    'show_in_nav_menus' => true,
                    'show_in_admin_bar' => true,
                    'menu_position' => 6,
                    'menu_icon' => 'dashicons-cart',
                    'can_export' => true,
                    'has_archive' => false,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'query_var' => 'Atividade',
                    'rewrite' => $rewrite,
                    'capability_type' => 'post',
                );
                register_post_type('Atividade', $args);
            }
            add_action('init', 'Atividades');
            }


    
   