<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


class infos extends WP_Widget
{
    /**
     *
     *  Method Constuctor
     */
    public function __construct()
    {
        parent::__construct(
            'infos',
            'infos',
            array(
                'classname' => 'infos',
                'description' => 'Widget para informaçoes do site.'
            )
        );
    }

    /**
     * Front-end display of widget.
     */
    public function widget($args, $instance)
    {
        ?>

      
			    <section class="cf container">                                                                                                                            
				    <?php
					$args =array(
						'post_type' => 'info',
						'posts_per_page' => 3,
                    );
                    $info = new WP_Query($args);
                    while ( $info->have_posts() ) : $info->the_post();
                    $start++;
                    ?>
                <div class="container">
                    
                    
                    <div class="serv-info">
                        <a href="<?php the_permalink();?>">                   
							<div class="col-md-4 ">
                                <div class="info">
                                    <div class="imagersp">
                                        <div class="content-letter">
                                        <?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
                                        <div class="letraaa">
                                                <?php the_title();?>
                                                </div>
                                                <?php the_content();?>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            </div>
                        </a>
                    </div>
                    </div>
                    <?php endwhile; wp_reset_query(); ?>            
                </section>
        <?php
    }

}
// Registra Widget
add_action('widgets_init', create_function('', 'return register_widget("infos");'));

?>
</body>