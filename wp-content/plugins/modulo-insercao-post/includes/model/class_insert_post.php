<?php

if (!defined('ABSPATH')) exit;

// Exit if accessed directly.

class MIPE_Insert_Post
{

    public static function init()
    {
        // Inserir Post
        add_action('wp', array(__CLASS__, 'insert_post'));
        add_action('mipe-notice', array(__CLASS__, 'notice'));
    }

    public static function insert_post()
    {

        global $notice;

        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'insert_post_external') {

            $notice = array();

            // Informações Estabelecimento
            $establishment = esc_attr($_POST['establishment']);
            $establishment_address = esc_attr($_POST['establishment_address']);
            $establishment_address_number = esc_attr($_POST['establishment_address_number']);
            $establishment_local = (int)esc_attr($_POST['establishment_local']);
            $establishment_cat = (int)esc_attr($_POST['establishment_cat']);
            $establishment_content = esc_attr($_POST['establishment_content']);

            // Informações Logo
            if (!empty($_FILES['image_logo']['name'])) {

                $image = $_FILES['image_logo']['name'];
                $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

                if (!empty($_FILES['image_logo']['error'])) :
                    $notice[] = array('alert-danger', 'Error!', ' Erro ao enviar sua logo, por favor tente novamente.');

                elseif ($_FILES['image_logo']['size'] >= 2097152) :
                    $notice[] = array('alert-danger', 'Error!', ' Erro ao enviar sua logo, o tamanho não pode passar de 2M.');

                elseif (strpos('jpg;jpeg;png', $extension) === false) :
                    $notice[] = array('alert-danger', 'Error!', ' Erro ao enviar sua logo, o formato da imagem deve ser JPG, JPEG ou PNG');

                else:

                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/media.php');

                endif;

            }

            // Mensagens de erro
            if (empty($establishment)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione o nome do estabelecimento.');
            if (empty($establishment_address)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione o endereço do estabelecimento.');
            if (empty($establishment_address_number)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione o número do endereço do estabelecimento.');
            if (empty($establishment_local)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione o bairro do estabelecimento.');
            if (empty($establishment_cat)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione a categoria do estabelecimento.');

            if (empty($notice)) {

                $args = array(
                    'post_author' => 1,
                    'post_title' => $establishment,
                    'post_content' => $establishment_content,
                    'post_type' => 'anuncios',
                    'post_status' => 'draft'
                );

                $establishment_id = wp_insert_post($args);

                if (!$establishment_id) :

                    $notice[] = array('alert-warning', 'Alerta!', ' Erro ao gravar seus dados. Tente novamente.');

                else :

                    // Taxonomias (Categorias)
                    wp_set_object_terms($establishment_id, array(15, 13, $establishment_local), 'local');
                    wp_set_object_terms($establishment_id, array($establishment_cat), 'categoria', true);
                    wp_set_object_terms($establishment_id, 'bronze', 'plano', true);

                    // Campos Personalizados
                    $predicted = array(
                        'endereco' => $establishment_address,
                        'numero' => $establishment_address_number,
                    );

                    foreach ($predicted as $key => $value) :
                        update_post_meta($establishment_id, $key, $value);
                    endforeach;

                    if(isset($image)){
                        // Pega a imagem e associa a banda e depois inseri
                        $attachment_id = media_handle_upload('image_logo', $establishment_id);
                        update_post_meta($establishment_id, '_thumbnail_id', $attachment_id);

                        if (!$attachment_id) $notice[] = array('alert-warning', 'Alerta!', ' Erro na geração da logo.');
                    }

                    $notice[] = array('alert-success', 'Parabéns!', ' Seu estabelecimento foi cadastrado com sucesso.');

                endif;

            }

        }
    }

    public static function notice()
    {

        global $notice;

        if (is_array($notice) && !empty($notice)) :
            foreach ($notice as $item) : ?>

                <div class="alert <?php echo $item[0] ?>" role="alert">
                    <i class="fa fa-check" aria-hidden="true"></i>
                    <strong><?php echo $item[1] ?></strong><?php echo $item[2] ?>
                </div>

                <?php
            endforeach;
        endif;

    }

}

MIPE_Insert_Post::init();