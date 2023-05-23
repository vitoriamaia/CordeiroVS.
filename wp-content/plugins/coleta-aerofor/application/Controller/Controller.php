<?php

include_once(BASE . '/application/Model/Model.php');
include_once(BASE . '/application/View/View.php');

class Controller_Collect extends Model_Collect
{

    private $Model;
    private $View;

    private $email;
    private $password;

    private $status_tracking = true;
    private $message;

    public function __construct()
    {

        if (!session_id()) session_start();

        // Carrega o Model e View
        $this->Model = new Model_Collect();
        $this->View = new View_Collect();

        // Link Logout
        add_action('wp_ajax_logout', array($this, 'logout'));
        add_action('wp_ajax_nopriv_logout', array($this, 'logout'));

        // Cria todos os shortcodes (formmulários)
        add_shortcode('form_rastreamento', array($this, 'tracking'));
        add_shortcode('form_coleta', array($this, 'collect'));
        add_shortcode('form_cotacao', array($this, 'quotation'));

    }

    // Logout
    public function logout()
    {

        $this->Model->flush_login();
        wp_redirect(get_home_url() . '/rastreamento/');
        exit;

    }

    // Formulário Login Rastreamento
    // Página de Conteúdo Rastreamento
    public function tracking()
    {

        if (isset($_POST['tracking'])) {

            $this->email = $_POST['email'];
            $this->password = $_POST['senha'];

            $this->message_return($this->Model->validate_email($this->email));
            $this->message_return($this->Model->validate_empty($this->password));

            if ($this->status_tracking) $this->session_login($this->email, $this->password);

            $this->message_return($this->Model->verify_user());

        }

        $login = $this->get_login();
        
        echo $this->message;
        echo (empty($login)) ? $this->get_form('rastreamento') : $this->get_part('rastreamento');

    }

    // Exibição Conteúdo Rastreamento
    public function display_tracking()
    {

        return $this->get_tracking();

    }

    // Formulário Coleta e
    // Inserção Coleta
    public function collect()
    {

        if (isset($_POST['collect'])) {

            $status = $this->insert_collect($_POST);

            if($status == false){

                $this->message_return('Ocorreu um erro ao inserir os dados');

            } else {

                $this->message_return($status);
                
            }

        }

        echo $this->message;
        echo $this->get_form('coleta');

    }

    // Formulário Cotação e
    // Inserção Cotação
    public function quotation()
    {

        echo $this->get_form('cotacao');

    }

    // Mensagens de Sistema
    public function message_return($message)
    {

        if ($message) {

            $this->status_tracking = false;
            $this->message .= "<div class='message'> $message </div>";

        }

    }

    // Pega templates
    public function get_part($file)
    {

        return $this->View->render('templates/' . $file);

    }

    // Pega Formulários
    public function get_form($form)
    {

        return $this->View->render('forms/' . $form);

    }

}