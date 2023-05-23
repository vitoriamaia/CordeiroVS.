<li class="swiper-slide">                                                        
	<header class="tit-painel">
		<?php 
			// se for diferente de vazio traz
			if(! empty(get_field('evento', $banner->ID)) ) : ?>                            	
			<h2 class="tit-painel__pri title"  data-swiper-parallax="-200"><?php the_field('evento', $banner->ID);?></h2>                            		
		<?php 
		else: 
		// nao tiver conteudo retorna nada 
		?>                                                                
		<?php
		// fecha o if
		endif;
		?>  

		<?php 
			// se for diferente de vazio traz
			if(! empty(get_field('data', $banner->ID)) ) : ?>   

			<h3 class="tit-painel__sub subtitle" data-swiper-parallax="-300">
			<i class="fa fa-calendar" aria-hidden="true"></i>
			<?php the_field('data', $banner->ID);?></h3>                            		
		<?php 
		else: 
		// nao tiver conteudo retorna nada 
		?>                                                                
		<?php
		// fecha o if
		endif;
		?>   

		<?php 
			// se for diferente de vazio traz
			if(! empty(get_field('hora', $banner->ID)) ) : ?>                            	
			<h3 class="tit-painel__sub subtitle" data-swiper-parallax="-400">
			<i class="fa fa-clock-o" aria-hidden="true"></i>
			<?php the_field('hora', $banner->ID);?></h3>                            		
		<?php 
		else: 
		// nao tiver conteudo retorna nada 
		?>                                                                
		<?php
		// fecha o if
		endif;
		?> 

		<?php 
			// se for diferente de vazio traz
			if(! empty(get_field('local', $banner->ID)) ) : ?>                            	
			<h3 class="tit-painel__sub subtitle" data-swiper-parallax="-500">
			<i class="fa fa-map-marker" aria-hidden="true"></i>
			<?php the_field('local', $banner->ID);?></h3>                            		
		<?php 
		else: 
		// nao tiver conteudo retorna nada 
		?>                                                                
		<?php
		// fecha o if
		endif;
		?>

		<?php 
			// se for diferente de vazio traz
			if(! empty(get_field('botao_do_link', $banner->ID)) ) : ?>                            	
			<a href="<?php echo $href; ?>" class="bts__bt bts__bt--red mt-7" target="<?php echo $window; ?>">
				<?php the_field('botao_do_link', $banner->ID);?>										
			</a>                                		
		<?php 
		else: 
		// nao tiver conteudo retorna nada 
		?>                                                                
		<?php
		// fecha o if
		endif;
		?>


	</header>                                                                                             

	<?php echo $html_banner ?>

</li>