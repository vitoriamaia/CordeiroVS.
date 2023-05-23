
<!--verifica imagem interna em fuctions-->
<div class="capa-interna">
	<?php echo do_shortcode('[image_page]'); ?>
	<header class="capa-interna__item">
		<div class="capa-interna__vertical">
			<div class="capa-interna__middle">
				<h2 class="tit__2 tit__2--interno branco"><span><?php the_title(); ?></span></h2>
			</div>
		</div>
	</header>
</div>

<figure class="col-md-3 mt-40">

	<!--imagem-->
	<?php
	$img = get_field('imagem_lateral');						
	$imgCapa = apply_filters('get_thumb', $img['id'], 'capa_persona');
	?>
	<img alt="<?php echo $imgCapa['alt']; ?>" class="img-responsive" src="<?php echo $imgCapa['url_thumb']; ?>"
		 width="<?php echo $imgCapa['url_thumb_width']; ?>" height="<?php echo $imgCapa['url_thumb_height']; ?>"
	/>

</figure>
               
               
        
/**
 * Shortcode page image
 */
function image_page(){

    //recebe o thumbnail
    $url_image = get_field('imagem');

    //recebe a imagem do teme option
    $imageFieldOption = get_field('foto_destaque_de_pagina_interna', 'option');
    ?>

    <div class="img-content">

        <img src="
           <?php
        //var_dump($url_image);
        if(! empty($url_image)) :
            //se existir o thumbnail imprime se nao
            echo $url_image['url'];

        else :
            //imprime a imagem do teme option
            echo $imageFieldOption['url'];


        endif ;?>"
             class="img-responsive img-page-custon">

    </div>
    <?php

}

add_shortcode('image_page','image_page');       
                