<?php

class Model_XML_Associates
{

    // Tabelas
    protected function tables($table){
        global $wpdb;
        $tables = array(
            "users" => $wpdb->prefix . "users",
            "usermeta" => $wpdb->prefix . "usermeta",
        );
        return $tables[$table];
    }

    // Instalação
    protected function install(){
        $admin_role = get_role( 'administrator' );
        $admin_role->add_cap( 'export_xml' );

        add_role('efetivo', 'Efetivo', array( 'read' => true, 'read_private_pages' => true ));
        add_role('remido', 'Remido', array( 'read' => true, 'read_private_pages' => true ));
        add_role('aspirante', 'Aspirante', array( 'read' => true, 'read_private_pages' => true ));
        add_role('inativo', 'Inativo', array( 'read' => false, 'read_private_pages' => false ));
        remove_role( 'subscriber' );
    }

    // Desinstalação
    protected function uninstall(){
        $admin_role = get_role( 'administrator' );
        $admin_role->add_cap( 'export_xml' );

        remove_role( 'efetivos' );
        remove_role( 'remido' );
        remove_role( 'aspirante' );
        remove_role( 'inativo' );

        add_role('subscriber', 'Assinante', array( 'read' => true ));
    }

    // Campos dos médicos
    public function get_fields_acf(){

        if(function_exists("register_field_group")) {
            register_field_group(array (
                'id' => 'acf_informacoes-cadastrais',
                'title' => 'Informações Cadastrais',
                'fields' => array (
                    array (
                        'key' => 'field_5661c681e53de',
                        'label' => 'Sexo',
                        'name' => 'sexo',
                        'type' => 'text',
                        'required' => 1,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => 1,
                    ),
                    array (
                        'key' => 'field_5661c6b0e53df',
                        'label' => 'Nascimento',
                        'name' => 'nascimento',
                        'type' => 'date_picker',
                        'instructions' => 'Insira a data de nascimento',
                        'required' => 1,
                        'date_format' => 'yymmdd',
                        'display_format' => 'dd/mm/yy',
                        'first_day' => 0,
                    ),
                    array (
                        'key' => 'field_5661c76aedfc0',
                        'label' => 'CRO',
                        'name' => 'cro',
                        'type' => 'number',
                        'instructions' => 'Digite a CRO',
                        'required' => 1,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                    array (
                        'key' => 'field_5661c7d6edfc1',
                        'label' => 'CPF',
                        'name' => 'cpf',
                        'type' => 'text',
                        'required' => 1,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => 14,
                    ),
                    array (
                        'key' => 'field_5661c803edfc2',
                        'label' => 'RG',
                        'name' => 'rg',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_telefone_fixo',
                        'label' => 'Telefone Fixo',
                        'name' => 'telefone_fixo',
                        'type' => 'text',
                        'instructions' => 'Insira o telefone fixo',
                        'default_value' => '',
                        'placeholder' => '(99) 3299-9999',
                        'prepend' => 'Tel.:',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => 15,
                    ),
                    array (
                        'key' => 'field_53b2ee0438491',
                        'label' => 'Telefone Celular',
                        'name' => 'telefone',
                        'type' => 'text',
                        'instructions' => 'Insira o telefone celular',
                        'default_value' => '',
                        'placeholder' => '(99) 99999-9999',
                        'prepend' => 'Cel.:',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => 15,
                    ),
                    array (
                        'key' => 'field_5390ccd59b027',
                        'label' => 'Estado',
                        'name' => 'estado',
                        'type' => 'select',
                        'instructions' => 'Insira seu Estado (UF)',
                        'required' => 1,
                        'choices' => array (
                            'CE' => 'CE',
                            'BH' => 'BH',
                            'MA' => 'MA',
                            'RN' => 'RN',
                        ),
                        'default_value' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_5390ccba9b026',
                        'label' => 'Cidade',
                        'name' => 'cidade',
                        'type' => 'text',
                        'required' => 1,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5390ccae9b025',
                        'label' => 'Bairro',
                        'name' => 'bairro',
                        'type' => 'text',
                        'required' => 1,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5390cc9c9b024',
                        'label' => 'Endereço',
                        'name' => 'endereco',
                        'type' => 'text',
                        'required' => 1,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5661c9bdb8e57',
                        'label' => 'Número da Residência',
                        'name' => 'numero_residencia',
                        'type' => 'number',
                        'required' => 1,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                    array (
                        'key' => 'field_5661c9e2b8e58',
                        'label' => 'Complemento',
                        'name' => 'complemento',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5390cd109b028',
                        'label' => 'CEP',
                        'name' => 'cep',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => 10,
                    ),
                    array (
                        'key' => 'field_5661c9f2b8e59',
                        'label' => 'Data de Associação',
                        'name' => 'data_associacao',
                        'type' => 'date_picker',
                        'required' => 1,
                        'date_format' => 'yymmdd',
                        'display_format' => 'dd/mm/yy',
                        'first_day' => 0,
                    ),
                    array (
                        'key' => 'field_5400bf766747f',
                        'label' => 'Foto',
                        'name' => 'foto',
                        'type' => 'image',
                        'save_format' => 'url',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'ef_user',
                            'operator' => '==',
                            'value' => 'all',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                        0 => 'permalink',
                        1 => 'the_content',
                        2 => 'excerpt',
                        3 => 'custom_fields',
                        4 => 'discussion',
                        5 => 'comments',
                        6 => 'revisions',
                        7 => 'slug',
                        8 => 'author',
                        9 => 'format',
                        10 => 'featured_image',
                        11 => 'categories',
                        12 => 'tags',
                        13 => 'send-trackbacks',
                    ),
                ),
                'menu_order' => 0,
            ));
        }

    }

    // Exportar XML
    public function ExportMysqlToXML(){

        if(!current_user_can('edit_posts'))
            wp_die('Você não tem permissão para acessar essa área');

        global $wpdb;
        $usermeta = $this->tables('usermeta');
        $find = $wpdb->prefix . "capabilities";
        $users = $wpdb->get_results("SELECT * FROM $usermeta WHERE meta_key = '$find'", OBJECT);

        // tipo documento
        $dom = new DOMDocument('1.0', "UTF-8");
        $dom->formatOutput = true;

        // cria elemento main
        $root = $dom->createElement("root");

        // cria atributos e adiciona valores
        $attxml = $dom->createAttribute("xmlns:xsi");
        $attxml->value = 'http://www.w3.org/2001/XMLSchema-instance';

        $attdoc = $dom->createAttribute("xsi:noNamespaceSchemaLocation");
        $attdoc->value = 'associados.xsd';

        // adiciona os atributos ao elemento root
        $root->appendChild($attxml);
        $root->appendChild($attdoc);

        // abor regional
        $regional = $dom->createElement("aborRegional");
        $attrRegional = $dom->createAttribute("id");
        $attrRegional->value = 23;
        $regional->appendChild($attrRegional);

        // lista de associados
        $associados = $dom->createElement("associados");
        $attr_associados = $dom->createAttribute("total");

        $count_associate = 0;

        foreach($users as $user) :

            $status = unserialize($user->meta_value);

            switch ($status){
                case $status['efetivo']:
                    $status = 1;
                    break;
                case $status['remido']:
                    $status = 2;
                    break;
                case $status['aspirante']:
                    $status = 3;
                    break;
                case $status['inativo']:
                    $status = 9;
                    break;
                default:
                    $status = false;
                    break;
            }

            if($status) :

                $count_associate++;
                $id = $user->user_id;
                $name = get_the_author_meta( 'first_name', $id ) . ' ' . get_the_author_meta( 'last_name', $id );
                $cpf = get_the_author_meta( 'cpf', $id );
                $sexo = get_the_author_meta( 'sexo', $id );
                $nascimento = $this->sql2Date(get_the_author_meta( 'nascimento', $id ));
                $cro = get_the_author_meta( 'cro', $id );
                $rg = get_the_author_meta( 'rg', $id );

                // Filtro de Telefone
                $telefone = (!empty(get_the_author_meta( 'telefone_fixo', $id ))) ? $this->filter_blank($this->filter(get_the_author_meta( 'telefone_fixo', $id ))) : "(85) 3299.9999";

                $email = get_the_author_meta( 'email', $id );
                $bairro = get_the_author_meta( 'bairro', $id );
                $endereco = get_the_author_meta( 'endereco', $id );
                $numero_endereco = get_the_author_meta( 'numero_residencia', $id );
                $complemento = get_the_author_meta( 'complemento', $id );

                // Caso vazio insere data fictícia
                $data_associacao = (!empty(get_the_author_meta( 'data_associacao', $id ))) ? $this->sql2Date(get_the_author_meta( 'data_associacao', $id )) : "01/01/2015";

                // abor regional
                $associado = $dom->createElement("associado");
                $attr = $dom->createAttribute("id");
                $attr->value = $cpf;
                $associado->appendChild($attr);

                /**
                 * Criando os elementos do associado
                 */
                $nome_associado = $dom->createElement("nome", $name);
                $sexo_associado = $dom->createElement("sexo", $sexo);
                $nascimento_associado = $dom->createElement("nascimento", $nascimento);
                $cro_associado = $dom->createElement("cro", $cro);
                $croUf_associado = $dom->createElement("croUf", 23);
                $cpf_associado = $dom->createElement("cpf", $cpf);
                $rg_associado = $dom->createElement("rg", $rg);
                $telefone_associado = $dom->createElement("telefone", $telefone);
                $fax_associado = $dom->createElement("fax", "");
                $celular_associado = $dom->createElement("celular", "");
                $site_associado = $dom->createElement("site", "");
                $email_associado = $dom->createElement("email", $email);
                $pais_associado = $dom->createElement("pais", 76);
                $estado_associado = $dom->createElement("estado", 23);
                $cidade_associado = $dom->createElement("cidade", 2304400);
                $bairro_associado = $dom->createElement("bairro", $bairro);
                $endereco_associado = $dom->createElement("endereco", $endereco);
                $cep_associado = $dom->createElement("cep", "60.000-000");
                $numero_associado = $dom->createElement("numero", $numero_endereco);
                $complemento_associado = $dom->createElement("complemento", $complemento);
                $status_associado = $dom->createElement("status", $status);
                $dataAssociado = $dom->createElement("dataAssociado", $data_associacao);

                $associado->appendChild($nome_associado);
                $associado->appendChild($sexo_associado);
                $associado->appendChild($nascimento_associado);
                $associado->appendChild($cro_associado);
                $associado->appendChild($croUf_associado);
                $associado->appendChild($cpf_associado);
                $associado->appendChild($rg_associado);
                $associado->appendChild($telefone_associado);
                $associado->appendChild($fax_associado);
                $associado->appendChild($celular_associado);
                $associado->appendChild($site_associado);
                $associado->appendChild($email_associado);
                $associado->appendChild($pais_associado);
                $associado->appendChild($estado_associado);
                $associado->appendChild($cidade_associado);
                $associado->appendChild($bairro_associado);
                $associado->appendChild($endereco_associado);
                $associado->appendChild($cep_associado);
                $associado->appendChild($numero_associado);
                $associado->appendChild($complemento_associado);
                $associado->appendChild($status_associado);
                $associado->appendChild($dataAssociado);

                /**
                 * Criando os elementos do local de trabalho
                 */
                $locaisTrabalho = $dom->createElement("locaisTrabalho");
                $attr = $dom->createAttribute("total");
                $attr->value = 1;
                $locaisTrabalho->appendChild($attr);

                $localTrabalho = $dom->createElement("localTrabalho");
                $nome_local = $dom->createElement("nome", $name);
                $pais_local = $dom->createElement("pais", 76);
                $estado_local = $dom->createElement("estado", 23);
                $cidade_local = $dom->createElement("cidade", 2304400);
                $bairro_local = $dom->createElement("bairro", $bairro);
                $endereco_local = $dom->createElement("endereco", $endereco);
                $cep_local = $dom->createElement("cep", "60.000-000");
                $numero_local = $dom->createElement("numero", $numero_endereco);
                $complemento_local = $dom->createElement("complemento", $complemento);
                $horario_local = $dom->createElement('horario', 'Sex a Seg das 9:00 às 17:00');
                $mapa_local = $dom->createElement('mapa');
                $telefone_local = $dom->createElement("telefone", $telefone);
                $telefone2_local = $dom->createElement('telefone2');
                $site_local = $dom->createElement("site", "");
                $email_local = $dom->createElement("email", $email);

                $localTrabalho->appendChild($nome_local);
                $localTrabalho->appendChild($pais_local);
                $localTrabalho->appendChild($estado_local);
                $localTrabalho->appendChild($cidade_local);
                $localTrabalho->appendChild($bairro_local);
                $localTrabalho->appendChild($endereco_local);
                $localTrabalho->appendChild($cep_local);
                $localTrabalho->appendChild($numero_local);
                $localTrabalho->appendChild($complemento_local);
                $localTrabalho->appendChild($horario_local);
                $localTrabalho->appendChild($mapa_local);
                $localTrabalho->appendChild($telefone_local);
                $localTrabalho->appendChild($telefone2_local);
                $localTrabalho->appendChild($site_local);
                $localTrabalho->appendChild($email_local);

                /**
                 * Fazendo associação dos elementos
                 */
                $locaisTrabalho->appendChild($localTrabalho);
                $associado->appendChild($locaisTrabalho);
                $associados->appendChild($associado);

            endif;

        endforeach;

        // adiciona número de associados
        $attr_associados->value = $count_associate;
        $associados->appendChild($attr_associados);

        // adiciona "associados" na "regional"
        $regional->appendChild($associados);

        // adiciona "regional" na "root"
        $root->appendChild($regional);

        // adiciona "root" ao documento
        $dom->appendChild($root);

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-type: application/xml; charset=ISO-8859-1");
        header("Content-Disposition: attachment; filename='registros.xml'");
        echo $dom->saveXML();

        exit;

    }

    // SQL para Data
    protected function sql2Date($date, $separator = "/") {
        $array_date[] = substr($date, 0, 4);
        $array_date[] = substr($date, 4, 2);
        $array_date[] = substr($date, 6, 2);
        $array_date = array_reverse($array_date);
        return implode($separator, $array_date);
    }

    // Data para SQL
    protected function date2Sql($date, $separator = "/") {
        $dataArr = explode($separator, $date);
        $dataArr = array_reverse($dataArr);
        return implode('', $dataArr);
    }

    // Filtro de ' - ' para ' . '
    protected function filter($val){
        $val = str_replace("-", ".", $val);
        return $val;
    }

    // Filtro remove espaço em branco
    protected function filter_blank($val){
        list($var1, $var2) = explode('.', $val);
        $var2 = str_replace(" ", "", $var2);
        $val = array($var1, $var2);
        return implode('.', $val);
    }

}