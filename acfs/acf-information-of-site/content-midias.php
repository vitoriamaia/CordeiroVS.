<!-- campos pmidias -->
<ul class="midia pull-right">                                              
	<?php if(!empty(get_field('facebook','option')) ) : ?>
		<li class="midia__item">
			<a href="<?php the_field('facebook','option'); ?>" title="Facebook <?php echo bloginfo('title'); ?>" target="_blank" class="midia__link">
				<span class="fa fa-facebook-official fa-lg midia__icon" aria-hidden="true"></span>
			</a>
		</li>
	<?php else: ?>

	<?php endif; ?>

	<?php if(!empty(get_field('instagram','option')) ) : ?>
		<li class="midia__item">
			<a href="<?php the_field('instagram','option'); ?>" title="Facebook <?php echo bloginfo('title'); ?>" target="_blank" class="midia__link">
				<span class="fa fa-instagram fa-lg midia__icon" aria-hidden="true"></span>
			</a>
		</li>
	<?php else: ?>

	<?php endif; ?>						
</ul> 