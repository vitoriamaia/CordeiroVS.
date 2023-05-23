<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class MLP_ShortCodes
{

    public static function init()
    {
        // Formulário de Pesquisa
        add_shortcode('form_find', array(__CLASS__, 'form_find_customer'));
    }

    public static function form_find_customer()
    {

        global $post; ?>

        <form action="<?php echo get_permalink($post->ID) ?>" method="post" class="find">
            <label for="customer" class="label-form">Encontre uma lista de presentes:</label>
            <input id="customer" name="customer" type="text" placeholder="digite o nome de um dos presenteados"
                   value="<?php echo (isset($_POST['customer'])) ? esc_attr($_POST['customer']) : ''; ?>"/>
            <input type="submit" value="Procurar" class="bt"/>
        </form>

        <?php

        if (isset($_POST['customer'])) :

            $results = MLP()->queries->find_client(esc_attr($_POST['customer']));

            if (!empty($results)) : ?>

                <ul class="result">

                    <?php foreach ($results as $result) :
                        $attr_image = get_field('photo_customer', $result->ID) ?>

                        <li class="col-lg-3 col-md-3 col-sm-3 col-xs-4 item">
                            <a href="<?php echo get_permalink($result->ID) ?>" class="link container-product">
                                <img src="<?php echo $attr_image["sizes"]["thumbnail"]; ?>"
                                     title="<?php echo $attr_image['title']; ?>" alt="<?php echo $attr_image['alt']; ?>"
                                     class="img-responsive">
                            </a>
                            <h2 class="title-customer"><?php echo get_the_title($result->ID) ?></h2>
                        </li>

                    <?php endforeach; ?>

                </ul>

                <?php

            else :

                echo "<div class='no-result-search'>Nenhum resultado encontrado</div>";

            endif;

        endif;

    }

}

MLP_ShortCodes::init();