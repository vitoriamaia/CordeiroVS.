<?php

global $wpdb;
$table_coupons = Coupons_Generate::tables('coupons');
$table_coupons_down = Coupons_Generate::tables('coupons_down');

$posts_array = get_posts( array( 'post_type' => 'estabelecimento' ) );

?>

<div class="registered">
    <h2>Estabelecimentos Cadastrados: <?php echo count($posts_array); ?></h2>
</div>

<table class="coupon-table">

    <thead>
        <tr>
            <td class="top-coupon-table"> <strong>Estabelecimento</strong> </td>
            <td class="top-coupon-table"> <strong>Data de Cadastro</strong> </td>
            <td class="top-coupon-table"> <strong>Cupons Gerados</strong> </td>
            <td class="top-coupon-table"> <strong>Cupons Baixados</strong> </td>
        </tr>
    </thead>

    <tbody>

    <?php

    foreach($posts_array as $post) :
        $id_provider = $post->ID;
        $coupons_generates = count($wpdb->get_results( "SELECT * FROM $table_coupons WHERE id_emporium = '$id_provider'" ));
        $coupons_down = count($wpdb->get_results( "SELECT * FROM $table_coupons_down WHERE id_emporium = '$id_provider'" ));

    ?>

        <tr>
            <td> <?php echo $post->post_title; ?> </td>
            <td> <?php echo $post->post_date; ?> </td>
            <td> <?php echo $coupons_generates; ?> </td>
            <td> <?php echo $coupons_down; ?> </td>
        </tr>

    <?php endforeach; ?>

    </tbody>

</table>