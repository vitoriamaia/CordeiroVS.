<footer>
	
	
	<div class="rdp2">
	<div class="rdp">
		<?php
            if( have_rows('enderecos','option') ):
            while( have_rows('enderecos','option') ) : the_row();
		?>
		<div class="end">

			<?php the_sub_field('endereco');?><?php the_sub_field('bairro');?><?php the_sub_field('cidade-estado');?>
			
		</div>
		<div class="icone">
			<span> fone:
			<?php the_sub_field('iconep');?></span>
		</div>
		<?php   
            endwhile;
            endif;
        ?>
	</div>
	</div>
		
</footer>
		
	<?php wp_footer(); ?>
	
<div class="direitos">
	<div class="col-md-12">
		<div class="col-md-8">
			<div class="reser">
				
			</div>
		</div>
		<div class="col-md-4">
			<div class="edeas">
				<h6>Desenvolvido por :</h6>
			</div>
		</div>
	</div>
</div>
	</html>

