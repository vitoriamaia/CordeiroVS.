<?php

/**
 * Adiciona Login em Todas as Páginas
 */
function login()
{
    if (!is_user_logged_in()) {
        auth_redirect();
    }
}

#add_action('wp_head', 'login');


/**
 * Adicionando constants
 */
if (!defined('WP_HOME')) {
    define('WP_HOME', get_home_url());
}

if (!defined('WP_DIRECTORY')) {
    define('WP_DIRECTORY', get_template_directory_uri());
}

if (!defined('WP_STYLES')) {
    define('WP_STYLES', WP_DIRECTORY . '/build/css');
}

if (!defined('WP_SCRIPTS')) {
    define('WP_SCRIPTS', WP_DIRECTORY . '/build/js');
}

if (!defined('WP_IMAGES')) {
    define('WP_IMAGES', WP_DIRECTORY . '/build/images');
}


/**
 * Include arquivos de configurações
 */
include_once('app/custom_functions.php');
include_once('app/custom_admin.php');
include_once('app/wp-bootstrap-navwalker.php');
include_once('app/wp-bootstrap-pagination.php');
include_once('app/extra-functions.php');
include_once('app/wp-breadcrumbs.php');


/**
 * Auto Loading nos arquivos de configuração do tema
 */
$directories = array('app/shortcodes', 'app/widgets', 'app/poststypes');
$types = array( 'php' );

foreach ($directories as $directory){

    $path_absolute = __DIR__ . DIRECTORY_SEPARATOR . $directory;

    if ( $handle = opendir($path_absolute) ) {

        while ( $entry = readdir( $handle ) ) {

            $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );

            if( in_array( $ext, $types ) ){

                include_once ($path_absolute . DIRECTORY_SEPARATOR . $entry);

            }

        }

        closedir($handle);

    }

}

/**
 * Utilizando funções do Theme Page Options ( ACF ) - Descomentar após ativar o plugin
 */
if (function_exists('acf_add_options_sub_page')) {
    acf_add_options_sub_page('Opções do site');
    acf_set_options_page_title("Opções do site");
}
add_filter( 'wp_image_editors', 'change_graphic_lib' );

function change_graphic_lib($array) {
  return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}
