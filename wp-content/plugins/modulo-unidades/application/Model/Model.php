<?php

namespace application\Model;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Model{

    public function tables($table){
        global $wpdb;
        $tables = array(
            "unities" => $wpdb->prefix . "unity_unities",
            "regions" => $wpdb->prefix . "unity_regions",
        );
        return $tables[$table];
    }

    public function create_tables(){
        global $wpdb;
        $unities = $this->tables('unities');
        $regions = $this->tables('regions');

        $wpdb->query("CREATE TABLE IF NOT EXISTS $unities ( id int(11) NOT NULL Auto_Increment, unidade text, endereco text, cidade text, estado text, regiao int(5), PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");
        $wpdb->query("CREATE TABLE IF NOT EXISTS $regions ( id int(5) NOT NULL Auto_Increment, regioes varchar(200), PRIMARY KEY (id) ) CHARACTER SET utf8 COLLATE utf8_general_ci;");

        // Adiciona permissões de acesso ao cadastro de unidades
        $admin_role = get_role( 'administrator' );
        $admin_role->add_cap( 'unities' );
    }

    public function drop_tables(){
        global $wpdb;
        $unities = $this->tables('unities');
        $regions = $this->tables('regions');

        $wpdb->query("DROP TABLE IF EXISTS $unities");
        $wpdb->query("DROP TABLE IF EXISTS $regions");

        // Remove permissões de acesso ao cadastro de unidades
        $admin_role = get_role( 'administrator' );
        $admin_role->remove_cap( 'unities' );
    }

    public function select_table($table){
        global $wpdb;
        $table = $this->tables($table);
        return $wpdb->get_results( "SELECT * FROM $table ORDER BY id DESC", OBJECT );
    }

    public function select_table_id($table, $id){
        global $wpdb;
        $table = $this->tables($table);
        return $wpdb->get_results( "SELECT * FROM $table WHERE id = '$id' ORDER BY id DESC", OBJECT );
    }

    public function save_unities(){
        global $wpdb;
        $table = $this->tables('unities');

        $dados = array();
        $dados['unidade'] = $_POST['unidade'];
        $dados['endereco'] = $_POST['endereco'];
        $dados['estado'] = $_POST['estado'];
        $dados['cidade'] = $_POST['cidade'];
        $dados['regiao'] = $_POST['regiao'];

        if(!isset($_POST['id'])){

            $wpdb->insert($table, $dados, '%s');
            wp_redirect( admin_url( 'admin.php?page=unities&tab=unities&msg=reg_insert'));

        } else {

            $id = $_POST['id'];
            $wpdb->update($table, $dados, array( 'id' => $id ), array( '%s', '%s' ), array( '%d' ) );
            wp_redirect( admin_url( "admin.php?page=unities&tab=edit_unity&id=$id&msg=reg_update"));

        }

        exit;
    }

    public function save_regions(){
        global $wpdb;
        $table = $this->tables('regions');

        $dados = array();
        $dados['regioes'] = $_POST['regioes'];

        if(isset($_POST['id'])){

            $wpdb->update($table, $dados, array( 'id' => $_POST['id'] ), array( '%s', '%d' ), array( '%d' ) );
            wp_redirect( admin_url( 'admin.php?page=unities&tab=regions&msg=reg_update'));

        } else {

            $wpdb->insert($table, $dados, '%s');
            wp_redirect( admin_url( 'admin.php?page=unities&tab=regions&msg=reg_insert'));

        }

        exit;
    }

    public function delete_reg(){
        $table_ref = $_GET['table'];
        $id = $_GET['id'];

        if(!empty($table_ref) && !empty($id)) :

            global $wpdb;
            $table = $this->tables($table_ref);
            $wpdb->query("DELETE FROM $table WHERE id='$id'");

            wp_redirect( admin_url( "admin.php?page=unities&tab=$table_ref&msg=reg_del"));

        endif;

        exit;
    }

    public function get_cities(){
        global $wpdb;
        $cities = $this->tables('unities');
        $cities = $wpdb->get_results("SELECT DISTINCT cidade FROM $cities", OBJECT);
        foreach($cities as $city){
            $city_content[] = array(
                'city' => $city->cidade
            );
        }

        echo (json_encode($city_content));
        exit;
    }

    public function get_unity(){
        global $wpdb;
        $unities = $this->tables('unities');
        $cidade = $_GET['cidade'];
        if(!$cidade) return false;
        $unities = $wpdb->get_results("SELECT * FROM $unities WHERE cidade = '$cidade'");
        foreach($unities as $unity){
            $unity_content[] = array(
                'unidade'    => $unity->endereco
            );
        }

        echo (json_encode($unity_content));
        exit;
    }

}