<?php

/**
 * Plugin Name: Coleta Aerofor
 * Plugin URI: https://www.facebook.com/tao.pires
 * Description: Projeto coleta Aerofor
 * Version: 0.0.1
 * Author: taotiago
 * Author URI: https://www.facebook.com/tao.pires
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('BASE', dirname(__FILE__));

require 'application/Controller/Controller.php';

class Collect extends Controller_Collect
{

    public function __construct()
    {
        parent::__construct();
    }

}

$unity = new Collect();

// Ação ao instalar plugin
#register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array($unity, 'init_install'));

// Ação ao desinstalar plugin (atualizar)
#register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array($unity, 'init_uninstall'));