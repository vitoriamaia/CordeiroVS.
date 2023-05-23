<?php

$clients = MLP()->queries->clients_with_transaction();
$total_clients = count($clients);

?>

<div class="registered">
    <h2>Clientes com Transações: <?php echo $total_clients; ?></h2>
</div>

<table class="coupon-table">

    <thead>
    <tr>
        <td class="top-coupon-table"><strong>Cliente</strong></td>
        <td class="top-coupon-table"><strong>Valor Real Arrecadado</strong></td>
        <td class="top-coupon-table"><strong>Valor com Abatimento</strong></td>
        <td class="top-coupon-table"><strong>A&ccedil;&atilde;o</strong></td>
    </tr>
    </thead>

    <tbody>

    <?php

    if($clients) : foreach ($clients as $client) :

        $id_client = $client->id_post_customer;
        $id_client = intval($id_client);

        $values = MLP()->queries->single_client_values($id_client);

        $percent = get_post_meta($id_client, 'percent_commission');

        $total_value = array();

        if (!empty($values)) {
            foreach ($values as $value) {
                $total_value[] = $value->valor;
            }
        } else {
            $total_value[] = 0;
        }

        $total_value = array_sum($total_value);

        ?>

        <tr>
            <td>
                <?php echo get_the_title($id_client); ?>
            </td>
            <td>
                R$ <?php echo number_format($total_value, 2, ",", ".") ?>
            </td>
            <td>
                <?php if ($total_value != 0) {
                    $total_value = $total_value - ($total_value * ($percent[0] / 100));
                } ?>
                R$ <?php echo number_format($total_value, 2, ",", ".") ?> (<?php echo $percent[0] ?>%)
            </td>
            <td>
                <a href="<?php echo admin_url() ?>admin.php?page=statistic_store&client=<?php echo $id_client; ?>&detail=all" class="button">
                    Ver
                </a>
            </td>
        </tr>

    <?php endforeach; endif; ?>

    </tbody>

</table>