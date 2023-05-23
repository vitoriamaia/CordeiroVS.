<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class View_Birthday
{

    private $html = null;

    public function call_birthday()
    {
        /* Scripts */
        wp_register_script("ajax_birthday", MBDay()->plugin_assets() . "/js/birthday.js",
            array("jquery"), false, true);
        wp_enqueue_script("ajax_birthday");
        wp_localize_script("ajax_birthday", "birthday",
                array("listin" => admin_url("admin-ajax.php?action=birthday_all")
            )
        );
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