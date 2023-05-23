<div>
<!-- Nav tabs -->
<ul class="row tabs-head-packages">
	<li class="tit__4 col-md-2 tabs-head-packages__item">
		<a href="#" data-content="local" title="Local">Local</a>				
	</li>

	<li class="tit__4 col-md-2 tabs-head-packages__item">
		<a href="#" data-content="palestrantes" title="Palestrantes">Palestrantes</a>
	</li>
	
	<li class="tit__4 col-md-2 tabs-head-packages__item">
		<a href="#" data-content="programacao" title="Programação">Programação</a>
	</li>
	
	<li class="tit__4 col-md-2 tabs-head-packages__item">
		<a href="#" data-content="hospedagem" title="Hospedagem">Hospedagem</a>
	</li>
	
	<li class="tit__4 col-md-2 tabs-head-packages__item">
		<a href="#" data-content="contato" title="Contato">Contato</a>
	</li>
	

</ul>
<!--Close Tabs-->

	<ul class="row tabs-body-packages">
	<li class="col-md-12 tabs-body-packages__item" id="local">
		<article>
			<h4 class="tit__4"><?php the_field('tab1'); ?></h4>
			<p><?php the_field('descricao'); ?></p>
			
			<img src="<?php the_field('imagem_adicional'); ?>" class="img-responsive mg-auto" />				
		</article>
	</li>
	<li class="col-md-12 tabs-body-packages__item" id="palestrantes">

		<article>
			<h4 class="tit__4"><?php the_field('tab2'); ?></h4>
			<ul class="list-inclui">
				
				
				<?php if( have_rows('lista') ): while( have_rows('lista') ): the_row(); ?>
					<li class="list-inclui__item">
						<h4 class="tit tit__5 tit__4--grayfour">
							<i class="fa fa-chevron-right" aria-hidden="true"></i>
							<?php the_sub_field('item'); ?>
						</h4>
					</li>
				<?php endwhile; endif; ?>

			</ul>
			<img src="<?php the_field('imagem_adicional2'); ?>" class="img-responsive mg-auto" />				
		</article>
	</li>
	<li class="col-md-12 tabs-body-packages__item" id="programacao">
		<h4 class="tit__4"><?php the_field('tab3'); ?></h4>
		<p><?php the_field('descricao3'); ?></p>
		<img src="<?php the_field('imagem_adicional3'); ?>" class="img-responsive mg-auto" />						
	</li>
	<li class="col-md-12 tabs-body-packages__item" id="hospedagem">

		<article>
			<h4 class="tit__4"><?php the_field('tab4'); ?></h4>
			<p><?php the_field('descricao4'); ?></p>	
			<img src="<?php the_field('imagem_adicional4'); ?>" class="img-responsive mg-auto" />				
		</article>
	</li>
	
	<li class="col-md-12 tabs-body-packages__item" id="contato">

		<article>
			<h4 class="tit__4"><?php the_field('tab5'); ?></h4>
			
			
			<ul class="list-downloads">

				<?php if( have_rows('pagamento') ): while( have_rows('pagamento') ): the_row(); ?>
					<li class="list-downloads__item">
						<?php
							$file = get_sub_field('link');
						?>
						<a href="<?php echo $file['url'];?>" title="<?php the_sub_field('Nome'); ?>" target="_blank">
							<i class="fa fa-file-text" aria-hidden="true"></i> <?php the_sub_field('Nome'); ?>
						</a>
					</li>
				<?php endwhile; endif; ?>

			</ul>

		</article>
	</li>

</ul>
</div>