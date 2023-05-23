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
                        
                    </header>
                </div>
                
                <?php get_template_part('contents/content','quem-somos') ?>
                
                
            </div>               
        </div>
      
     
        <!-- daqui para baixo é pardrão-->    
        <?php endwhile; ?>
    </section>
<?php get_footer(); ?>

