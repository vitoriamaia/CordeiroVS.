<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class MLP_Queries
{

    /**
     * Pega tabelas
     * @param $table
     * @return mixed
     */
    private function tables($table)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $tables = array(
            'transition_store' => $prefix . "transition_store",
            'posts' => $prefix . "posts"
        );
        return $tables[$table];
    }

    /**
     * Clientes
     * @param string $customer
     * @return array|null|object|string
     */
    public function find_client($customer = '')
    {
        global $wpdb;

        $result = '';

        if (!empty($customer)) {
            $clientes = $this->tables('posts');
            $result = $wpdb->get_results($wpdb->prepare("SELECT ID FROM $clientes WHERE post_title LIKE %s AND post_type = 'clientes' AND post_status = 'publish'", '%' . $customer . '%'));
        }

        return $result;
    }

    /**
     * Todos os clientes com transações
     * @return array|null|object
     */
    public function clients_with_transaction(){
        global $wpdb;
        $table_transition_store = $this->tables('transition_store');
        return $wpdb->get_results("SELECT DISTINCT id_post_customer FROM $table_transition_store", OBJECT);
    }

    public function client_detail($client){
        global $wpdb;
        $table_transition_store = $this->tables('transition_store');
        return $wpdb->get_results("SELECT * FROM $table_transition_store WHERE id_post_customer = $client ORDER BY `data` DESC", OBJECT);
    }

    /**
     * Valores recebidos para único cliente
     * @param $client
     * @return array|null|object
     */
    public function single_client_values($client){
        global $wpdb;
        $transitions = $this->tables('transition_store');
        return $wpdb->get_results("SELECT valor FROM $transitions WHERE id_post_customer = $client AND (status = 3 OR status = 4)", OBJECT);
    }

    /**
     * Grava compra e mensagem do presenteador
     * @param array $content
     * @param $code
     */
    public function insert_message($content = array(), $code){

        if(is_array($content) && !empty($content)){

            global $wpdb;
            $table = $this->tables('transition_store');
            $wpdb->insert($table, $content);
            echo '{"error_status": 0, "msg": "' . $code . '"}';

        } else {

            echo '{"error_status": 1, "msg": "Erro interno"}';

        }

    }

    /**
     * Atualização no código de transação
     * @param $code_transaction
     * @param $checkout_code
     */
    public function update_code_transaction($code_transaction, $checkout_code){
        global $wpdb;
        $table_transition_store = $this->tables('transition_store');
        $wpdb->update($table_transition_store, $code_transaction, $checkout_code);
    }

    /**
     * Atualização do status da compra
     * @param $data_status
     * @param $data_reference
     */
    public function update_status_purchase($data_status, $data_reference){
        global $wpdb;
        $table_transition_store = $this->tables('transition_store');
        $wpdb->update($table_transition_store, $data_status, $data_reference);
    }

    /**
     * Dispara e-mail de contas pagas
     * @param $reference
     */
    public function shoot_mail($reference){

        global $wpdb;
        $table_transition_store = $this->tables('transition_store');
        $contents = $wpdb->get_results("SELECT nome, id_post_customer, id_product, message FROM $table_transition_store WHERE reference = '$reference'", OBJECT);

        foreach ($contents as $content) :

            $name_buyer = $content->nome;
            $presenteado = get_the_title($content->id_post_customer);
            $product_title = get_the_title($content->id_product);
            $message = $content->message;

            $email = "contato@polaristur.com.br";
            #$email = "tiago@e-deas.com.br";

            wp_mail(
                $email,
                "Pagamento Recorrente WebSite Polaris",
                "
                    Pagamento realizado com sucesso.
                    
                    Por: $name_buyer
                    Presenteado: $presenteado
                    Presente: $product_title
                    Mensagem:
                    $message
                    "
            );

        endforeach;
    }

    /**
     * Método de Instalação
     */
    public function install()
    {

        global $wpdb;
        $table = self::tables('transition_store');
        $wpdb->query("
          CREATE TABLE IF NOT EXISTS $table (
            id INT NOT NULL Auto_Increment,
            nome VARCHAR(50),
            email VARCHAR(50),
            message VARCHAR(200),
            id_post_customer INT,
            id_product INT,
            checkout_code VARCHAR(36),
            code_transaction VARCHAR(36),
            reference VARCHAR(100),
            status INT(1),
            valor VARCHAR(10),
            data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;"
        );

        $page = get_page_by_path('checkout');
        if (empty($page)) {
            wp_insert_post(
                array(
                    'post_name' => 'checkout',
                    'post_title' => 'Checkout',
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'menu_order' => 100,
                    'post_content' => ''
                )
            );
        }

        // Permissões para acesso as configurações
        $admin_role = get_role('administrator');
        $admin_role->add_cap('options_store_list');
        $admin_role->add_cap('statistic_store');

        // Permissões para acesso aos clientes
        $admin_role->add_cap('publish_customers');
        $admin_role->add_cap('edit_customers');
        $admin_role->add_cap('delete_customers');
        $admin_role->add_cap('read_private_customers');
        $admin_role->add_cap('edit_private_customers');
        $admin_role->add_cap('delete_private_customers');
        $admin_role->add_cap('edit_published_customers');
        $admin_role->add_cap('delete_published_customers');
        $admin_role->add_cap('edit_others_customers');
        $admin_role->add_cap('delete_others_customers');

        // Permissões para acesso aos presentes
        $admin_role->add_cap('publish_list_gifts');
        $admin_role->add_cap('edit_list_gifts');
        $admin_role->add_cap('delete_list_gifts');
        $admin_role->add_cap('read_private_list_gifts');
        $admin_role->add_cap('edit_private_list_gifts');
        $admin_role->add_cap('delete_private_list_gifts');
        $admin_role->add_cap('edit_published_list_gifts');
        $admin_role->add_cap('delete_published_list_gifts');
        $admin_role->add_cap('edit_others_list_gifts');
        $admin_role->add_cap('delete_others_list_gifts');

        // Atualiza Regras de Reescrita de URL
        flush_rewrite_rules();
    }

    /**
     * Método de Desinstalação
     */
    public function uninstall()
    {

        global $wpdb;
        $table = self::tables('transition_store');
        $wpdb->query("DROP TABLE IF EXISTS $table;");

        $page = get_page_by_path('checkout');
        if (!empty($page)) {
            wp_delete_post($page->ID);
        }

        // Permissões para acesso as configurações
        $admin_role = get_role('administrator');
        $admin_role->remove_cap('options_store_list');
        $admin_role->remove_cap('statistic_store');

        // Permissões para acesso aos clientes
        $admin_role->remove_cap('publish_customers');
        $admin_role->remove_cap('edit_customers');
        $admin_role->remove_cap('delete_customers');
        $admin_role->remove_cap('read_private_customers');
        $admin_role->remove_cap('edit_private_customers');
        $admin_role->remove_cap('delete_private_customers');
        $admin_role->remove_cap('edit_published_customers');
        $admin_role->remove_cap('delete_published_customers');
        $admin_role->remove_cap('edit_others_customers');
        $admin_role->remove_cap('delete_others_customers');

        // Permissões para acesso aos presentes
        $admin_role->remove_cap('publish_list_gifts');
        $admin_role->remove_cap('edit_list_gifts');
        $admin_role->remove_cap('delete_list_gifts');
        $admin_role->remove_cap('read_private_list_gifts');
        $admin_role->remove_cap('edit_private_list_gifts');
        $admin_role->remove_cap('delete_private_list_gifts');
        $admin_role->remove_cap('edit_published_list_gifts');
        $admin_role->remove_cap('delete_published_list_gifts');
        $admin_role->remove_cap('edit_others_list_gifts');
        $admin_role->remove_cap('delete_others_list_gifts');

        // Atualiza Regras de Reescrita de URL
        flush_rewrite_rules();
    }

}