<?php

/**
 * Plugin Name: Módulo Base
 * Plugin URI: https://www.facebook.com/tao.pires
 * Description: Módulo de Base.
 * Version: 1.0
 * Author: Tiago Pires
 * Author URI: https://www.facebook.com/tao.pires
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class News extends WP_Widget{

	public function __construct() {
        add_action ("init", array ($this, "news"));
        add_action ("init", array ($this, "tax"));
        add_action ("save_post", array ($this, "update_cache_news"));

        parent::__construct(false, $name = __('Banner por Tipo', 'Banners por Tipo') );
    }

    /* Posttype Notícias */
	public function news() {
        $labels = array(
            'name'                => 'Notícias',
            'singular_name'       => 'Notícia',
            'menu_name'           => 'Notícias',
            'parent_item_colon'   => 'Notícia Superior:',
            'all_items'           => 'Todas as Notícias',
            'view_item'           => 'Ver Notícia',
            'add_new_item'        => 'Adicionar Nova Notícia',
            'add_new'             => 'Nova Notícia',
            'edit_item'           => 'Editar Notícia',
            'update_item'         => 'Atualizar Notícia',
            'search_items'        => 'Buscar Notícia',
            'not_found'           => 'Nenhuma Notícia Encontrada',
            'not_found_in_trash'  => 'Nenhuma Notícia Encontrada na Lixeira',
        );
		$rewrite = array(
            'slug'                => 'noticia',
            'with_front'          => true,
            'pages'               => true,
            'feeds'               => false,
		);
		$args = array(
            'label'               => 'Notícias',
            'description'         => 'Notícias Gerais',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'_builtin' 			  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
            'menu_icon'           => "dashicons-media-text",
            'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'query_var'           => 'noticia',
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'noticias', $args );
	}

    /* Taxonomia */
    public function tax(){

        $labels = array(
            'name'                       => 'Tipos',
            'singular_name'              => 'Tipo',
            'menu_name'                  => 'Tipos',
            'add_new_item'               => 'Adicionar Novo Tipo',
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => false,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
        );
        register_taxonomy( 'tipos', array( 'noticias' ), $args );

    }

    /* Deleção de Cache */
    function update_cache_news( $post_id ) {

        $post_type = get_post_type( $post_id );

        if($post_type != "noticias"){ return; }

        $status = get_post_status($post_id);

        if(isset($_GET['action']) != 'trash' && $status != 'auto-draft'){

            remove_action('save_post', array($this, 'update_cache_news'));

            $args = array(
                'ID'          => $post_id,
            );

            wp_update_post( $args );

            # Atualiza Notícias
            delete_transient('news');

        }

    }

    /* Widget - Front */
    public function widget($args, $instance){

        # Notícias
        if ( false === ( $banner_servicos = get_transient( 'news' ) ) ) {
            // Argumentos
            $randargs = array('post_type' => 'noticias', 'showposts'=>-1);
            $banner_servicos = get_posts($randargs);
            set_transient( 'news', $banner_servicos, 60*60*3 );
        }

        $news = get_transient( 'news' );
        if(!empty($news)) :

        ?>

        <section id="news">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <h2 class="title">Not&iacute;cias</h2>

                        <?php foreach($news as $single) :

                            echo $single;

                        endforeach; ?>

                    </div>
                </div>
            </div>
        </section>

    <?php endif;

    }
}

// Registra Widget
add_action('widgets_init', create_function('', 'return register_widget("News");'));

