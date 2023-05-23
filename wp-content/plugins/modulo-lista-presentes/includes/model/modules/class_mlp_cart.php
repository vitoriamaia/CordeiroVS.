<?php

class MLP_Cart
{

    public function __construct()
    {

        if (!session_id()) :
            session_start();

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

        endif;

        add_action('wp_ajax_cart_method', array($this, 'cart_method'));
        add_action('wp_ajax_nopriv_cart_method', array($this, 'cart_method'));

    }

    public function cart_method()
    {

        if (method_exists($this, $_POST['action_checkout'])) {

            $action = $_POST['action_checkout'];

            $id_buy = $_POST['id_client'] . $_POST['id_product'];

            $cart = array(
                'content' => array(
                    'id_client' => $_POST['id_client'],
                    'id_product' => $_POST['id_product']
                )
            );

            $this->$action($id_buy, $cart);

        };

        echo $_POST['id_client'];

        exit;

    }

    private function add($id_buy = '', $cart = '')
    {

        $this->flush_cart();

        if (!isset($_SESSION['cart'][$id_buy])) {
            $_SESSION['cart'] = array($id_buy => $cart);
        }

        return 0;

    }

    public function get_cart()
    {

        return (isset($_SESSION['cart'])) ? $_SESSION['cart'] : "";

    }

    public function flush_cart()
    {

        if (isset($_SESSION['cart'])) unset($_SESSION['cart']);

    }

}