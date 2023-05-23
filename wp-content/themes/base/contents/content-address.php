
    

        
    <!--<h2 class="tit__2 tit__2--gold">Informações</h2>        -->
    <!-- campos para endereço e afins -->          			
	<?php if( have_rows('endereco','option') ) : ?>
	<?php while (have_rows('endereco','option') ) : the_row(); ?>
		<address class="address row">		
			<div class="col-md-8">	
			
				<!--<h3 class="tit__3 tit__3--branco">Endereço</h3>					-->
				<?php 
					if(! empty(get_sub_field('rua_ou_avenida', 'option')) ) :
				?>	
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
					<em class="address__item"><?php the_sub_field('rua_ou_avenida', 'option'); ?></em>
				<?php endif; ?>					

				<?php if(! empty(get_sub_field('bairro', 'option')) )	: ?>
					<em class="address__item"><?php the_sub_field('bairro', 'option'); ?></em>
				<?php endif; ?>

				<?php if(! empty(get_sub_field('cidade', 'option')) )	: ?>
					<em class="address__item"><?php the_sub_field('cidade', 'option'); ?></em>
				<?php endif; ?>

				<?php if(! empty(get_sub_field('estado', 'option')) )	: ?>
					<em class="address__item"><?php the_sub_field('estado', 'option'); ?> </em>
				<?php endif; ?>

				<?php if(! empty(get_sub_field('cep', 'option')) )	: ?>
					 <em class="address__item">- CEP: <?php the_sub_field('cep', 'option'); ?></em>
				<?php endif; ?>
				
				- 
                <a data-toggle="modal" data-target="#exampleModal" href="#" target="_blank"title="Clique para ver a localização no mapa" class="address__item">
                    Localização
                </a>

				
				
            </div>
				

			<div class="col-md-4">				
				<?php if(!empty(get_sub_field('telefone', 'option')) )	: ?>
					<a href="tel:<?php the_sub_field('telefone', 'option'); ?>" class="address__link" title="Telefone">						
						<i class="fa fa-phone-square" aria-hidden="true"></i>
						<?php the_sub_field('telefone', 'option'); ?>								
					</a>	
				<?php endif; ?>	

				<?php if(!empty(get_sub_field('whatsapp', 'option')) )	: ?>
					 <a href="tel:<?php the_sub_field('whatsapp', 'option'); ?>" class="address__link" title="Whatsapp">
						<i class="fa fa-whatsapp" aria-hidden="true"></i>									
						<?php the_sub_field('whatsapp', 'option'); ?>								
					</a>		
				<?php endif; ?>

				<?php if(!empty(get_sub_field('celular')) )	: ?>
					<a href="tel:<?php the_sub_field('celular'); ?>" class="address__link"  title="Celular">											
						<?php the_sub_field('celular'); ?>								
					</a>		
				<?php endif; ?>


				<?php if(!empty(get_sub_field('e-mail')) )	: ?>
					<a href="mailto:<?php the_sub_field('e-mail'); ?>" class="address__link" target="_top" title="E-mail">
					 <i class="fa fa-envelope-o"></i>
					 <?php the_sub_field('e-mail'); ?>
					</a>
				<?php endif; ?>		

			
				<?php if(!empty(get_field('cnpj', 'option')) )  : ?>
				    <em class="address__item"><?php the_field('cnpj', 'option'); ?></em>
				<?php endif; ?>		
			
			</div>



	</address>

	<?php endwhile; endif; ?>   
	
	
	<hr class="pb-50">




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>-->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe src="https://www.google.com/maps/embed?pb=<?php the_field('iframe','option'); ?>" frameborder="0" style="border:0; width:100%; height:100%;"allowfullscreen></iframe>
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>