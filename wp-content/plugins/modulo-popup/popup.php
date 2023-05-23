<?php

/*
Plugin Name: Módulo Popup
Description: Módulo de Popup
Version: 1.0
Author: taotiago
Author URI: https://profiles.wordpress.org/taotiago
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Popup
{

    /**
     * @var Popup
     */
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
    }

    private function is_request($type)
    {
        switch ($type) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined('DOING_AJAX');
            case 'cron' :
                return defined('DOING_CRON');
            case 'frontend' :
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
        }
    }

    private function includes()
    {
        include_once('includes/post_type/popup.php');

        if ($this->is_request('frontend')) {
            include_once('includes/html/popup.php');
        }
    }

}

Popup::instance();