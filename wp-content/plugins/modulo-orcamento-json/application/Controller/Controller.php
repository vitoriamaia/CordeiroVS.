<?php

include_once(BASE . '/application/Model/Model.php');
include_once(BASE . '/application/View/View.php');

class Controller_Budget_Request extends Model_Budget_Request
{

    private $Model;
    private $View;

    public function __construct()
    {
        // Carrega o Model e View
        $this->Model = new Model_Budget_Request();
        $this->View = new View_Budget_Request();

        // json Marca do Colchão
        add_action('wp_ajax_mattress_mark', array($this->Model, 'get_mattress_mark'));
        add_action('wp_ajax_nopriv_mattress_mark', array($this->Model, 'get_mattress_mark'));

        // json Colchão
        add_action('wp_ajax_mattress', array($this->Model, 'get_mattress'));
        add_action('wp_ajax_nopriv_mattress', array($this->Model, 'get_mattress'));

        // Chamadas Front
        add_action('wp_enqueue_scripts', array($this->View, 'calls_front'));
    }

}