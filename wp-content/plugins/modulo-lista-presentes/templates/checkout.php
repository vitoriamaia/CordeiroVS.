<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

$products = MLP()->cart->get_cart();

if(!empty($products)){
    $id_client = array_shift($products);
    $id_client = $id_client['content']['id_client'];
}

?>

    <main id="ajax">
        <section class="container-fluid ajax-inner" id="single">
            <article class="container conteudo dest">

                <?php

                /**
                 * Nome do cliente selecionado
                 */

                if(isset($id_client)) { ?>

                    <h1 class="tit1"><?php echo get_the_title($id_client); ?></h1>

                    <div class="content-inner">
                        <div class="col-lg-3">
                            <?php $photo = get_field('photo_customer', $id_client); ?>
                            <img class="photo-wrap" src="<?php echo $photo["sizes"]["thumbnail"] ?>" width="100%">

                            <h2 class="title-customer"><?php echo get_the_title($id_client) ?></h2>
                        </div>

                        <div class="col-lg-9 content-wrap">
                            <?php echo get_field('content', $id_client); ?>
                        </div>
                    </div>

                <?php } elseif( !isset( $_GET['result'] ) ) { ?>

                    <p class="tit1">Cliente não selecionado</p>

                <?php } ?>


                <?php

                /**
                 * Mensagem de agradecimento
                 */

                if (isset($_GET['result']) && empty($products)) : ?>

                    <div class="congratulations">
                        <div class="inner-congratulations">
                            <?php echo get_option('message_congratulations'); ?>
                        </div>
                    </div>

                <?php endif; ?>

                <?php

                $products = MLP()->cart->get_cart();

                /**
                 * Pega os produtos do carrinho e exibe
                 */

                if(!empty($products) && !isset($_GET['result']) ) : ?>

                    <div class="my-checkout">

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                            <h3 class="label-title">Carrinho de compras:</h3>

                            <div class="cart-wrap col-md-12">

                                <?php foreach ($products as $product) :

                                    $post_id = $product["content"]["id_product"];
                                    $id_image = get_post_thumbnail_id($post_id);
                                    $attr_image = apply_filters('get_thumb', $id_image, 'thumbnail');

                                    ?>

                                    <div class="col-md-6">
                                        <img src="<?php echo $attr_image['url_thumb']; ?>" title="<?php echo $attr_image['title']; ?>" class="img-responsive">
                                    </div>
                                    <div class="col-md-6">
                                    <span class="product-price">
                                        Valor: <br/> R$ <?php echo number_format(get_field('preco', $post_id), "2", ",", ".") ?>
                                    </span>
                                    </div>

                                    <div class="col-md-12">
                                        <h3 class="title-product"><?php echo get_the_title($post_id) ?></h3>
                                    </div>

                                <?php endforeach ?>

                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                            <h3 class="label-title">Seus dados:</h3>

                            <div class="data">
                                <form>
                                    <input id="name" type="text" placeholder="Nome completo:*"/>
                                    <input id="email" type="text" placeholder="E-mail*">
                                    <textarea id="message" cols="30" rows="10" placeholder="Mensagem ao presenteado"></textarea>
                                    <input id="client" type="hidden" value="<?php echo $product["content"]["id_client"] ?>">
                                </form>
                            </div>

                            <a href="#" class="checkout_finish">Concluir a compra</a>

                        </div>

                    </div>

                <?php elseif(empty($products) && !isset($_GET['result'])) : ?>

                    <div class="no-product">
                        Nenhum produto no carrinho. <a href="<?php echo get_home_url() ?>" class="voltar">Voltar a página inicial.</a>
                    </div>

                <?php endif; ?>

            </article>
        </section>
    </main>

<?php get_footer(); ?>