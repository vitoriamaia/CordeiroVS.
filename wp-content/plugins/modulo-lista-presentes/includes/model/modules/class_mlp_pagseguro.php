<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class MLP_PagSeguro
{

    public function __construct()
    {
        // PagSeguro XML
        add_action('wp_ajax_pagseguro_method', array(__CLASS__, 'pagseguro_method'));
        add_action('wp_ajax_nopriv_pagseguro_method', array(__CLASS__, 'pagseguro_method'));

        // PagSeguro Notificação
        add_action('wp_ajax_pagseguro_notification', array(__CLASS__, 'pagseguro_notification'));
        add_action('wp_ajax_nopriv_pagseguro_notification', array(__CLASS__, 'pagseguro_notification'));
    }

    public static function pagseguro_method()
    {

        /// Dados do vendedor
        $email_receiver = get_option('email_pagseguro');
        $token = (get_option('enable_ratification') == 'on') ? get_option('token_pagseguro_sendbox') : get_option('token_pagseguro');
        $return = get_home_url() . '/wp-admin/admin-ajax.php?action=pagseguro_notification';

        // Dados do comprador
        $name = (isset($_POST['name'])) ? $_POST['name'] : "";
        $email = (isset($_POST['email'])) ? $_POST['email'] : "";
        $message = (isset($_POST['message'])) ? $_POST['message'] : "";
        $client = (isset($_POST['client'])) ? $_POST['client'] : "";

        $datament = "?email=$email_receiver&token=$token";
        $url_payment = (get_option('enable_ratification') == 'on') ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/' . $datament : 'https://ws.pagseguro.uol.com.br/v2/checkout/' . $datament;

        // Carrinho de compras
        $products = MLP()->cart->get_cart();
        $item = '';
        foreach ($products as $product) :
            $id_product = $product["content"]["id_product"];
            $descr = get_the_title($id_product);
            $price = number_format(get_field('preco', $id_product), "2", ".", "");
            $item .= "
                <item>
                    <id>$id_product</id>
                    <description>$descr</description>
                    <amount>$price</amount>
                    <quantity>1</quantity>
                </item>
            ";
        endforeach;

        $reference = md5(date('F j, Y, g:i a'));

        $xml = '<?xml version="1.0" encoding="ISO-8859-1" standalone="yes"?>
            <checkout>
                <currency>BRL</currency>
                <notificationURL>' . $return . '</notificationURL>
                <items>' . $item . '</items>
                <reference>' . $reference . '</reference>
                <sender>
                    <name>' . $name . '</name>
                    <email>' . $email . '</email>
                </sender>
            </checkout>';

        $curl = curl_init($url_payment);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, Array('Content-Type: application/xml; charset=ISO-8859-1'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        $xml = curl_exec($curl);

        if ($xml == 'Unauthorized') {
            echo '{"error_status": 1, "msg": "Não Autorizado ' . $url_payment . '"}';
            exit;
        }

        curl_close($curl);

        $xml = simplexml_load_string($xml);

        if (isset($xml->error)) {

            switch ($xml->error->code) {
                case 11012:
                    $msg_error = "Nome inválido. Tente novamente.";
                    break;
                default:
                    $msg_error = "Erro no processamento. Tente novamente mais tarde.";
                    break;
            }

            echo '{"error_status": 1, "msg": "' . $msg_error . '"}';

        } else {

            $data = array(
                'nome' => $name,
                'email' => $email,
                'message' => $message,
                'id_post_customer' => $client,
                'id_product' => $id_product,
                'checkout_code' => $xml->code,
                'reference' => $reference,
                'valor' => $price,
                'status' => 1,
            );

            MLP()->queries->insert_message($data, $xml->code);

        }

        exit;

    }

    public static function pagseguro_notification()
    {

        if (isset($_POST['transactionCode']) && isset($_POST['checkoutCode'])) {

            $code_transaction = array('code_transaction' => $_POST['transactionCode']);
            $checkout_code = array('checkout_code' => $_POST['checkoutCode']);

            MLP()->queries->update_code_transaction($code_transaction, $checkout_code);
            MLP()->cart->flush_cart();

            echo get_permalink(get_page_by_path('checkout')) . "?result=finish";

        }

        if (isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction') {

            (get_option('enable_ratification') == 'on') ? header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br") : header("access-control-allow-origin: https://pagseguro.uol.com.br");
            $token = (get_option('enable_ratification') == 'on') ? get_option('token_pagseguro_sendbox') : get_option('token_pagseguro');
            $email_receiver = get_option('email_pagseguro');
            $notification = $_POST['notificationCode'];

            $datament = $notification . '?email=' . $email_receiver . '&token=' . $token;
            $url_payment = (get_option('enable_ratification') == 'on') ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/' . $datament : 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $datament;

            $curl = curl_init($url_payment);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $transaction = curl_exec($curl);
            curl_close($curl);

            if ($transaction == 'Unauthorized') {
                //Insira seu código avisando que o sistema está com problemas, sugiro enviar um e-mail avisando para alguém fazer a manutenção

                exit;//Mantenha essa linha
            }
            $transaction = simplexml_load_string($transaction);

            // Status da compra
            $status = $transaction->status;
            // Referência da compra
            $reference = $transaction->reference;

            // Empacotando status e referência
            $data_status = array('status' => $status);
            $data_reference = array('reference' => $reference);

            MLP()->queries->update_status_purchase($data_status, $data_reference);
            if ($status == 3) MLP()->queries->shoot_mail($reference);

        }

        exit;

    }

}