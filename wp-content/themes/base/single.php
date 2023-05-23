<?php get_header(); ?>
    <section class="cont cf">
        <?php
        while (have_posts()) : the_post()
        ?>
        <!-- daqui para cima é pardrão-->    

        
        <div class="cf container">
            <div class="row">
               <div class="col-md-12">
                    <header>
                        <h3></h3>
                    </header>
                </div>
                
                            
                <!-- contéudo -->
                <div class="single-post">
                    <div class="single-img">
                        
                    </div>
                    
                    <div class="texto-single">
                    <h3><?php the_title();?></h3>
                        <?php the_content();?>
                    </div>
                </div>       
            </div>               
        </div>
      
     
    <!-- daqui para baixo é pardrão-->    
    <?php endwhile; ?>
    </section>
<?php get_footer(); ?>

