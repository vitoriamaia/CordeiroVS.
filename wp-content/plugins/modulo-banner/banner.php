<?php

/**
 * Plugin Name: Módulo Banner
 * Plugin URI: https://www.facebook.com/tao.pires
 * Description: Módulo de Banner. Requer Plugin ACF Advanced Custom Fields e WP-ToolKit
 * Version: 1.0
 * Author: Tiago Pires
 * Author URI: https://www.facebook.com/tao.pires
 */
class BigBanner extends WP_Widget
{
    public function __construct()
    {

        // Cria Tipo de Banner e Campos Personalizados
        add_action("init", array($this, "banner"));
        add_action("init", array($this, "fields"));

        // Estatísticas Banner
        add_action('add_meta_boxes', array($this, 'add_metabox_banner'));

        // Número de Clicks no Banner
        add_action('wp_ajax_clicks_banner', array($this, 'clicks_banner'));
        add_action('wp_ajax_nopriv_clicks_banner', array($this, 'clicks_banner'));

        parent::__construct(false, $name = __('Módulo de Banner (Home)', 'Módulo de Banner Principal'));

        //  Ativa plugins requeridos
        $this->run_activate_plugin('wp-toolkit/wp-toolkit.php');
        $this->run_activate_plugin('advanced-custom-fields/acf.php');
    }

    public function run_activate_plugin($plugin)
    {
        $current = get_option('active_plugins');
        $plugin = plugin_basename(trim($plugin));

        if (!in_array($plugin, $current)) {
            $current[] = $plugin;
            sort($current);
            do_action('activate_plugin', trim($plugin));
            update_option('active_plugins', $current);
            do_action('activate_' . trim($plugin));
            do_action('activated_plugin', trim($plugin));
        }

        return null;
    }

    /* Posttype Banner */
    public function banner()
    {
        $labels = array(
            'name' => 'Banners',
            'singular_name' => 'Banner',
            'menu_name' => 'Banners',
            'parent_item_colon' => 'Banner Pai:',
            'all_items' => 'Todos Banners',
            'view_item' => 'Ver Banner',
            'add_new_item' => 'Adicionar Novo Banner',
            'add_new' => 'Novo Banner',
            'edit_item' => 'Editar Banner',
            'update_item' => 'Atualizar Banner',
            'search_items' => 'Buscar Banner',
            'not_found' => 'Nenhum Banner Encontrado',
            'not_found_in_trash' => 'Nenhum Banner Encontrado na Lixeira',
        );
        $rewrite = array(
            'slug' => 'banner',
            'with_front' => false,
            'pages' => false,
            'feeds' => false,
        );
        $args = array(
            'label' => 'Banners',
            'description' => 'Banner',
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
            'menu_icon' => 'dashicons-format-image',
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'query_var' => 'banner',
            'rewrite' => $rewrite,
            'capability_type' => 'post',
        );
        register_post_type('banner', $args);
    }

    /* Campos Banner */
    public function fields()
    {
        if (function_exists("register_field_group")) {
            register_field_group(array(
                'id' => 'acf_banner',
                'title' => 'Banner',
                'fields' => array(
                    array(
                        'key' => 'field_5620f3ce78b14',
                        'label' => 'Ativar Link no Banner',
                        'name' => 'ativar_link',
                        'type' => 'checkbox',
                        'instructions' => 'Marque esta caixa para ativar o link do banner',
                        'choices' => array(
                            'Ativar' => 'Ativar',
                        ),
                        'default_value' => '',
                        'layout' => 'vertical',
                    ),
                    array(
                        'key' => 'field_5620f47578b15',
                        'label' => 'Campo Link',
                        'name' => 'campo_link',
                        'type' => 'text',
                        'instructions' => 'Insira o link do banner',
                        'required' => 1,
                        'conditional_logic' => array(
                            'status' => 1,
                            'rules' => array(
                                array(
                                    'field' => 'field_5620f3ce78b14',
                                    'operator' => '==',
                                    'value' => 'Ativar',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => 'Link',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5620f4af07936',
                        'label' => 'Nova Tela',
                        'name' => 'nova_tela',
                        'type' => 'checkbox',
                        'instructions' => 'Marque esta opção para abrir o link em uma nova tela',
                        'conditional_logic' => array(
                            'status' => 1,
                            'rules' => array(
                                array(
                                    'field' => 'field_5620f3ce78b14',
                                    'operator' => '==',
                                    'value' => 'Ativar',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'choices' => array(
                            'Nova tela' => 'Nova tela',
                        ),
                        'default_value' => '',
                        'layout' => 'vertical',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'banner',
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

    /* Metabox Clicks e Views no Banner */
    public function add_metabox_banner()
    {
        add_meta_box('banner_analytics', 'Estatísticas do Banner', array($this, 'banner_metabox_call'), 'banner', 'side', 'high');
    }

    /* Metabox Content Clicks e Views no Banner */
    public function banner_metabox_call()
    {
        global $post;

        // Pega o valor dos clicks
        $clicks = get_post_meta($post->ID, 'clicks_banner_main', true);
        if (empty($clicks)) {
            $clicks = 0;
        }

        // Pega o valor das visualizações
        $views = get_post_meta($post->ID, 'views_banner_main', true);
        if (empty($views)) {
            $views = 0;
        }

        // Saída de Campo
        echo 'Número de Clicks: <strong>' . $clicks . '</strong> <br /> ';
        echo 'Visualizações: <strong>' . $views . '</strong> ';
    }

    /* Atualização de Clicks no Banner */
    public function clicks_banner()
    {

        # Pega o ID do Post via URL
        $post_id = $_GET['id_banner'];

        # Meta key clicks
        $meta_key = 'clicks_banner_main';

        # Pega o número de clicks no banner
        $meta_value = get_post_meta($post_id, $meta_key, true);

        # Verifica se exite algum valor na key click
        # Caso não exista então é adicionado valor 1
        if (empty($meta_value)) :
            $meta_value = 1;
            add_post_meta($post_id, $meta_key, $meta_value, true);

        # Caso exista algum valor, então é somado a mais 1
        else :
            $meta_value = $meta_value + 1;
            update_post_meta($post_id, $meta_key, $meta_value);

        endif;

        $protocol = $_GET['protocol'];
        $address = $_GET['address'];

        $address = $protocol . '://' . $address;

        # Após adicionar o click, é feito um redirecionamento de endereço
        wp_redirect($address);

        exit;

    }

    public static function views_banner($post_id)
    {

        # Meta key clicks
        $meta_key = 'views_banner_main';

        # Pega o número de clicks no banner
        $meta_value = get_post_meta($post_id, $meta_key, true);

        # Verifica se exite algum valor na key view
        # Caso não exista então é adicionado valor 1
        if (empty($meta_value)) :
            $meta_value = 1;
            add_post_meta($post_id, $meta_key, $meta_value, true);
        else :
            # Caso exista algum valor, então é somado a mais 1
            $meta_value = $meta_value + 1;
            update_post_meta($post_id, $meta_key, $meta_value);
        endif;

    }

    public function widget($args, $instance)
    {

        $args = array(
            'post_type' => 'banner',
            'showposts' => -1
        );

        $banners = get_posts($args);

        if (!empty($banners)) : ?>

            <!-- Banner -->
            <section class="painel cem cf wow fadeIn swiper-container s1" data-wow-duration="2s">

                <ul class="swiper-wrapper">

                    <?php
                    foreach ($banners as $banner) :

                        $thumb_id = get_post_thumbnail_id($banner->ID);

                        if (!empty($thumb_id)) :

                            // Atributos da imagem destaque
                            $attr_img = get_thumb($thumb_id);

                            // Atributos do texto
                            $text_active = get_field('ativar_campos_texto', $banner->ID);
                            if (!empty($text_active)) $text = get_field('campo_texto', $banner->ID);

                            BigBanner::views_banner($banner->ID);

                            $alt = $attr_img['alt'];
                            $title = $attr_img['title'];

                            // HTML da imagem do banner
                            $html_banner = "<img src=" . $attr_img['url'] . " alt='$alt' title='$title'>";

                            // Atributos do link e caso exista
                            // inicia a sua construção
                            $active_link = get_field('ativar_link', $banner->ID);
                            if (!empty($active_link)) :

                                $protocol = 'http';
                                $address = get_field('campo_link', $banner->ID);
                                $pos_address = strpos($address, '//');

                                if ($pos_address !== false) {
                                    $pos_address = strpos($address, '://');
                                    $hash = ($pos_address !== false) ? '://' : '//';

                                    $address = explode($hash, $address);
                                    $protocol = $address[0];
                                    $address = $address[1];
                                }

                                $window = get_field('nova_tela', $banner->ID);

                                // Construção do HREF
                                $href = admin_url('admin-ajax.php?action=clicks_banner');
                                $href .= "&id_banner=" . $banner->ID;
                                $href .= "&protocol=" . $protocol;
                                $href .= "&address=" . $address;

                                $window = (!empty($window)) ? "_blank" : "_self";

                                $link = "<a class='link' href='$href' target='$window' title='$title'>";
                                $html_banner = $link . $html_banner;
                                $html_banner .= "</a>";

                            endif;

                            ?>

                            <li class="swiper-slide">

                                <?php echo $html_banner ?>

                            </li>

                        <?php endif;

                    endforeach; ?>

                </ul>

                <!-- Adiciona Paginação -->
                <div class="swiper-pagination"></div>
                <!-- Adiciona Setas de Navegação -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

            </section>
            <!--/ Banner -->

        <?php endif;

    }
}

// Registra Widget
add_action('widgets_init', create_function('', 'return register_widget("BigBanner");'));