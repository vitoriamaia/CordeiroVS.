
<?php if( have_rows('imagens') ): ?>
<!--galeria-->
<article class="row">
    <ul class="no-gutter galeria">
        <?php
            while ( have_rows('imagens') ) : the_row();
        ?>
        <li class="galeria__item col-md-2 col-xs-6">
           <?php
                /* utilizando a funcção de thumb e corte ele traz a foto no link */
                $urlImageGran = get_sub_field('imagem');
                //var_dump($urlImageGran);
                $idThumbGran = $urlImageGran['id'];
                $thumbGran = apply_filters('get_thumb', $idThumbGran, 'content-gallery-page');
            ?>
            <a href="<?php echo $thumbGran['url_thumb'] ?>" class="galeria__link fancybox">
               <figure>
				   <?php
					   /* utilizando a funcção de thumb e corte ele traz a foto na imagem*/
					   $urlImage = get_sub_field('imagem');
					   $idThumb = $urlImage['id'];
					   $thumb = apply_filters('get_thumb', $idThumb, 'content-gallery-page-small');
					?>

                <img src="<?php echo WP_IMAGES; ?>/ring.gif" data-original="<?php echo $thumb['url_thumb'] ?>" alt="Galeria de fotos do site FBS" class="lazy img-responsive" />
               </figure>
           </a>
        </li>
        <?php endwhile; ?>
    </ul>

</article>
<?php endif; ?>
