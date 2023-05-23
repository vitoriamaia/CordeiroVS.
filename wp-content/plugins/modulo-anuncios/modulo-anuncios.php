<?php

/**
 * Plugin Name: Módulo Anúncios
 * Plugin URI: https://www.facebook.com/tao.pires
 * Description: Módulo de Anúncios com taxonomias local e tipo.
 * Version: 1.0
 * Author: Tiago Pires
 * Author URI: https://www.facebook.com/tao.pires
 */
class Ads
{

    private static $_instance = null;

    private function __construct()
    {
        $this->includes();
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined( 'DOING_AJAX' );
            case 'cron' :
                return defined( 'DOING_CRON' );
            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

    private function includes(){
        include_once('includes/post_type/ads.php');

        if ( $this->is_request( 'frontend' ) ) {
            include_once('includes/class_frontend_scripts.php');
            include_once('includes/shortcodes/class_form_search_ads.php');
            include_once('includes/shortcodes/class_nav_categories.php');
            include_once('includes/queries/class_query_result.php');
        }
    }

    public function plugin_url() {
        return untrailingslashit( plugins_url( '/', __FILE__ ) );
    }

    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }

}

function ADS(){
    return Ads::instance();
};

ADS();