<?php

class Model_Register
{
    /**
     * Tabelas
     * @param $table
     * @return mixed
     */
    protected function tables($table)
    {
        global $wpdb;
        $tables = array(
            "mailing" => $wpdb->prefix . "mailing",
        );
        return $tables[$table];
    }

    /**
     * Instalação
     */
    protected function install()
    {
        $admin_role = get_role('administrator');
        $admin_role->add_cap('export_xml');

        add_role('diretor', 'Diretor', array('read' => true, 'read_private_pages' => true));
        add_role('gerente', 'Gerente', array('read' => true, 'read_private_pages' => true));
        add_role('coordenador', 'Coordenador', array('read' => true, 'read_private_pages' => true));
        add_role('inativo', 'Inativo', array('read' => false, 'read_private_pages' => false));

        remove_role('subscriber');

        global $wpdb;
        $mailing = $this->tables('mailing');
        $wpdb->query("CREATE TABLE IF NOT EXISTS $mailing ( 
                          id int NOT NULL Auto_Increment, 
                          nome VARCHAR (50), 
                          email VARCHAR (50), 
                          tipo VARCHAR (50),
                          grupo TINYINT(1),
                          patrocinio TINYINT(1),
                          registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
                          PRIMARY KEY (id) 
                      ) 
                      CHARACTER SET utf8 COLLATE utf8_general_ci;");
    }

    /**
     * Desinstalação
     */
    protected function uninstall()
    {
        $admin_role = get_role('administrator');
        $admin_role->remove_cap('export_xml');

        remove_role('aspirante');
        remove_role('gerente');
        remove_role('coordenador');
        remove_role('inativo');

        add_role('subscriber', 'Assinante', array('read' => true));

        global $wpdb;
        $mailing = $this->tables('mailing');
        $wpdb->query("DROP TABLE $mailing");
    }

    /**
     * Cria Novo Usuário
     */
    public function create_new_user()
    {
        if ($this->filter_input($_POST['aceita']) != 1) {
            wp_redirect(get_home_url() . "/associe-se?msg=no_accept");
            exit;
        }

        $quem_indicou = $this->filter_input($_POST['quem_indicou']);
        $nome = $this->filter_input($_POST['nome']);
        $rg = $this->filter_input($_POST['rg']);
        $cpf = $this->filter_input($_POST['cpf']);
        $nascimento = $this->date2Sql($this->filter_input($_POST['nascimento']));
        $estado_civil = $this->filter_input($_POST['estado_civil']);
        $sexo = $this->filter_input($_POST['sexo']);
        $end_corresp = $this->filter_input($_POST['endereco-correspondencia']);
        $email_personal = $this->filter_input($_POST['email']);
        $telefone = $this->filter_input($_POST['telefone']);
        $celular = $this->filter_input($_POST['celular']);

        $empresa = $this->filter_input($_POST['empresa']);
        $cargo = $this->filter_input($_POST['cargo-corporativo']);
        $endereco_empresa = $this->filter_input($_POST['endereco-empresa']);
        $telefone_comercial = $this->filter_input($_POST['telefone-comercial']);
        $ramal = $this->filter_input($_POST['ramal']);
        $email_comercial = $this->filter_input($_POST['email-comercial']);
        $ramo = $this->filter_input($_POST['ramo']);
        $quantidade_matriz = $this->filter_input($_POST['quantidade-matriz']);
        $setor = $this->filter_input($_POST['setor']);
        $faturamento = $this->filter_input($_POST['faturamento']);
        $qtd_funcionarios = $this->filter_input($_POST['qtd-funcionarios']);

        $password = wp_generate_password( 10, true );

        $name_slice = explode(" ", $nome);
        $first_name = $name_slice[0];
        $last_name = $name_slice[1];

        if (!username_exists($email_personal) && !email_exists($email_personal)) :

            $user_id = wp_create_user($email_personal, $password, $email_personal);
            $user = new WP_User($user_id);
            $user->set_role('inativo');

            update_user_meta($user_id, 'first_name', $first_name);
            update_user_meta($user_id, 'last_name', $last_name);
            update_user_meta($user_id, 'quem_indicou', $quem_indicou);
            update_user_meta($user_id, 'rg', $rg);
            update_user_meta($user_id, 'cpf', $cpf);
            update_user_meta($user_id, 'nascimento', $nascimento);
            update_user_meta($user_id, 'estado_civil', $estado_civil);
            update_user_meta($user_id, 'sexo', $sexo);
            update_user_meta($user_id, 'correspondencia', $end_corresp);
            update_user_meta($user_id, 'telefone', $telefone);
            update_user_meta($user_id, 'celular', $celular);

            update_user_meta($user_id, 'empresa', $empresa);
            update_user_meta($user_id, 'cargo', $cargo);
            update_user_meta($user_id, 'endereco_empresa', $endereco_empresa);
            update_user_meta($user_id, 'telefone_comercial', $telefone_comercial);
            update_user_meta($user_id, 'ramal', $ramal);
            update_user_meta($user_id, 'email_corporativo', $email_comercial);
            update_user_meta($user_id, 'ramo', $ramo);
            update_user_meta($user_id, 'quantidade_matriz', $quantidade_matriz);
            update_user_meta($user_id, 'setor', $setor);
            update_user_meta($user_id, 'faturamento', $faturamento);
            update_user_meta($user_id, 'qtd_funcionarios', $qtd_funcionarios);

            if (!empty($_POST['email-pessoal-check'])) :

                global $wpdb;
                $mailing = $this->tables('mailing');
                $dados = array();
                $dados['nome'] = $nome;
                $dados['email'] = $email_personal;
                $dados['tipo'] = "pessoal";
                $dados['grupo'] = ( in_array("grupo_pessoal", $_POST['email-pessoal-check'] )) ? 1 : 0;
                $dados['patrocinio'] = ( in_array("patrocinadores_pessoal", $_POST['email-pessoal-check'] )) ? 1 : 0;
                $wpdb->insert($mailing, $dados, '%s');

            endif;

            if (!empty($_POST['email-corporativo-check'])) :

                global $wpdb;
                $mailing = $this->tables('mailing');
                $dados = array();
                $dados['nome'] = $nome;
                $dados['email'] = $email_personal;
                $dados['tipo'] = "corporativo";
                $dados['grupo'] = ( in_array("grupo_corporativo", $_POST['email-corporativo-check'] )) ? 1 : 0;
                $dados['patrocinio'] = ( in_array("patrocinadores_corporativo", $_POST['email-corporativo-check'] )) ? 1 : 0;
                $wpdb->insert($mailing, $dados, '%s');

            endif;

            wp_redirect(get_home_url() . "/associe-se?msg=success");

        else :

            wp_redirect(get_home_url() . "/associe-se?msg=exists");

        endif;

        exit;
    }

    /**
     * Filtra os dados de entrada
     * @param $input
     * @return string|void
     */
    public function filter_input($input)
    {
        return esc_attr(htmlspecialchars(strip_tags($input)));
    }

    /**
     * Conversor data para SQL
     * @param $date
     * @param string $separator
     * @return string
     */
    public function date2Sql($date, $separator = "/")
    {
        $dataArr = explode($separator, $date);
        $dataArr = array_reverse($dataArr);
        return implode('', $dataArr);
    }

    /**
     * Mensagens de Alerta
     */
    public function msg_alert()
    {
        if (isset($_GET['msg'])) {
            switch ($_GET['msg']) {
                case "success":
                    echo "<script>alert('Cadastrado com Sucesso!');</script>";
                    break;
                case "exists":
                    echo "<script>alert('Associado já Existente!');</script>";
                    break;
                case "no_accept":
                    echo "<script>alert('Aceite os termos!');</script>";
                    break;
                default:
                    echo "<script>alert('Erro ao Criar Usuário');</script>";
                    break;
            }
        }
    }

    /**
     * Exportar XML
     */
    public function ExportMysqlToCSV()
    {
        if (!current_user_can('edit_posts'))
            wp_die('Você não tem permissão para acessar essa área');

        global $wpdb;
        $usermeta = $this->tables('usermeta');
        $find = $wpdb->prefix . "capabilities";
        $users = $wpdb->get_results("SELECT * FROM $usermeta WHERE meta_key = '$find'", OBJECT);

        exit;
    }
}