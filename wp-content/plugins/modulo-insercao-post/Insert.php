<?php

/**
 * Plugin Name: Insert 
 * Description: Cria conteúdo (post) a partir da ação do usuário
 * Version: 1.5
 * Author: Tiago Pires
 * Author URI: https://www.facebook.com/tao.pires
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class Insert_Post_External
{

    /**
     * Insert_Post_External Instance
     * @var Insert_Post_External
     */
    private static $_instance = null;

    /**
     * Insert constructor.
     */
    public function __construct()
    {
        $this->includes();
    }

    /**
     * Instância Principal do Módulo de Lista de Presentes.
     * @static
     * @see Insert_Post_External
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) self::$_instance = new self;
    }

    /**
     * Seleciona o tipo de requisição
     * @param $type
     * @return bool
     */
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

    /**
     * Includes dos arquivos
     */
    private function includes()
    {
        if ($this->is_request('frontend')) {

            // Scripts
            include_once('includes/model/class_insert_post.php');
            include_once('includes/view/short_code.php');

        }
    }

}

Insert_Post_External::instance();