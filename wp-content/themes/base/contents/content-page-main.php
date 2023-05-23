
<section class="cont cf">
    <?php if( have_posts() ): while( have_posts() ):  the_post(); ?>

        <div class="cf container">
            <div class="row">
                
                <div class="content-page col-md-12">
                    <!-- contéudo -->
                    <?php the_content(); ?>

                </div>
            </div>
            <?php echo do_shortcode('[galeries]'); ?>

        </div>
    <?php endwhile; endif; ?>

</section>

