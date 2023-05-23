<?php

/**
 * Plugin Name: Export_XML_Associates
 * Plugin URI: https://www.facebook.com/tao.pires
 * Description: Export_XML_Associates
 * Version: 1.0
 * Author: Tiago Pires
 * Author URI: https://www.facebook.com/taotiago
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define('BASE', dirname(__FILE__));

define('FILE', basename(__FILE__));

require 'application/Controller/Controller.php';

class Export_XML_Associates extends Controller_XML_Associates
{

    public function __construct()
    {
        parent::__construct();
    }

}

$export_xml = new Export_XML_Associates();