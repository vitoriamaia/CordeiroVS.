<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class View_Pass_Through
{

    private $html;

    public function call_pass_through()
    {
        /* Scripts */
        wp_register_script("ajax_Pass_Through", MPThrough()->plugin_assets() . "/js/pass_through.js", array("jquery"));
        wp_enqueue_script("ajax_Pass_Through");
    }

    public function render($file)
    {

        $file = dirname(__FILE__) . '/' . $file . '.phtml';

        if (file_exists($file)) :

            ob_start();

            require_once($file);
            $this->html = ob_get_clean();

        else :

            $this->html = "O arquivo $file não existe";

        endif;

        return $this->html;

    }

}