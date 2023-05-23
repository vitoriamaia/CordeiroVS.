<?php

global $wpdb;
$table_coupons = Coupons_Generate::tables('coupons');
$table_coupons_down = Coupons_Generate::tables('coupons_down');

$user_query = new WP_User_Query( array( 'include' => array( 1, 2, 3 )) );

#var_dump($user_query->results[0]->data->ID);

?>

<div class="registered">
    <h2>Usuários Cadastrados: <?php echo $user_query->total_users; ?></h2>
</div>

<table class="coupon-table">

    <thead>
        <tr>
            <td class="top-coupon-table"> <strong>Clientes</strong> </td>
            <td class="top-coupon-table"> <strong>Data de Cadastro</strong> </td>
            <td class="top-coupon-table"> <strong>Cupons Gerados</strong> </td>
            <td class="top-coupon-table"> <strong>Cupons Baixados</strong> </td>
        </tr>
    </thead>

    <tbody>

    <?php

    foreach($user_query->results as $user) :
        $id_user = $user->data->ID;
        $fist_name = get_the_author_meta('first_name', $id_user);
        $last_name = get_the_author_meta('last_name', $id_user);
        $coupons_generates = count($wpdb->get_results( "SELECT * FROM $table_coupons WHERE id_user = '$id_user'" ));
        $coupons_down = count($wpdb->get_results( "SELECT * FROM $table_coupons_down WHERE id_user = '$id_user'" ));

    ?>

        <tr>
            <td> <?php echo $fist_name . " " . $last_name; ?> </td>
            <td> <?php echo get_the_author_meta('user_registered', $id_user) ?> </td>
            <td> <?php echo $coupons_generates; ?> </td>
            <td> <?php echo $coupons_down; ?> </td>
        </tr>

    <?php endforeach; ?>

    </tbody>

</table>


<!--
#$select = $wpdb->get_results( "SELECT DISTINCT YEAR(data) as Ano FROM $tabela WHERE restaurante = '$id' ORDER BY Ano DESC" );

#if ($select) : ?>
-->