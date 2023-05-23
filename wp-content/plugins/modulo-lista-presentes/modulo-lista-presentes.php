<?php

/**
 * Plugin Name: Módulo Lista Presentes
 * Plugin URI: https://www.facebook.com/tao.pires
 * Description: Módulo de Lista de Presentes. Requer ACF e WP Toolkit
 * Version: 1.0
 * Author: Tiago Pires
 * Author URI: https://www.facebook.com/tao.pires
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class Module_List_Presents
{

    /**
     * @var null
     * Instance
     */
    private static $_instance = null;

    /**
     * Cart Instance
     * @var MLP_Cart
     */
    public $cart = null;

    /**
     * Cart Instance
     * @var MLP_PagSeguro
     */
    public $pagseguro = null;

    /**
     * Queries
     * @var MLP_Queries
     */
    public $queries = null;

    /**
     * Module_List_Presents constructor.
     */
    public function __construct()
    {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Instância Principal do Módulo de Lista de Presentes.
     * @static
     * @see MPL()
     * @return Module_List_Presents - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    private function is_request($type)
    {
        switch ($type) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined('DOING_AJAX');
            case 'cron' :
                return defined('DOING_CRON');
            case 'frontend' :
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
        }
    }

    private function includes()
    {

        // Post_types
        include_once('includes/model/post_types/class_mlp_customer.php');
        include_once('includes/model/post_types/class_mlp_list_gift.php');

        // Scripts
        include_once('includes/view/scripts/scripts.php');

        // Consultas SQL
        include_once('includes/model/queries/class_mlp_queries.php');
        $this->queries = new MLP_Queries();

        if ($this->is_request('frontend')) {

            // Templates e shortcodes
            include_once('includes/model/class_mlp_manager_templates.php');
            include_once('includes/view/shortcodes/form_find_customer.php');

            // Carrinho
            include_once('includes/model/modules/class_mlp_cart.php');
            $this->cart = new MLP_Cart();

            // Pagseguro
            include_once('includes/model/modules/class_mlp_pagseguro.php');
            $this->pagseguro = new MLP_PagSeguro();
        }

        if ($this->is_request('admin')) {

            // Página de opções
            include_once('includes/view/options_store/page_options/options_store.php');
            include_once('includes/view/options_store/page_statistics/statistic_store.php');

        }

    }

    private function init_hooks()
    {
        // Chama Métode Instalação
        register_activation_hook(__FILE__, array($this->queries, 'install'));

        // Chama Métode Desinstalação
        register_deactivation_hook(__FILE__, array($this->queries, 'uninstall'));
    }

    /**
     * Verifica o Post_Type atual
     * @param $name
     * @return bool
     */
    public function is_post_type($name)
    {

        $post_type = false;

        if (isset($_GET['post'])) {

            $post_type = get_post_type($_GET['post']);

        } elseif (isset($_GET['post_type'])) {

            $post_type = $_GET['post_type'];

        }

        return ($name == $post_type) ? true : false;

    }

    public function plugin_url()
    {
        return untrailingslashit(plugins_url('/', __FILE__));
    }

    public function plugin_path()
    {
        return untrailingslashit(plugin_dir_path(__FILE__));
    }

}

function MLP()
{
    return Module_List_Presents::instance();
}

MLP();

