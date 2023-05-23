<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


class servicos extends WP_Widget
{
    /**
     *
     *  Method Constuctor
     */
    public function __construct()
    {
        parent::__construct(
            'servicos',
            'servicos',
            array(
                'classname' => 'servicos',
                'description' => 'Widget para área de serviços no site.'
            )
        );
    }

    /**
     * Front-end display of widget.
     */
	
	 
    public function widget($args, $instance)
    {
        ?>
		
		<div class="downArrow bounce">
  <img width="40" height="40" alt="" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDMyIDMyIiBoZWlnaHQ9IjMycHgiIGlkPSLQodC70L7QuV8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMycHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik0yNC4yODUsMTEuMjg0TDE2LDE5LjU3MWwtOC4yODUtOC4yODhjLTAuMzk1LTAuMzk1LTEuMDM0LTAuMzk1LTEuNDI5LDAgIGMtMC4zOTQsMC4zOTUtMC4zOTQsMS4wMzUsMCwxLjQzbDguOTk5LDkuMDAybDAsMGwwLDBjMC4zOTQsMC4zOTUsMS4wMzQsMC4zOTUsMS40MjgsMGw4Ljk5OS05LjAwMiAgYzAuMzk0LTAuMzk1LDAuMzk0LTEuMDM2LDAtMS40MzFDMjUuMzE5LDEwLjg4OSwyNC42NzksMTAuODg5LDI0LjI4NSwxMS4yODR6IiBmaWxsPSIjMTIxMzEzIiBpZD0iRXhwYW5kX01vcmUiLz48Zy8+PGcvPjxnLz48Zy8+PGcvPjxnLz48L3N2Zz4=" />
</div>

            <section class="cf container">
                <?php
					$args =array(
					'post_type' => 'servico',
					'posts_per_page' => 3,
                
					);
                        $servico = new WP_Query($args);
							while ( $servico -> have_posts() ) : $servico-> the_post();
                ?>
				 

				
                
				
			<div class='app-container dp-flip-container outer-layer'>
            <div class="flip-container" ontouchstart="this.classList.toggle('hover');">  	
				<div class="flipper">  
					<div class="front">
                        <div class="cem-conteudo">
                            <div class="conteudo">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <ul class="galeria">
                                        <li>
                                        
                                            <a href=<?php echo get_permalink(580);?>>
                                                <?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="back">
                        <div class="cem-conteudo">
                            <div class="conteudo">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <ul class="galeria">
                                        <li>
                                            <a href=<?php the_permalink();?>>
                                            
                                                <?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>

                                            </a>
                                        </li>
                                        <button value="Confira"class="btn--bt">confira</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


			    </div>
            </div>
			</div>

                <?php endwhile; wp_reset_query(); ?>            
                                
            </section>
        
        <?php
    }

}


// Registra Widget
add_action('widgets_init', create_function('', 'return register_widget("servicos");'));

?>


