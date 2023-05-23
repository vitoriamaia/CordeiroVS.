<div class="swiper-container s2">
	<ul class="swiper-wrapper">							
			<!--if dos campos pra cadastrar as imagens-->
			<?php

			$lists = get_field('listagem');
			if(!empty($lists)) :

				// embaralhar
				//shuffle($lists);

				foreach($lists as $list) :
					?>

					<li class="swiper-slide">
						<!--if pra ver se tem link ou nao-->
						<?php if(!empty($list['links'])) : ?>

							<a href="<?php echo $list['links']; ?>" title="<?php echo $list['links']; ?>" target="_blank">
								<figure>
									<img src="<?php echo $list['imagens']; ?>" alt="<?php echo $list['links']; ?>">
								</figure>
							</a>

							<!--se nao tiver link joga a imagem-->
						<?php else : ?>

							<img src="<?php echo $list['imagens']; ?>" alt="<?php echo $list['links']; ?>">

						<?php endif; ?>

					</li>
					<?php

				endforeach;

			endif; ?>
	</ul>

	<!-- Add Arrows -->
	<div class="swiper-button-next"></div>
	<div class="swiper-button-prev"></div>
</div>  