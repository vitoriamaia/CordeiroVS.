<?php

/**
 * ====================================================================================
 * Link (perdeu senha)
 * @return string
 */
function custom_login_lostpassword_url(){ return get_home_url() . '/wp-login.php?action=lostpassword'; }
add_filter("lostpassword_url", "custom_login_lostpassword_url");

/**
 * ====================================================================================
 * Remoção de conteúdo do painel
 */
function remove_metabox_admin()
{

    /* Post Type Pedidos */
    remove_meta_box('postcustom', 'shop_order', 'normal');
    remove_meta_box('woocommerce-order-downloads', 'shop_order', 'normal');

    /* Post Type Produtos */
    remove_meta_box('commentsdiv', 'product', 'normal');
    remove_meta_box('tagsdiv-product_tag', 'product', 'side');

    /* Retira os dados do produto no woocommerce */
    #remove_meta_box('woocommerce-product-data', 'product', 'normal');

}

function remove_data_product()
{ ?>

    <script>
        jQuery(document).ready(function ($) {
            // Tipo de produto
            //$('#woocommerce-product-data .type_box').remove();

            // Opções avançadas
            $('#woocommerce-product-data .advanced_options').remove();

            // Entrega
            $('#woocommerce-product-data .shipping_options').remove();
        })
    </script>

    <?php
}

if (is_admin()) :
    // Customização admin (geral)
    add_action('do_meta_boxes', 'remove_metabox_admin');

    // Remoção de dados dos produtos
    add_action('admin_head', 'remove_data_product');
endif;

/**
 * ====================================================================================
 * Remoção de Hooks
 */
#remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
#remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);

#remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
#remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

# Itens das internas (produtos)
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
#remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

# Itens do loop (produtos)
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);


/**
 * @return bool
 * Remove título listagem dos produtos
 */
function override_page_title(){ return false; }
# add_filter('woocommerce_show_page_title', 'override_page_title');

/**
 * @param $enqueue_styles
 * @return mixed
 * Remove each style one by one
 */
function jk_dequeue_styles($enqueue_styles)
{
    //unset($enqueue_styles['woocommerce-general']);    // Remove the gloss
    unset($enqueue_styles['woocommerce-layout']);        // Remove the layout
    unset($enqueue_styles['woocommerce-smallscreen']);    // Remove the smallscreen optimisation
    return $enqueue_styles;
}
# add_filter('woocommerce_enqueue_styles', '__return_false');
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );

/**
 * Remove Editor Produto
 */
function remove_editor(){ remove_post_type_support('product', 'editor'); }
add_action('admin_init', 'remove_editor');

/**
 * Exibe nome 'Comprar' no botão de compras
 * @return string
 */
function add_to_cart_text(){ return 'Comprar'; }
add_filter('woocommerce_product_add_to_cart_text', 'add_to_cart_text');

/**
 * Remove contagem de produtos e ordenação
 */
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);