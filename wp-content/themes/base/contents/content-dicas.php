<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <!-- contéudo -->
    <div class="oi">
            
    <section class="container">      
						                                                                                                                
                        <?php
                            $args =array(
                            'post_type' => 'dica',
                            'posts_per_page' => -1,
                
                                );
               
               
              
                                $dicav = new WP_Query($args);
                                while ( $dicav -> have_posts() ) : $dicav-> the_post();
              
                  
                        ?>
                                                       
                        
                            <a href="<?php the_permalink();?>">
                            <?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive' ) ); ?>

                            <div class="letraaa"><?php the_title();?>
                            </div>
                              </a>  
                       
                       
                            
                            
                <?php endwhile; wp_reset_query(); ?>
                
                
                </section>            
                </div> 
                            </div>
                            </div> 
                            



