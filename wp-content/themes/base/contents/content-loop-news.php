<?php
if (is_page('blog')):
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $params = array('post_type' => 'post', 'posts_per_page' => 12, 'paged' => $paged);
    query_posts($params);
endif;

// get variable of url
$search = $_GET['s'];
$posttype = $_GET['post_type'];

if (is_search()):
    ?>
    <header class="page-header-search">
        <h2 class="tit tit__4 tit__4--purplethree"><strong>Resultado da pesquisa:</strong> <?php echo $search; ?></h2>
    </header>
<?php endif; ?>

<?php if (is_search() && !isset($posttype)) { ?>

    <?php if (have_posts()): ?>
        <ul class="list-all">
            <?php while (have_posts()): the_post(); ?>
                <li class="list-all__item">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <h4 class="tit tit__5 tit__4--bluefive"><?php the_title(); ?></h4>
                        <i class="fa fa-calendar" aria-hidden="true"></i> <?php the_time('d/m/Y'); ?>
                    </a>
                    <hr/>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

<?php } else { ?>

    <?php if (have_posts()): ?>
        <ul class="row blognewspaper-list">
            <?php while (have_posts()): the_post(); ?>
                <li class="col-md-6 blognewspaper-list__item">
                    <a href="<?php the_permalink(); ?>" class="blognewspaper-list-link" title="<?php the_title(); ?>">

                        <figure class="blognewspaper-list-figure">

                            <div class="crop-img">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('post_medium', array('class' => 'blognewspaper-list-img')); ?>
                                <?php else: ?>
                                    <img src="<?php echo WP_IMAGES; ?>/sem-imagem-370x239.png" alt="Imagem NotÃ­cia"
                                         class="blognewspaper-list-img" width="370" height="239"/>
                                <?php endif; ?>
                            </div>

                            <figcaption class="blognewspaper-list-figcaption">

                                <h2 class="tit tit__5 tit__5--purplethree">
                                    <strong><?php the_field('titulo_home'); ?></strong>
                                </h2>

                                <p><?php the_field('mini_descricao'); ?></p>

                                <div class="align-bottom">
                                    <div class="area-hashitag">
                                        <?php
                                        $count = 0;
                                        $posttags = get_the_tags();
                                        if ($posttags) {
                                            foreach($posttags as $tag) {
                                                $break = $count++;
                                                echo '<span>#'.$tag->name. '</span>';
                                                if( $break == 1 ){break;}
                                            }
                                        }
                                        ?>
                                    </div>

                                    <span class="separator"></span>

                                    <div class="area-data">
                                    <span>
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <?php the_time('d/m/Y'); ?>
                                    </span>
                                    </div>
                                </div>
                            </figcaption>

                        </figure>

                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <h4 class="tit tit__4 tit__4--blueone not-asso">Nenhum post encontrado.</h4>
    <?php endif; ?>

<?php } ?>

<div class="row">
    <div class="col-md-12">
        <?php echo wp_bootstrap_pagination();
        wp_reset_query(); ?>
    </div>
</div>