<?php

/**
 * Remetente de E-mails
 */
#add_filter( 'wp_mail_from_name', function($name){return get_option('blogname');});
#add_filter( 'wp_mail_from', function($email){return get_option('admin_email');});


/**
 * Declaração dos Scripts e Estilos
 */
function calls_front()
{
    /**
     * As bibliotecas JS estão registradas no plugin wp-toolkit
     */

    // Jquery
     wp_deregister_script( "jquery" );
     wp_register_script( "jquery" , "https://code.jquery.com/jquery-3.2.1.min.js", array(), "3.3.1", false );
    
    
    // Starter
    # wp_enqueue_script( "starter" );
    # wp_enqueue_script( "element-exists-jquery" );

    // Font-Awesome
    wp_enqueue_style("font-awesome");

    // Bootstrap
    wp_enqueue_script("bootstrap");

    // Lazy-load
    wp_enqueue_script("lazy-load");

    // Fancybox
    wp_enqueue_style("fancybox");
    wp_enqueue_script("fancybox");

    // Swiper ( Carousel )
    wp_enqueue_script("swiper");

    // Select2 ( form )
    //wp_enqueue_script("select2");

    // Form Zin
    wp_enqueue_script("formzin");


    // WOW
    # wp_enqueue_style( "wow" );
    # wp_enqueue_script( "wow" );

    // Owl-Carousel
    # wp_enqueue_style( "owl-carousel" );
    # wp_enqueue_script( "owl-carousel" );

    // DatePicker pt-BR
    # wp_enqueue_style( "datepicker-pt-br" );
    # wp_enqueue_script( "datepicker-pt-br" );

    // jMask
    # wp_enqueue_script( "jmask" );

    // Cidades-Estados
    # wp_enqueue_script( "cidades-estados" );

    // Geral
    wp_enqueue_style("general", WP_STYLES . "/style.min.css");
    wp_enqueue_script("main", WP_SCRIPTS . "/main.min.js", array(), "1.0", true);
}

add_action('wp_enqueue_scripts', 'calls_front');


/**
 * Suporte do Documento
 */
function theme_functions()
{
    /**
     * Título do Documento
     */
    add_theme_support('title-tag');

    /**
     * Miniaturas
     */
    add_theme_support('post-thumbnails');

    /**
     * Menus
     */
    register_nav_menus(array(
        'menu' => __('Menu Principal')
    ));

    /**
     * Formato de Posts
     */
    add_theme_support('post-formats', array(
        'sidebar',
    ));

    /**
     * Suporte a WooCommerce
     */
    add_theme_support('woocommerce');

    /**
     * Adiciona Crops de Imagens
     */
    add_image_size('nome-do-tamanho','width','height', true);
}

add_action('after_setup_theme', 'theme_functions');

/**
 * Thumbnails Personalizadas de Acordo com a Necessidade
 * @param $sizes
 * @return array
 */
function filter_size_images($sizes)
{
    global $post;
    /**
     * Se a imagem estiver sendo inserida seu identificador é enviado via $_POST
     * Caso esteja sendo excluída, o id é recuperado pela variável global $post
     */
    $post_type = '';

    if (isset($_POST['post_id'])) {

        $post_type = get_post_type($_POST['post_id']);

    } else if (isset($post) && isset($post->post_parent) && ($post->post_parent > 0)) {

        // Notem que a variável global $post é o objeto do anexo e não do post a qual ele pertence
        $post_type = get_post_type($post->post_parent);

    }

    // Aqui temos um array com os formatos padrões
    $sizes = array('thumbnail', 'medium', 'large');

    switch ($post_type):
        case 'my_custom_post_type':
            // É incorporado aos formatos padrões um tamanho previamente criado apenas para o tipo de post personalizado
            array_push($sizes, 'my-thumbnail');
            break;
        case 'page':
            // Nenhum redimensionamento é feito para as páginas
            array_push($sizes, 'my-thumbnail');
            break;
        default:
            // Por padrão é gerado apenas o thumbnail
            unset($sizes[1], $sizes[2]);
            break;
    endswitch;

    return $sizes;
}

add_filter('intermediate_image_sizes', 'filter_size_images');


/**
 * Widgets
 */
function widgets_init()
{
    register_sidebar(array(
        'name' => __('Home'),
        'id' => 'home',
        'description' => __('Manipula os widgets na Home'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Barra Lateral - Blog'),
        'id' => 'sidebar-blog',
        'description' => __('Manipula os widgets na barra lateral blog.'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'widgets_init');


/**
 * Remove tags desnecessários do wp_head()
 */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'parent_post_rel_link');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/**
 * Desabilita XMLrpc
 */
add_filter('xmlrpc_enabled', '__return_false');


/**
 * Esconde Admin Bar
 */
add_filter('show_admin_bar', '__return_false');


/**
 * Corrige Problema de Acentuação dos arquivos no Upload
 * @param $filename
 * @return string
 */
if (!function_exists('sanitize_file_name_in_upload')) {
    function sanitize_file_name_in_upload($filename)
    {
        $types = array( 'jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx' );
        $info = pathinfo($filename);

        if(in_array($info['extension'], $types)){
            $website = get_option('blogname');
            $extension = '.' . $info['extension'];
            $name = basename($filename, $extension);
            $filename = strtolower(sanitize_title($website . "-" . $name)) . $extension;
        }

        return $filename;
    }
}
add_filter( 'sanitize_file_name', 'sanitize_file_name_in_upload', 10);


/**
 * Insere o slug da página como class na função body_class
 * @param $classes
 * @return array
 */
function add_body_class($classes)
{
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    if (!is_home()) {
        $classes[] = 'internal';
    }
    return $classes;
}

add_filter('body_class', 'add_body_class');


/**
 * Shorcode para addthis
 * @return string
 */
function addthis_shortcode_tool()
{
    $addthisHTML = '<div id="addthis_shortcode">' . do_action('addthis_widget', get_permalink(), get_the_title(), 'large_toolbox') . '</div>';
    return $addthisHTML;
}

add_shortcode('addthis_shortcode_tool', 'addthis_shortcode_tool');


/**
 * Schema
 */
function html_tag_schema()
{
    $schema = 'http://schema.org/';
    $type = 'WebPage';

    // Is single post
    if (is_singular('post')) {
        $type = 'Article';
    } // Is author page
    elseif (is_author()) {
        $type = 'ProfilePage';
    } // Is search results page
    elseif (is_search()) {
        $type = 'SearchResultsPage';
    }

    echo 'itemscope="itemscope" itemtype="' . esc_attr($schema) . esc_attr($type) . '"';
}


/**
 * Limitar número caracteres conteúdo, MAS NÃO CORTA A PALAVRA AO MEIO
 */
function limitarTexto($content, $limite)
{
    $contador = strlen($content);
    if ($contador >= $limite) {
        $content = substr($content, 0, strrpos(substr($content, 0, $limite), ' ')) . '...';
        return $content;
    } else {
        return $content;
    }
}


/**
 * Retira versão da chamada dos scripts ( Query String )
 */
function remove_cssjs_ver($src)
{
    if (strpos($src, '?ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}

add_filter('style_loader_src', 'remove_cssjs_ver', 10, 2);
add_filter('script_loader_src', 'remove_cssjs_ver', 10, 2);

/**
 *  get socials networking
 * */
if (!function_exists('getSocials')) {
    function getSocials()
    {

        // init array socials
        $socials = array();

        // add in array socials values
        if (have_rows('social', 'option')): while (have_rows('social', 'option')): the_row();
            $name = get_sub_field('nome');
            $url = get_sub_field('url');
            array_push($socials, array('name' => $name, 'url' => $url));
        endwhile; endif;

        // concat all and return
        $output = '';

        $output .= '<ul class="socials navbar-right">';
        foreach ($socials as $social):
            $output .= '<li class="socials__item socials__item--' . strtolower($social['name']) . '">';
            $output .= '<a href="https://' . $social['url'] . '" title="' . $social['name'] . '" target="_blanck"><span class="fa fa-' . strtolower($social['name']) . ' fa-fw"></span></a>';
            $output .= '</li>';
        endforeach;
        $output .= '</ul>';

        return $output;

    }
}

/**
 *  Get Logo Header
 */

if (!function_exists('getLogoHeader')) {
    function getLogoHeader()
    {

        $logo = get_field('logo_topo', 'option');

        return '<img src="' . $logo['url'] . '" width="' . $logo['width'] . '" height="' . $logo['height'] . '" title="' . get_bloginfo('title') . ' - ' . get_bloginfo('description') . '" alt="' . get_bloginfo('title') . '" />';
    }

}

/**
 *  Get Logo Footer
 */

if (!function_exists('getLogoFooter')) {
    function getLogoFooter()
    {

        $logo = get_field('logo_rodape', 'option');

        return '<img src="' . $logo['url'] . '" width="' . $logo['width'] . '" height="' . $logo['height'] . '" title="' . get_bloginfo('title') . ' - ' . get_bloginfo('description') . '" alt="' . get_bloginfo('title') . '" />';
    }

}

/**
 * Add class custom for link menu
 */
function attribute_menu_link($atts, $item, $args)
{
    // inspect $item, then …
    $atts['class'] = 'menu-link';
    return $atts;
}

add_filter('nav_menu_link_attributes', 'attribute_menu_link', 10, 3);


/**
 * Shortcode page image
 */
function image_page()
{

    //recebe o thumbnail
    $url_image = get_field('imagem');

    //recebe a imagem do teme option
    $imageFieldOption = get_field('foto_destaque_de_pagina_interna', 'option');
    ?>

    <div class="img-content">

        <img src="
           <?php
        //var_dump($url_image);
        if (!empty($url_image)) :
            //se existir o thumbnail imprime se nao
            echo $url_image['url'];

        else :
            //imprime a imagem do teme option
            echo $imageFieldOption['url'];


        endif; ?>"
             class="img-responsive img-page-custon">

    </div>
    <?php

}

add_shortcode('image_page', 'image_page');