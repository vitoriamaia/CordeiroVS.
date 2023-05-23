<!-- Main -->
<main class="main">
    <div class="container">
        <section class="main-container">
            <div class="row">
                <div class="col-md-9 col-sm-9 content-single-post">

                    <?php if (have_posts()): while (have_posts()): the_post(); ?>

                        <header>
                            <h1 class="tit tit__1">
                                <strong><?php the_field('titulo_home'); ?></strong>
                            </h1>
                            <h2 class="tit tit__4">
                                <?php the_field('mini_descricao'); ?>
                            </h2>
                        </header>

                        <?php if (!empty(get_field('link_do_youtube'))) {

                            $id_movie = get_field('link_do_youtube');
                            $movie = apply_filters('get_video', 'https://www.youtube.com/watch?v=' . $id_movie, '', '400', '309');

                            echo $movie['embed'];

                        } elseif (has_post_thumbnail()) { ?>

                            <figure>
                                <a href="<?php the_post_thumbnail_url('large'); ?>" title="<?php the_title(); ?>"
                                   class="fancybox">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            </figure>

                        <?php } else { ?>

                            <figure>
                                <img src="<?php echo WP_IMAGES; ?>/sem-imagem-300x300.png" alt="Sem Imagem" width="170"
                                     height="80"/>
                            </figure>

                        <?php } ?>

                        <span class="area-date">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            <?php the_time('d/m/Y'); ?>
                            &nbsp;
                            <span class="pull-right">
                                publicado por: <i class="fa fa-user" aria-hidden="true"></i> <?php the_author(); ?>
                            </span>
                        </span>

                        <div class="addthis-wrap">
                            <?php echo do_shortcode('[addthis_shortcode_tool]') ?>
                        </div>

                        <div class="content-page">
                            <?php the_content(); ?>
                        </div>


                        <?php echo do_shortcode('[galeries]'); ?>

                        <div class="area-hashitag">
                            <i class="fa fa-tags" aria-hidden="true"></i> Tags:
                            <?php
                            $posttags = get_the_tags();
                            if ($posttags) {
                                foreach ($posttags as $tag) {
                                    echo '<span><strong>#' . $tag->name . ' </strong></span>';
                                }
                            }
                            ?>
                        </div>

                    <?php endwhile; endif; ?>

                </div>
                <div class="col-md-3 col-sm-3">
                    <?php dynamic_sidebar('sidebar-blog'); ?>
                </div>
            </div>
        </section>
    </div>
</main>
<!--/ Main -->