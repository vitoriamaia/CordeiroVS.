<?php
    get_header();
    global $post;
    $id_client = $post->ID;
?>

<main id="ajax">
    <section class="container-fluid ajax-inner" id="single">
        <article class="container conteudo dest">

            <h1 class="tit1"><?php echo $post->post_title;?></h1>

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

            <h3 class="select-gift-text">Selecione o presente:</h3>

            <ul class="blc row" style="clear: both">
                <?php
                $fields = get_field( "products", $id_client);

                $init = 1;

                if($fields) :
                    foreach($fields as $post_id) :
                        $id_image = get_post_thumbnail_id($post_id);
                        $attr_image = apply_filters('get_thumb', $id_image, 'thumbnail');
                ?>

                        <li class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="container-product">
                                <a href="#" data-client="<?php echo $id_client; ?>" data-product="<?php echo $post_id; ?>" data-action="add" class="checkout_product blc-a">
                                    <img src="<?php echo $attr_image['url_thumb']; ?>" title="<?php echo $attr_image['title']; ?>" class="img-responsive">
                                    <h2 class="title-product"><?php echo get_the_title($post_id) ?></h2>
                                    <span class="price">R$ <?php echo number_format(get_field('preco', $post_id), "2", ",", ".") ?></span>
                                    <span class="gift">Presentear</span>
                                </a>
                            </div>
                        </li>

                    <?php
                    echo ($init == 4) ? "<span style='clear: both; display: block;'>&nbsp;</span>" : "";
                    $init++;
                    endforeach;
                endif; ?>
            </ul>

        </article>
    </section>
</main>

<?php get_footer();?>