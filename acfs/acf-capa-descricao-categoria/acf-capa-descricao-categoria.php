<?php
	$terms = get_terms('categoria');
		if (!empty($terms)) :
			?>

			<!-- as categorias de produtos-->
			<div class="mt-20">
				<ul class="row">
					<?php foreach ($terms as $term) :

						$term_link = get_term_link($term);
						if (is_wp_error($term_link)) {
							continue;
						}

						$linkCat = esc_url($term_link);


						// nome da categoria
						$nameCat = $term->name;
						// capa
						$img = get_field('capa', $term);
						// descrição da categoria
						$desc = get_field('descricao', $term);
						// cor
						$cor = get_field('cor', $term);
						?>

						<li class="servicos col-md-4 col-xs-6 col-sm-6 mb-30">
							<a href="<?php echo $linkCat ?>" title="" class="servicos__link">
								<figure class="box">
									<div class="box__item">												
										<img src="<?php echo $img; ?>" class="img-responsive box__img">
											<h3 class="tit__3 tit__3--branco">
												<?php echo $nameCat ?>
											</h3>
									</div>
								</figure>
							</a>
						</li>

					<?php endforeach; ?>

				</ul>                                                
			</div>

		<?php endif; ?>