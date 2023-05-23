<?php

/*
Plugin Name: Módulo Webservice
Description: Módulo de Webservice
Version: 1.0
Author: taotiago
Author URI: https://profiles.wordpress.org/taotiago
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final
class Webservice
{

    /**
     * @var Webservice
     */
    private static $_instance = null;

    /**
     * @var Webservice_Model
     */
    private $Model = null;

    /**
     * @var string
     */
    public $url;

    private function __construct()
    {
        $this->init();
        $this->includes();
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    private function init(){
        $this->url = untrailingslashit(plugins_url('/', __FILE__));
    }

    private function includes()
    {
        include_once('includes/model/model.php');
        include_once('includes/view/view.php');

        $this->Model = new Webservice_Model();
        new Webservice_View();
    }

    public function get_model(){
        return $this->Model;
    }

}

function webservice(){
    return Webservice::instance();
};

webservice();