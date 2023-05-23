<?php

/*
Plugin Name: Módulo Orçamento (Solicitação)
Plugin URI: http://www.e-deas.com.br
Description: Módulo de Orçamento criado por Tiago Pires
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'BASE', dirname(__FILE__) );
define( 'BUILD', plugin_dir_url( __FILE__ ) . "application/View/build" );

require 'application/Controller/Controller.php';

class Budget_Request extends Controller_Budget_Request
{

    public function __construct()
    {
        parent::__construct();
    }

}

$Budget_Request_Object = new Budget_Request();