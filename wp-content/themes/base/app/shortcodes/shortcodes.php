<?php
/*
/* Shortcode Galeria
*/
if (!function_exists('galeries')) {
    function galeries()
    {
        ?>
        <ul class="row galeries">
            <?php /*if (have_rows('galeria')): while (have_rows('galeria')): the_row(); */?>
                <li class="col-md-3 col-sm-3 galeries__item">
                    <?php
/*                    $image_id = get_sub_field('imagem');
                    $image_data_full = get_thumb( $image_id['id'], 'full');
                    $image_data = get_thumb($image_id['id'], 'medium');
                    */?>
                    <a href="<?php /*echo $image_data_full['url_thumb']; */?>" class="fancybox">
                        <figure>
                            <img src="<?php /*echo $image_data['url_thumb']; */?>" alt="Imagem"
                                 title="<?php /*echo $image_data['title']; */?>"
                                 width="<?php /*echo $image_data['url_thumb_width']; */?>"
                                 height="<?php /*echo $image_data['url_thumb_height']; */?>" class="wow fadeIn"/>
                        </figure>
                    </a>
                </li>
            <?php /*endwhile; endif; */?>
        </ul>
        <?php
  }

    add_shortcode('galeries', 'galeries');

}