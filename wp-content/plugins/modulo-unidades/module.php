<?php

/*
Plugin Name: Módulo Unidades
Plugin URI: http://www.e-dead.com.br
Description: Módulo de Unidades criado por Tiago Pires
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

require 'vendor/autoload.php';
use application\Controller\Controller;

class Unity extends Controller{

    public function __construct(){

        parent::__construct();

    }

    public function init_install(){
        $this->install();
    }

    public function init_uninstall(){
        $this->uninstall();
    }

}

$unity = new Unity();

// Ação ao instalar plugin
register_activation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array($unity, 'init_install'));

// Ação ao desinstalar plugin (atualizar)
register_deactivation_hook(dirname(__FILE__) . DIRECTORY_SEPARATOR . basename(__FILE__), array($unity, 'init_uninstall'));