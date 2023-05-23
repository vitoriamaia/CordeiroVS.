<?php

include_once(dirname(__FILE__) . '/Model_Connect.php');

class Model_Collect extends Model_Collect_Connect
{

    private $user;
    private $pass;

    // Cria Sessão
    protected function session_login($email, $password)
    {

        if (!isset($_SESSION['login_tracking'])) {
            $_SESSION['login_tracking']['login'] = $email;
            $_SESSION['login_tracking']['password'] = $password;
        }

    }

    // Pega Login
    protected function get_login()
    {

        return (isset($_SESSION['login_tracking'])) ? $_SESSION['login_tracking'] : "";

    }

    // Seta Login
    protected function set_login()
    {

        $this->connect_open();
        $login = $this->get_login();
        $this->user = $login['login'];
        $this->pass = $login['password'];

    }

    // Reseta Login
    protected function flush_login()
    {

        if (isset($_SESSION['login_tracking'])) unset($_SESSION['login_tracking']);

    }

    // Verifica Conexão
    protected function verify_connect()
    {

        $error = false;

        if (!$this->connect_link()) {

            $this->flush_login();
            $error = "Erro ao conectar o sistema, tente novamente mais tarde.";

        }

        return $error;

    }

    // Verifica se Usuário Existe
    protected function verify_user()
    {

        $this->set_login();
        $test_error = $this->verify_connect();

        if (!$test_error) :

            $sql = "SELECT 
                    C.CODIGO AS EMPRESA,
                    C.FILIAL,
                    E.ZZZZZ AS CODIGO,
                    C.RAZAO,
                    E.INTERNET_LOGIN AS LOGIN,
                    E.INTERNET_SENHA AS SENHA,
                    E.FATURAMENTO AS VER_FAT,
                    C.CNPJ,
                    C.SIGLA,
                    C.CIDADE1 AS CIDADE,
                    C.UF1 AS UF FROM CLIENTES C 
                    left join CLIENTES_EMAILS E ON (C.codigo = E.codigo_cliente) 
                    WHERE E.EMAIL = '$this->user' AND E.INTERNET_SENHA = '$this->pass' AND E.INTERNET = '0' ";

            $content = mysqli_query($this->connect_link(), $sql);

            if (!mysqli_num_rows($content)) {

                $test_error = "Usuário ou senha inválida.";
                $this->flush_login();

            }

        endif;

        return $test_error;

    }

    // Exibe Rastreamento
    protected function get_tracking()
    {

        $this->set_login();
        $sql = "SELECT 
                C.CODIGO AS EMPRESA,
                C.FILIAL,
                E.ZZZZZ AS CODIGO,
                C.RAZAO,
                E.INTERNET_LOGIN AS LOGIN,
                E.INTERNET_SENHA AS SENHA,
                E.FATURAMENTO AS VER_FAT,
                C.CNPJ,
                C.SIGLA,
                C.CIDADE1 AS CIDADE,
                C.UF1 AS UF FROM CLIENTES C 
                left join CLIENTES_EMAILS E ON (C.codigo = E.codigo_cliente) 
                WHERE E.EMAIL = '$this->user' AND E.INTERNET_SENHA = '$this->pass' AND E.INTERNET = '0' ";

        return mysqli_query($this->connect_link(), $sql);

    }

    // Insere Coleta
    protected function insert_collect($dados = array())
    {

        if (!is_array($dados) || empty($dados)) return false;

        // Checa se existe conexão e caso não exista é aberta nova conexão
        if ($this->connect_link() === null) $this->connect_open();

        try {

            $campos = "CNPJ,INSC,RAZAO,FANTASIA,ENDERECO1,NUMERO1,BAIRRO1,CIDADE1,UF1,FONE1,CEP1,FILIAL";
            $dados = ":CNPJ,:INSC,:RAZAO,:FANTASIA,:ENDERECO1,:NUMERO1,:BAIRRO1,:CIDADE1,:UF1,:FONE1,:CEP1,:FILIA";

            // Campos para inserção do solicitante da coleta
            $sql = $this->connect_link()->prepare("insert into clientes($campos) values($dados)");

            $sql->execute(array(
                ':CNPJ' => $_POST["cpf_cnpj_solicitante"],
                ':INSC' => $_POST["inscri_est_mun_solicitante"],
                ':RAZAO' => $_POST["nome_solicitante"],
                ':FANTASIA' => $_POST["nome_solicitante"],
                ':ENDERECO1' => $_POST["endereco_solicitante"],
                ':NUMERO1' => $_POST["numero_solicitante"],
                ':BAIRRO1' => $_POST["bairro_solicitante"],
                ':CIDADE1' => $_POST["cidade_solicitante"],
                ':UF1' => $_POST["uf_solicitante"],
                ':FONE1' => $_POST["telefone_solicitante"],
                ':CEP1' => $_POST["cep_solicitante"],
                ':FILIA' => $_POST["nome_solicitante"],
            ));

            // Campos para inserção do destinatário da coleta
            $sql = $this->connect_link()->prepare("insert into clientes($campos) values($dados)");

            $sql->execute(array(
                ':CNPJ' => $_POST["cpf_cnpj_destinatario"],
                ':INSC' => $_POST["inscri_est_mun_destinatario"],
                ':RAZAO' => $_POST["nome_destinatario"],
                ':FANTASIA' => $_POST["nome_destinatario"],
                ':ENDERECO1' => $_POST["endereco_destinatario"],
                ':NUMERO1' => $_POST["numero_destinatario"],
                ':BAIRRO1' => $_POST["bairro_destinatario"],
                ':CIDADE1' => $_POST["cidade_destinatario"],
                ':UF1' => $_POST["uf_destinatario"],
                ':FONE1' => $_POST["telefone_destinatario"],
                ':CEP1' => $_POST["cep_destinatario"],
                ':FILIA' => $_POST["nome_destinatario"],
            ));

            // Gravando a coleta
            $campos = "cnpj_cpf_o,insc_o,razao_o,endereco_o,numero_o,bairro_o,cidade_o,uf_o,fone_o,cep_o,"
                . "cnpj_cpf_d,insc_d,razao_d,endereco_d,numero_d,bairro_d,cidade_d,uf_d,fone_d,cep_d,"
                . "solicitada_por,solicitada_dt,solicitada_hr,"
                . "cobrarde,"
                . "obs,"
                . "situacao,"
                . "data,hora,usuario,"
                . "conteudo1,VOLUMES1,pesor1,pesoc1,nota1,notav1,"
                . "conteudo2,VOLUMES2,pesor2,pesoc2,nota2,notav2,"
                . "conteudo3,VOLUMES3,pesor3,pesoc3,nota3,notav3,"
                . "conteudo4,VOLUMES4,pesor4,pesoc4,nota4,notav4,"
                . "conteudo5,VOLUMES5,pesor5,pesoc5,nota5,notav5,"
                . "conteudo6,VOLUMES6,pesor6,pesoc6,nota6,notav6,"
                . "conteudo7,VOLUMES7,pesor7,pesoc7,nota7,notav7,"
                . "conteudo8,VOLUMES8,pesor8,pesoc8,nota8,notav8,"
                . "conteudo9,VOLUMES9,pesor9,pesoc9,nota9,notav9,"
                . "conteudo10,VOLUMES10,pesor10,pesoc10,nota10,notav10,"
                . "PROGRAMACAO,PROGRAMACAO_HORA";

            $dados = ":cnpj_cpf_o,:insc_o,:razao_o,:endereco_o,:numero_o,:bairro_o,:cidade_o,:uf_o,:fone_o,:cep_o,"
                . ":cnpj_cpf_d,:insc_d,:razao_d,:endereco_d,:numero_d,:bairro_d,:cidade_d,:uf_d,:fone_d,:cep_d,"
                . ":solicitada_por,:solicitada_dt,:solicitada_hr,"
                . ":cobrarde,"
                . ":obs,"
                . ":situacao,"
                . ":data,:hora,:usuario,"
                . ":conteudo1,:VOLUMES1,:pesor1,:pesoc1,:nota1,:notav1,"
                . ":conteudo2,:VOLUMES2,:pesor2,:pesoc2,:nota2,:notav2,"
                . ":conteudo3,:VOLUMES3,:pesor3,:pesoc3,:nota3,:notav3,"
                . ":conteudo4,:VOLUMES4,:pesor4,:pesoc4,:nota4,:notav4,"
                . ":conteudo5,:VOLUMES5,:pesor5,:pesoc5,:nota5,:notav5,"
                . ":conteudo6,:VOLUMES6,:pesor6,:pesoc6,:nota6,:notav6,"
                . ":conteudo7,:VOLUMES7,:pesor7,:pesoc7,:nota7,:notav7,"
                . ":conteudo8,:VOLUMES8,:pesor8,:pesoc8,:nota8,:notav8,"
                . ":conteudo9,:VOLUMES9,:pesor9,:pesoc9,:nota9,:notav9,"
                . ":conteudo10,:VOLUMES10,:pesor10,:pesoc10,:nota10,:notav10,"
                . ":PROGRAMACAO,:PROGRAMACAO_HORA";

            $sql = $this->connect_link()->prepare("insert into clientes($campos) values($dados)");

            $content_collect = array();

            for ($i = 1; $i <= 2; $i++) {

                if ($i == 1) {
                    $indice = "o";
                    $tipo = "solicitante";
                } else {
                    $indice = "d";
                    $tipo = "destinatario";
                }

                $content_collect[":cnpj_cpf_$indice"] = $_POST["cpf_cnpj_$tipo"];
                $content_collect[":insc_$indice"] = $_POST["inscri_est_mun_$tipo"];
                $content_collect[":razao_$indice"] = $_POST["nome_$tipo"];
                $content_collect[":endereco_$indice"] = $_POST["endereco_$tipo"];
                $content_collect[":numero_$indice"] = $_POST["numero_$tipo"];
                $content_collect[":bairro_$indice"] = $_POST["bairro_$tipo"];
                $content_collect[":cidade_$indice"] = $_POST["cidade_$tipo"];
                $content_collect[":uf_$indice"] = $_POST["uf_$tipo"];
                $content_collect[":fone_$indice"] = $_POST["telefone_$tipo"];
                $content_collect[":cep_$indice"] = $_POST["cep_$tipo"];

            }

            $content_collect[":solicitada_por"] = "Teste";
            $content_collect[":solicitada_dt"] = "2016-05-11";
            $content_collect[":solicitada_hr"] = "03:50";
            $content_collect[":cobrarde"] = 2;
            $content_collect[":obs"] = $_POST["observacoes"];
            $content_collect[":situacao"] = "P";
            $content_collect[":data"] = "current_date";
            $content_collect[":hora"] = "current_time";
            $content_collect[":usuario"] = "INTERNET";

            for ($i = 1; $i <= 10; $i++) {

                $content_collect[":conteudo$i"] = "XXXXX";
                $content_collect[":VOLUMES$i"] = 99;
                $content_collect[":pesor$i"] = 10.1;
                $content_collect[":pesoc$i"] = 10;
                $content_collect[":nota$i"] = "KWY";
                $content_collect[":notav$i"] = 100.39;

            }

            $content_collect[":PROGRAMACAO"] = 'Antes das';
            $content_collect[":PROGRAMACAO_HORA"] = '1000';

            $sql->execute($content_collect);

            //----------------------------------------------------------------------------------------------------------------------------

            $status = "Sua coleta foi inserida com sucesso";

        } catch (PDOException $e) {

            $status = "Erro ao processar sua solicitação, tente novamente mais tarde";

        }


        $this->connect_close();

        return $status;

    }

    // Valida Campo Vazio
    protected function validate_empty($password)
    {

        return (empty($password)) ? 'Preencha os campos obrigatórios.' : false;

    }

    // Valida Email
    protected function validate_email($email)
    {

        return (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? 'Email não é válido.' : false;

    }

}