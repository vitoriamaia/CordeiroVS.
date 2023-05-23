<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=10" />

    <title>
        <?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?>
    </title>

    <link href='http://fonts.googleapis.com/css?family=Dosis:400,600' rel='stylesheet' type='text/css'>

    <?php
        wp_head();

        global $wpdb;
        $slug = basename($_GET['permalink']);

        $id_promo = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_name = '$slug'");
        $id_promo = $id_promo->ID;
    ?>

</head>

<body <?php body_class(); ?>>

<div class="inner top-inner-print">
    <div class="info-print-1 fl">
        <img width="350" src="<?php echo Wp_Images ?>/logo-print.png" alt="<?php echo get_bloginfo('name'); ?>"/>
        <div class="info-content-1">
            <div class="title">
                <?php
                    $estabelecimento = get_field('estabelecimento', $id_promo);
                    echo $estabelecimento->post_title;
                ?>
            </div>
            <div class="promo">
                <?php echo get_the_title($id_promo); ?>
            </div>
            <div class="price">
                <div class="from-print"><?php the_field('valor_normal', $id_promo); ?></div>
                <div class="for-print"><?php the_field('preco_pedida', $id_promo); ?></div>
            </div>
        </div>
    </div>

    <div class="info-print-2 fl">
        <div class="box-code">

            <?php

                // ID Cliente
                $current_user = wp_get_current_user();
                $id_user = $current_user->ID;
                $id_user = str_pad($id_user, 4, "0", STR_PAD_LEFT);

                // ID Promo
                $id_promo = str_pad($id_promo, 4, "0", STR_PAD_LEFT);

                // Código do Cupom
                $data = date('d/m/Y');
                list($day, $month, $year) = explode('/', $data);
                $code_coupon = $year . "." . $month.$day . ".1." . $id_promo . "." . $id_user;

                // Fields
                $horario_de_consumo = get_field('horario_de_consumo', $id_promo);

            ?>

            <div class="code">
                COD. <?php echo $code_coupon; ?>
            </div>
            <div class="name">
                <?php
                    $fist_name = get_the_author_meta('first_name', $current_user->ID);
                    $last_name = get_the_author_meta('last_name', $current_user->ID);
                    echo $fist_name . " " . $last_name; ?>
            </div>
        </div>
        <div class="validate">
            V&aacute;lido at&eacute;: <?php echo date('d/m/y'); ?>
        </div>
    </div>

    <div class="clr"></div>

</div>

<div class="inner section-1">
    <div class="local fl"><span class="infade">local: </span><?php echo $estabelecimento->post_title; ?></div>
    <div class="validate fl"><span class="infade">validade: </span><?php echo date('d/m/Y'); ?></div>
        <div class="clr"></div>
    <div class="code fl"><span class="infade">c&oacute;digo: </span><?php echo $code_coupon; ?></div>
    <div class="owner fl"><span class="infade">cliente: </span><?php echo $fist_name . " " . $last_name; ?></div>
        <div class="clr"></div>
</div>

<div class="inner section-2">
    <div class="description section-2-all"><span class="infade fl">Descri&ccedil;&atilde;o:</span><?php the_field('descricao', $id_promo) ?></div>
    <div class="price section-2-all"><span class="infade fl">Pre&ccedil;o Pedida:</span><?php the_field('preco_pedida', $id_promo) ?></div>

    <?php if(!empty($horario_de_consumo)) : ?>
        <div class="hour-consume section-2-all"><span class="infade fl">Hor&aacute;rio de Consumo:</span><?php the_field('horario_de_consumo', $id_promo) ?></div>
    <?php endif; ?>

    <div class="limit section-2-all"><span class="infade fl">Limite por Pessoa:</span><?php the_field('limite_pessoa', $id_promo) ?></div>
    <div class="address section-2-all"><span class="infade fl">Endere&ccedil;o:</span><?php the_field('end_estab', $estabelecimento->ID); ?></div>
</div>
<div class="inner section-3">
    <div class="general-rules">
        <span class="infade">Regras Gerais</span>
        <?php
            $content_general_rules = new WP_Query('page_id=47');
            while($content_general_rules->have_posts()) : $content_general_rules->the_post();
                the_content();
            endwhile;
        ?>
    </div>
</div>

<?php wp_footer(); ?>

<script>window.print();</script>

</body>
</html>