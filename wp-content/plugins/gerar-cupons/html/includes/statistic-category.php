<?php

global $wpdb;
$table_coupons = Coupons_Generate::tables('coupons');
$table_coupons_down = Coupons_Generate::tables('coupons_down');

$cats = get_terms('category', array( 'hide_empty' => false ));

?>

<div class="registered">
    <h2>Categorias Cadastradas: <?php echo count($cats); ?></h2>
</div>

<div class="months">
    <div class="period">
        Consulta por Mês<?php if(isset($_GET['month'])) { $month_find = $_GET['month']; echo ": <strong>" . TK_Convert::month2Ext($month_find) . "</strong>"; }; ?>
    </div>
    <?php
        $month_now = date('n');
        for($i=1; $i<=$month_now; $i++) :
    ?>

        <a class="link" href="<?php echo Wp_Home ?>/wp-admin/admin.php?page=record-logs&tab=category&month=<?php echo $i; ?>"><?php echo TK_Convert::month2Ext($i); ?></a>

    <?php endfor; ?>
</div>

<table class="coupon-table">

    <thead>
    <tr>
        <td class="top-coupon-table"> <strong>Categorias (pra&ccedil;as)</strong> </td>
        <td class="top-coupon-table"> <strong>Cupons Gerados</strong> </td>
        <td class="top-coupon-table"> <strong>Cupons Baixados</strong> </td>
    </tr>
    </thead>

    <tbody>

    <?php

    foreach($cats as $cat) :

        if(isset($_GET['month'])){
            $year_now = date('Y');
            $where = " AND YEAR(date_generate)=" . $year_now . " AND MONTH(date_generate)=" . $month_find;
        } else {
            $where = "";
        }

        $id_cat = $cat->term_id;

        $coupons_generates = count($wpdb->get_results( "SELECT * FROM $table_coupons WHERE id_cat = '$id_cat' $where" ));
        $coupons_down = count($wpdb->get_results( "SELECT * FROM $table_coupons_down WHERE id_cat = '$id_cat' $where" ));

        ?>

        <tr>
            <td> <?php echo $cat->name; ?> </td>
            <td> <?php echo $coupons_generates; ?> </td>
            <td> <?php echo $coupons_down; ?> </td>
        </tr>

    <?php endforeach; ?>

    </tbody>

</table>