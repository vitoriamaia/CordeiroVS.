<div>
<!-- Nav tabs -->
<ul class="nav nav-tabs no-margin no-padding" role="tablist">
	<?php
	$c = 0;
	if( have_rows('tabs') ):
		while ( have_rows('tabs') ) : the_row();
			$c++;
			?>
			<li role="presentation" class="col-md-2 <?php if ( $c == 1 ){ ?> active <?php }?>">
				<a href="#num<?php echo $c; ?>"  role="tab" data-toggle="tab">
					<h3 class="tit__4">
						<?php the_sub_field('titulo'); ?>
					</h3>	
				</a>			
			</li>

		<?php endwhile; endif; ?>
</ul>

<!-- Tab panes -->
<div class="tab-content mt-20">
	<?php
	$x = 0;
	if( have_rows('tabs') ):
		while ( have_rows('tabs') ) : the_row();
			$x++;
	?>
			<div role="tabpanel" class="tab-pane <?php if ( $x == 1 ){ ?> active <?php }?>" id="num<?php echo $x; ?>">
				<p><?php the_sub_field('descricao'); ?></p>
				
				
					<img src="<?php the_sub_field('imagem'); ?>" class="img-responsive mg-auto" />
				
			</div>

	<?php endwhile; endif; ?>
</div>

</div>