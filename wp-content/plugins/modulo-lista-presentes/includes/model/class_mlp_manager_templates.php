<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MLP_Manager_Templates
{

    public static function init()
    {
        add_action('template_include', array(__CLASS__, 'replace_template'));
    }

    /**
     * Gerenciamento de templates
     * @param $template
     * @return string
     */
    public static function replace_template($template)
    {

        if (is_singular('clientes')) {

            $template = locate_template(array('customers.php'));

            if ('' == $template) {
                $template = MLP()->plugin_path() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'customers.php';
            }

        } else if (is_page(array('checkout' => 'checkout'))) {

            $template = locate_template(array('checkout.php'));

            if ('' == $template) {
                $template = MLP()->plugin_path() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'checkout.php';
            }

        }

        return $template;

    }

}

MLP_Manager_Templates::init();