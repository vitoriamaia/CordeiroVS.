<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MLP_Statistic_Store
{

    public static function init()
    {
        // Insere menu de Opções e Estatística
        add_action('admin_menu', array(__CLASS__, 'statistic_store'));
    }

    public static function statistic_store()
    {
        add_menu_page(
            'Opções da Loja',
            'Estatísticas da Lista de Presentes',
            'statistic_store',
            'statistic_store',
            array(__CLASS__, 'statistic_store_html'),
            'dashicons-chart-pie',
            4
        );
    }

    public static function statistic_store_html()
    { ?>

        <div class="wrap">

            <div class="record">
                <h2>Estatísticas</h2>
            </div>

            <?php

            if (!isset($_GET['detail'])) {

                if (current_user_can('administrator') || current_user_can('client'))
                    include_once('statistic_store_operator.php');

            } else {

                include_once('statistic_store_detail.php');

            }

            ?>

        </div>

    <?php }

}

MLP_Statistic_Store::init();