<?php

/**
 * Área de Login
 */

// Logo Customizada
function custom_logo_login() {
    ?>
    <style type="text/css">
        h1 a {
            width: 320px !important;
            background: url('<?php echo WP_IMAGES ?>/login.png') no-repeat center !important;
        }
    </style>
<?php
}

// URL Logo Customizada
function custom_logo_login_url() { return get_home_url(); }

// Título Logo Customizada
function custom_logo_login_title() { return get_option('blogname'); }

// Área Login
function area_login(){

    // Logo Customizada
    add_action( 'login_head', 'custom_logo_login' );

    // URL Logo Customizada
    add_filter( 'login_headerurl', 'custom_logo_login_url' );

    // Título Logo Customizada
    add_filter( 'login_headertitle', 'custom_logo_login_title' );

}

// Carrega Funções da Área de Login
add_action( 'login_init', 'area_login' );


/**
 * Área de Admin
 */

// Rodapé do Admin Customizado
function custom_admin_footer() { echo '<a target="_blank" title="E-deas" href="http://www.e-deas.com.br">E-deas</a> &copy; ' . date( 'Y' ); }

// Esconde Versão do WP no Rodapé do Admin
function hide_footer_version() { return ''; }

// Remove a Logo do WP da Barra de Admin
function remove_logo_toolbar( $wp_toolbar ) {
    global $wp_admin_bar;
    $wp_toolbar->remove_node( 'wp-logo' );
    $wp_toolbar->remove_node( 'comments' );
    $wp_toolbar->remove_node( 'new-content' );
    $wp_toolbar->remove_node( 'wpseo-menu' );
}

// Remove Widgets Padrões do Dashboard
function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
}

// Remover Campos Desnecessários dos Usuários
function hide_profile_fields( $contactmethods ) {
    unset($contactmethods["googleplus"]);
    unset($contactmethods["twitter"]);
    unset($contactmethods["facebook"]);
    return $contactmethods;
}

// Customização Menu
function custom_menu_admin() {

    if(!current_user_can('administrator')) {
        // remove_menu_page('index.php');                  // Painel
        // remove_menu_page('edit.php');                   // Posts
        // remove_menu_page('upload.php');                 // Mídia
        // remove_menu_page('edit.php?post_type=page');    // Página
        // remove_menu_page('edit-comments.php');          // Comentários
        // remove_menu_page('themes.php');                 // Aparência
        // remove_menu_page('plugins.php');                // Plugins
        // remove_menu_page('users.php');                  // Usuários
        // remove_menu_page('tools.php');                  // Ferramentas
        // remove_menu_page('options-general.php');        // Configurações
    }

}

// Customização Admin (Geral)
function custom_area_admin(){

    /*
    $post_types = get_post_types();
    foreach($post_types as $post_type){
        remove_meta_box('transposh_setlanguage', $post_type, 'advanced');
        remove_meta_box('transposh_postpublish', $post_type, 'side');
    }
    */

}

// Área Admin
if (is_admin()) :

    // Adição de Excerpt nas Páginas
    add_post_type_support('page', 'excerpt');

    // Rodapé do Admin Customizado
    add_filter( 'admin_footer_text', 'custom_admin_footer' );

    // Esconde Versão do WP no Rodapé do Admin
    add_filter( 'update_footer', 'hide_footer_version', 999 );

    // Remove a Logo do WP da Barra de Admin
    add_action( 'admin_bar_menu', 'remove_logo_toolbar', 999 );

    // Remove Widgets Padrões do Dashboard
    add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

    // Remover Campos Desnecessários dos Usuários
    add_filter('user_contactmethods', 'hide_profile_fields', 10, 1);

    // Customização Menu
    add_action( 'admin_menu', 'custom_menu_admin' );

    // Customização Admin (Geral)
    add_action( 'admin_init', 'custom_area_admin' );

    // Desabilita Updates
    // add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;") );

endif;