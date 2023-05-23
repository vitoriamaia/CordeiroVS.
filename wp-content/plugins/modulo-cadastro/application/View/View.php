<?php

class View_Register
{

    private $html;

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

    public function call_back()
    {

        // jMask
        wp_register_script( "jmask" , plugin_dir_url( __FILE__ ) . "build/jquery.mask.min.js", array(), "1.0", true);

        // Scripts Gerais
        wp_enqueue_script( "general" , plugin_dir_url( __FILE__ ) . "build/script.js", array('jmask'), "1.0", true);

    }

}