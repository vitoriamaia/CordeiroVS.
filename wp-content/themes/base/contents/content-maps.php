<div class="col-md-12 mt-50">
    <?php
    $map = get_field('iframe','option');
    if(!empty($map) ) : ?>
		<!--link  do google-->        
		 <iframe src="https://www.google.com/maps/embed?pb=<?php the_field('iframe','option'); ?>" frameborder="0" style="border:0; width:100%; height:500px;"allowfullscreen></iframe>
    <?php else : ?>

    <?php endif; ?>
</div>
