<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Frontend_Scripts
{

    public static function init()
    {
        add_action('wp_enqueue_scripts', array(__CLASS__, 'calls_front'));
    }

    public static function calls_front()
    {
        // Scripts Gerais
        wp_enqueue_script("maps_api", "https://maps.googleapis.com/maps/api/js?key=AIzaSyAVCmUP1CbQZd8lte5YMFgTS8POmaZaYr4&amp;sensor=false", array(), "1.0", true);
        wp_enqueue_script("map_generate", ADS()->plugin_url() . "/assets/js/map_generate.js", array('maps_api', 'jquery'), "1.0", true);
    }

}

Frontend_Scripts::init();