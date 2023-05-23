<?php

if ( ! defined( 'ABSPATH' ) ) exit;

include_once( 'view_base.php' );

/**
 * Class Webservice_View
 */
class Webservice_View extends Webservice_View_Base {

    public function __construct() {

        if ( !is_admin() ) {

            add_action( 'wp_enqueue_scripts', array( $this, 'calls_front' ) );

            add_shortcode( 'form_webservice', array( $this, 'form_webservice' ) );
            add_shortcode( 'content_webservice', array( $this, 'content_webservice' ) );

        }
    }

    public function calls_front() {
        $url = webservice()->url;

        $ip = webservice()->get_model()->get_ip();
        $ip = $ip[0]->ws_address;

        $doc = (isset($_POST['contrato'])) ? $_POST['contrato'] : '';

        wp_enqueue_script( 'webservice', $url . '/assets/js/main.js', array( 'jquery' ) );
        wp_localize_script( 'webservice', 'webservice', array(
            'document'  => $doc,
            'ip_doc' => $ip,
            'ajaxWebservice' => admin_url( 'admin-ajax.php?action=get_content_json' )
        ) );
    }

    public function form_webservice() {
        return $this->form( 'webservice' );
    }

    public function content_webservice() {
        echo $this->html( 'content_webservice' );
    }

}