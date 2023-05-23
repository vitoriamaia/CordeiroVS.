<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class MLP_Customer
{

    public static function init()
    {
        // Post_Type Clientes
        add_action("init", array(__CLASS__, "customer"));
        add_action("init", array(__CLASS__, "fields_acf"));

        // Atrelar Produtos
        add_action('add_meta_boxes', array(__CLASS__, 'metabox_product'));

        // Atrelar Cliente
        add_action('add_meta_boxes', array(__CLASS__, 'metabox_customer'));

        // Salvar MetaBox
        add_action('save_post', array(__CLASS__, 'metabox_save'));

        // Remove opções desnecessárias
        add_action("admin_menu", array(__CLASS__, "extra_function_menu"));
        add_action('admin_head', array(__CLASS__, "extra_function_add_client"));
    }

    /* Post_type Clientes */
    public static function customer()
    {
        $labels = array(
            'name' => 'Clientes',
            'singular_name' => 'Cliente',
            'menu_name' => 'Clientes',
            'parent_item_colon' => 'Cliente Superior:',
            'all_items' => 'Todos os Clientes',
            'view_item' => 'Ver Cliente',
            'add_new_item' => 'Adicionar Novo Cliente',
            'add_new' => 'Novo Cliente',
            'edit_item' => 'Editar Cliente',
            'update_item' => 'Atualizar Cliente',
            'search_items' => 'Buscar Cliente',
            'not_found' => 'Nenhum Cliente Encontrado',
            'not_found_in_trash' => 'Nenhum Cliente Encontrado na Lixeira',
        );
        $rewrite = array(
            'slug' => 'cliente',
            'with_front' => true,
            'pages' => true,
            'feeds' => false,
        );
        $args = array(
            'label' => 'Clientes',
            'description' => 'Clientes Gerais',
            'labels' => $labels,
            'supports' => array('title'),
            'taxonomies' => array(),
            'hierarchical' => false,
            'public' => true,
            '_builtin' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => true,
            'menu_icon' => "dashicons-groups",
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'query_var' => 'cliente',
            'rewrite' => $rewrite,
            'capability_type' => 'customer',
            'map_meta_cap' => true
        );
        register_post_type('clientes', $args);
    }

    public static function fields_acf()
    {

        if (function_exists("register_field_group")) {
            register_field_group(array(
                'id' => 'acf_foto-do-casal',
                'title' => 'Foto do Casal',
                'fields' => array(
                    array(
                        'key' => 'field_565da28af191c',
                        'label' => 'Foto Destaque Cliente',
                        'name' => 'photo_customer',
                        'type' => 'image',
                        'save_format' => 'object',
                        'preview_size' => 'thumbnail',
                        'library' => 'uploadedTo',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'clientes',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array(
                    'position' => 'side',
                    'layout' => 'default',
                    'hide_on_screen' => array(),
                ),
                'menu_order' => 0,
            ));

            register_field_group(array(
                'id' => 'acf_texto-de-referencia',
                'title' => 'Texto de Referência',
                'fields' => array(
                    array(
                        'key' => 'field_565da31914311',
                        'label' => 'Conteúdo de referência sobre o casal',
                        'name' => 'content',
                        'type' => 'wysiwyg',
                        'default_value' => '',
                        'toolbar' => 'full',
                        'media_upload' => 'no',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'clientes',
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

    public static function metabox_product()
    {

        $module_list = new Module_List_Presents();
        if (!$module_list->is_post_type('clientes')) return;

        add_meta_box(
            'harness_product',
            'Produtos',
            array(__CLASS__, 'metabox_product_call'),
            null,
            'normal'
        );
    }

    public static function metabox_product_call()
    {

        global $post;

        $cont = 1;

        $products = get_posts(array('post_type' => 'lista-presentes', 'orderby' => 'title', 'order' => 'asc', 'showposts' => -1));
        $val_products = get_post_meta($post->ID, 'products', true);

        echo "<div class='item-product-wrap'>";
            echo "<div class='item-product-wrap-group'>";

            foreach ($products as $product) :

                $key = (!empty($val_products)) ? array_search($product->ID, $val_products) : false;
                $checked = ($key !== false) ? "checked='checked'" : "";

                #$id_thumb = get_post_thumbnail_id($product->ID);
                #$attr_img = apply_filters('get_thumb', $id_thumb, 'thumbnail');

                    echo "<div class='item_product'>";
                        echo "<div class='title_product'> <input type='checkbox' name='products[]' value='$product->ID' $checked> $product->post_title </div>";
                        #echo "<div class='image_product'> <img src='" . $attr_img['url_thumb'] . "' alt='" . $attr_img['title'] . "'> </div>";
                        echo "<div class='subtitle_product'><strong>R$ " . number_format(get_field('preco', $product->ID), "2", ",", ".") . "</strong></div>";
                    echo "</div>";

                if($cont%5 == 0) {
                    echo "<div class='clr'>&nbsp;</div>";
                    echo "</div><div class='item-product-wrap-group'>";
                    $cont = 0;
                }

                $cont++;

            endforeach;

            echo "<div class='clr'>&nbsp;</div>";

            echo "</div>";
        echo "</div>";

    }

    public static function metabox_customer()
    {

        $module_list = new Module_List_Presents();
        if (!$module_list->is_post_type('clientes')) return;

        if(current_user_can('administrator') || current_user_can('cliente')) {

            add_meta_box(
                'harness_customer',
                'Cliente',
                array(__CLASS__, 'metabox_customer_call'),
                null,
                'normal'
            );

        }

    }

    public static function metabox_customer_call()
    {

        global $post;

        /**
         * Usuário a ser atrelado
         */

        $val_customer = get_post_meta($post->ID, 'customer');
        $val_customer = (!empty($val_customer)) ? $val_customer : 0;

        echo "<p><b>Conta de usuário a ser atrelada</b></p>";
        echo "<select name='customer'>";

        $users = get_users(array(
            'orderby' => 'nicename',
            'role' => 'subscriber'
        ));
        echo "<option value='0'>Selecione um usu&aacute;rio</option>";

        foreach ($users as $user) :

            $user_id = $user->ID;
            $name_user = $user->data->display_name;
            $selected = ($val_customer[0] == $user_id) ? "selected='selected'" : "";

            echo "<option value='$user_id' $selected>$name_user</option>";
        endforeach;

        echo "</select>";

        /**
         * Percentual de dedução
         */

        $percent_customer = get_post_meta($post->ID, 'percent_commission');
        $percent_customer = (!empty($percent_customer)) ? $percent_customer : 0;

        echo "<p><b>Percentual a ser deduzido</b></p>";
        echo '<select name="percent_commission" id="percent_commission">';

        for ($i = 0; $i <= 100; $i++) :
            $selected = ($percent_customer[0] == $i) ? "selected==selected" : "";
            echo "<option value='$i' $selected>$i</option>";
        endfor;

        echo '</select>';

    }

    public static function metabox_save($post_id)
    {

        // Previne salvar em modo autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        // Alternativa com função para autosave
        // if ( wp_is_post_autosave( $post_id ) ) return;

        // Verifica se o post_type é Cliente
        $post_type = get_post_type($post_id);
        if ($post_type != "clientes") return;

        // Verifica o status
        $status = get_post_status($post_id);
        if (isset($_GET['action']) != 'trash' && $status != 'auto-draft') :

            remove_action('save_post', array(__CLASS__, 'metabox_save'));

            /**
             * Meta key Cliente (Cliente)
             */
            $meta_key_customer = 'customer';

            if (isset($_POST['customer'])) :

                // Pega o valor atual do cliente
                $meta_value = get_post_meta($post_id, $meta_key_customer);

                if (empty($meta_value)) {
                    add_post_meta($post_id, $meta_key_customer, $_POST['customer']);
                } else {
                    update_post_meta($post_id, $meta_key_customer, $_POST['customer']);
                }

            endif;

            /**
             * Meta key Cliente (Percentual)
             */
            $meta_key_customer = 'percent_commission';

            if (isset($_POST['percent_commission'])) :

                // Pega o valor atual do cliente
                $meta_value = get_post_meta($post_id, $meta_key_customer);

                if (empty($meta_value)) {
                    add_post_meta($post_id, $meta_key_customer, $_POST['percent_commission']);
                } else {
                    update_post_meta($post_id, $meta_key_customer, $_POST['percent_commission']);
                }

            endif;

            /**
             * Meta Key Produtos
             */
            $meta_key_products = 'products';

            if (isset($_POST['products'])) :

                // Pega o valor atual de produtos
                $meta_value = get_post_meta($post_id, $meta_key_products);

                if (empty($meta_value)) {
                    add_post_meta($post_id, $meta_key_products, $_POST['products']);
                } else {
                    update_post_meta($post_id, $meta_key_products, $_POST['products']);
                }

            endif;

            (isset($_POST['customer'])) ? wp_update_post(array('ID' => $post_id, 'post_author' => $_POST['customer'])) : wp_update_post(array('ID' => $post_id));

        endif;

    }

    public static function extra_function_menu(){

        if(!current_user_can('administrator') && !current_user_can('cliente')) {

            remove_menu_page('profile.php');
            remove_menu_page('edit.php?post_type=clientes');

            $client_id = get_current_user_id();
            $clients = get_posts(array(
                'author' => $client_id,
                'post_type' => 'clientes'
            ));

            foreach($clients as $client){
                $client_id = $client->ID;
            }

            add_utility_page("Meu perfil", "Meu perfil", "subscriber", "post.php?post=$client_id&action=edit", "", "dashicons-admin-users");
            if(isset($_GET["post_type"]) && $_GET["post_type"] == "clientes") wp_redirect(get_admin_url( 1, "post.php?post=$client_id&action=edit"));

        }

    }

    public static function extra_function_add_client(){

        if(!current_user_can('administrator') || !current_user_can('cliente')) echo '<style>.page-title-action{display: none !important;}</style>';

    }
}

MLP_Customer::init();