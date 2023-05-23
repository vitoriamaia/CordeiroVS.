<!-- campos para endereço e afins -->
<section class="cf informacoes">            
   <div class="container">

<?php if( have_rows('endereco','option') ) : ?>
<?php while (have_rows('endereco','option') ) : the_row(); ?>
	<address class="address col-md-12 dt">		

		<div class="col-md-4">				
			<?php 
				if(! empty(get_sub_field('rua_ou_avenida')) ) :
			?>	
				<i class="fa fa-map-marker" aria-hidden="true"></i>
				<em class="address__local"><?php the_sub_field('rua_ou_avenida'); ?></em>
			<?php endif; ?>					
			
			<?php if(! empty(get_sub_field('cep')) )	: ?>
				<em class="address__cep">CEP: <?php the_sub_field('cep'); ?></em>
			<?php endif; ?>
			
			<?php if(! empty(get_sub_field('bairro')) )	: ?>
				<em class="address__cep"><?php the_sub_field('bairro'); ?></em>
			<?php endif; ?>

			<?php if(! empty(get_sub_field('cidade')) )	: ?>
				<em class="address__cep"><?php the_sub_field('cidade'); ?></em>
			<?php endif; ?>

			<?php if(! empty(get_sub_field('estado')) )	: ?>
				<em class="address__cep">/<?php the_sub_field('estado'); ?></em>
			<?php endif; ?>
			
			<?php if(! empty(get_sub_field('localizacao')) ) : ?>
																																																																																<a class="address__mapa" href="<?php the_sub_field('localizacao');?>" target="_blank"
																																																																														 title="Clique para ver a localização no mapa">
		<i class="fa fa-map-marker"></i>
		Localização
		</a>
		<?php endif; ?>
		</div>

		<div class="col-md-4">
			<?php if(!empty(get_sub_field('telefone')) )	: ?>
				<i class="fa fa-phone-square" aria-hidden="true"></i>
				<a href="tel:<?php the_sub_field('telefone'); ?>" class="address__telefone" title="Telefone">						
					<?php the_sub_field('telefone'); ?>								
				</a>	
			<?php endif; ?>	
			
			<?php if(!empty(get_sub_field('whatsapp')) )	: ?>
				<i class="fa fa-whatsapp" aria-hidden="true"></i>									
					<?php the_sub_field('whatsapp'); ?>								
				</a>		
			<?php endif; ?>
			
			<?php if(!empty(get_sub_field('celular')) )	: ?>
				<a href="tel:<?php the_sub_field('celular'); ?>" class="address__telefone"  title="Celular">											
					<?php the_sub_field('celular'); ?>								
				</a>		
			<?php endif; ?>
		</div>
		

			<div class="col-md-4">		
				<?php if(!empty(get_sub_field('e-mail')) )	: ?>
					<i class="fa fa-envelope-o"></i>
					<a href="mailto:<?php the_sub_field('e-mail'); ?>" class="address__email" target="_top">
					 <?php the_sub_field('e-mail'); ?>
					</a>
				<?php endif; ?>																									
			</div>				
	</address>

<?php endwhile; endif; ?>   

	</div>
</section>