<?php

if (current_user_can('administrator') || current_user_can('client')) {

    $id_client = (!empty($_GET['client'])) ? esc_attr((int)$_GET['client']) : 0;

} else {

    $id_client = get_current_user_id();

}

$status_payment = array(
    1 => "Aguardando pagamento",
    2 => "Em análise",
    3 => "Paga",
    4 => "Disponível",
    5 => "Em disputa",
    6 => "Devolvida",
    7 => "Cancelada"
);

$transactions = MLP()->queries->client_detail($id_client);

?>

<table class="coupon-table">

    <thead>
    <tr>
        <td class="top-coupon-table">
            <strong>
                Produto
            </strong>
        </td>
        <td class="top-coupon-table">
            <strong>
                Convidado
            </strong>
        </td>
        <td class="top-coupon-table">
            <strong>
                E-mail
            </strong>
        </td>
        <td class="top-coupon-table">
            <strong>
                Mensagem
            </strong>
        </td>

        <?php if (current_user_can('administrator') || current_user_can('client')) : ?>
            <td class="top-coupon-table">
                <strong>
                    Valor Real Arrecadado
                </strong>
            </td>
            <td class="top-coupon-table">
                <strong>
                    Valor com Abatimento
                </strong>
            </td>
        <?php else : ?>
            <td class="top-coupon-table">
                <strong>
                    Valor Arrecadado
                </strong>
            </td>
        <?php endif ?>

        <td class="top-coupon-table">
            <strong>
                Status
            </strong>
        </td>
        <td class="top-coupon-table">
            <strong>
                Data
            </strong>
        </td>
    </tr>
    </thead>

    <tbody>

    <?php if (!empty($transactions)) : foreach ($transactions as $transaction) :

        $percent = get_post_meta($transaction->id_post_customer, 'percent_commission');
        $value_product = $transaction->valor;

        ?>

        <tr>
            <td>
                <?php echo get_the_title($transaction->id_product); ?>
            </td>

            <td>
                <?php echo $transaction->nome; ?>
            </td>

            <td>
                <a href="mailto:<?php echo $transaction->email; ?>" class="button">
                    <?php echo $transaction->email; ?>
                </a>
            </td>

            <td>
                <?php echo $transaction->message; ?>
            </td>

            <?php echo (current_user_can('administrator') || current_user_can('client')) ?
                "<td>R$ " . number_format($value_product, 2, ',', '.') . "</td>" : ""; ?>

            <?php $total_value = $value_product - ($value_product * ($percent[0] / 100)); ?>

            <td>
                R$ <?php echo number_format($total_value, 2, ",", ".") ?>
            </td>

            <td>
                <?php echo $status_payment[$transaction->status]; ?>
            </td>

            <td>
                <?php echo date("Y/n/d", strtotime($transaction->data)); ?>
            </td>
        </tr>

    <?php endforeach; endif; ?>

    </tbody>

</table>