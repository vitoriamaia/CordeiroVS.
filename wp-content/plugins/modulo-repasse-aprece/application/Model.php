<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Model_Pass_Through {

    private $prefecture = null;
    private $month = null;
    private $year = null;
    private $type = null;
    private $typeExt = null;

    public function v_post()
    {
        if(isset($_POST['pass_through'])){
            $this->prefecture = (isset($_POST['prefecture'])) ? $_POST['prefecture'] : "";
            $this->month = (isset($_POST['month_pass'])) ? $_POST['month_pass'] : "";
            $this->year = (isset($_POST['year_pass'])) ? $_POST['year_pass'] : "";
            $this->type = (isset($_POST['type_pass'])) ? $_POST['type_pass'] : 1;
        }
    }

    public function tables($table)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $tables = array(
            'prefeitura' => $prefix . "taoprefeituras_dados",
            'repasse' => $prefix . "taorepasse_dados"
        );
        return $tables[$table];
    }

    // Instalação
    public function install() {
        /*
    	global $wpdb;
		$tabdados = $wpdb->prefix."taorepasse_dados";
		$tab = "CREATE TABLE IF NOT EXISTS $tabdados (id int NOT NULL Auto_Increment, prefeitura_id int(3) NOT NULL, tipo int(1) NOT NULL, ano int(4) NOT NULL, mes int(2) NOT NULL, indice_ano_anterior decimal(20,9) NOT NULL DEFAULT '0.000000000', indice_ano_atual decimal(20,9) NOT NULL DEFAULT '0.000000000', parcela1 decimal(20,9) DEFAULT NULL, parcela2 decimal(20,9) DEFAULT NULL, parcela3 decimal(20,9) DEFAULT NULL, parcela4 decimal(20,9) DEFAULT NULL, parcela5 decimal(20,9) DEFAULT NULL, ajuste decimal(20,9) NOT NULL DEFAULT '0.000000000', PRIMARY KEY (id)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        $wpdb->query($tab);
		*/
    }

    // Desinstalação
    public function uninstall() {
        /*
		global $wpdb;
		$tabdados = $wpdb->prefix."taorepasse_dados";
		$wpdb->query("DROP TABLE IF EXISTS $tabdados");
		*/
    }

    // Atributos da consulta de repasse
    public function data_attributes(){
        return $attributes = array(
            "prefecture" => $this->prefecture,
            "month" => $this->month,
            "year" => $this->year,
            "type" => $this->type,
            "typeExt" => $this->typeExt
        );
    }

    // Lista de Prefeituras
    public function town_hall(){
        global $wpdb;
        $prefeitura = $this->tables('prefeitura');
        return $wpdb->get_results( "SELECT * FROM $prefeitura ORDER BY nome", OBJECT );
    }

    // Repasse
    public function wherewithal(){
        global $wpdb;

        $prefeitura_lista = $this->tables('prefeitura');
        $repasse = $this->tables('repasse');

        $where = "";

        $this->typeExt = ($this->type==1) ? "ICMS" : "FPM";
        $type = $this->type;

        if($this->month != "") $where = "AND $repasse.mes='$this->month'";

        if($this->year != "" && $this->month !=""){
            $where .= " AND $repasse.ano='$this->year' ";
        } else if ($this->year != "") {
            $where = " AND $repasse.ano='$this->year' ";
        }

        if($this->prefecture != "") $where .= " AND $repasse.prefeitura_ID='$this->prefecture'";

        return $wpdb->get_results(
            "SELECT $repasse.*, $prefeitura_lista.nome
            FROM $repasse, $prefeitura_lista 
            WHERE $repasse.prefeitura_id=$prefeitura_lista.codigo_prefeitura 
            AND $repasse.tipo='$type' $where ORDER BY ano, mes, nome"
        );
    }

    // Salva CSV
    public function submit_csv(){

        global $wpdb;

        $tab = $wpdb->prefix.'taorepasse_dados';

        $ano = $_POST['ano'];
        $mes = $_POST['mes'];
        $tipo = $_POST['tipo'];

        $find = $wpdb->get_results( "SELECT ano, mes, tipo FROM $tab where ano='$ano' AND mes='$mes' AND tipo='$tipo'" );

        if ($find) {
            $del = "DELETE FROM $tab WHERE ano='$ano' AND mes='$mes' AND tipo='$tipo'";
            $wpdb->query($del);
        }

        //$csvfile = plugin_dir_url( __FILE__ ) . "csv/teste.csv";
        $csvfile = $_FILES["txtfile"]["tmp_name"];
        $handle = fopen($csvfile, "r");

        $num_linhas = 1;
        $processo = array();

        while (($dados = fgetcsv($handle, 0, ";")) !== FALSE){
            for($i = 0; $i < $num_linhas; $i++){

                $processo['prefeitura_id'] = addslashes($dados[3]);
                $processo['tipo'] = addslashes($dados[2]);
                $processo['ano'] = addslashes($dados[1]);
                $processo['mes'] = addslashes($dados[0]);

                if($tipo==1) $processo['indice_ano_anterior'] = $this->get_float(addslashes($dados[6]));

                $processo['indice_ano_atual'] = $this->get_float(addslashes($dados[6]));
                $processo['parcela1'] = $this->get_float(addslashes($dados[7]));
                $processo['parcela2'] = $this->get_float(addslashes($dados[8]));
                $processo['parcela3'] = $this->get_float(addslashes($dados[9]));
                $processo['parcela4'] = $this->get_float(addslashes($dados[10]));
                $processo['parcela5'] = $this->get_float(addslashes($dados[11]));

                $wpdb->insert($tab, $processo, '%s');

            }
        }

        fclose ($handle);

        $dominio = get_bloginfo('url');
        echo '<meta http-equiv="refresh" content="2;url='.$dominio.'/wp-admin/admin.php?page=financas">';
        echo '<h1>Cadastrado com Sucesso!!!</h1>';
    }

    // Substituir valores brasileiros para internacional
    public function get_float($str) {
        if(strstr($str, ",")) {
            $str = str_replace(".", "", $str);
            $str = str_replace(",", ".", $str);
        }

        return (preg_match("#([0-9\.]+)#", $str, $match)) ? floatval($match[0]) : floatval($str);
    }

}