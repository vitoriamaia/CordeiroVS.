<?php

/**
 * @package sklbase
 * @since sklbase 1.0
 * @license GPL 2.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php html_tag_schema(); ?>>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="author" content="E-deas, contato@e-deas.com.br"/>
    <meta name="copyright" content="E-deas Web">
    <meta name="theme-color" content="#893a2a">

    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="author" href="<?php echo WP_HOME ?>/humans.txt" type="text/plain"/>

    <link rel="shortcut icon" href="<?php echo WP_IMAGES ?>/favicon.png"/>
    
     <!-- GoogleFontes-->
    <link href="https://fonts.googleapis.com/css?family=Hind:300,400" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    
   
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Header -->
<header class="header">
    <div class="col-md-12">
        <div class="facebook">
            <?php
                if( have_rows('redes','option') ):
                while( have_rows('redes','option') ) : the_row();
                $img= get_sub_field('facebook');
            ?>
            
            <div class="facebook text-center">
                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
            </div>
        </div>
    </div>
            

            <?php   
                endwhile;
                endif;
            ?>
                           
        </div>
    </div>
    <a class="logo navbar-brand mr-auto" href="<?php echo WP_HOME; ?>" title="<?php echo bloginfo('title'); ?>">
            <?php echo getLogoHeader('full', array( 'class' => 'img-fluid' ) ); ?>
    </a>
                        
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
        
    <div class="box_contato">
            <?php
                if( have_rows('enderecos','option') ):
                while( have_rows('enderecos','option') ) : the_row();
            ?>
                            
        <div class="telefone ">
            <span class="fon">
                
            <?php the_sub_field('telefone');?></span>
        
        </div>
        <div class="email">
            <?php
                if( have_rows('email','option') ):
                while( have_rows('email','option') ) : the_row();
                
            ?>
            
            <div class="email text-center">
                <?php the_sub_field('email');?>  
            </div>
            <?php   
            endwhile;
            endif;
        ?>
        </div>
        
        <?php   
            endwhile;
            endif;
        ?>
        
        
    </div>     
        
            
                                    
   
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
        <div class="headingg">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                    


            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                
                    <?php /* Primary navigation */
                        wp_nav_menu(array(
                                'theme_location' => 'menu',
                                'menu' => 'container',
                                'depth' => 0,
                                'container' => false,
                                'menu_class' => 'navbar-nav',
                                //Process nav menu using our custom nav walker
                                'walker' => new wp_bootstrap_navwalker())
                        );
                    ?>                                        
            </div> </div> 
                                 
            <div class="col-md-3 sub-infos">
                <!-- infos -->
                <?php #get_template_part('contents/content','infos' ); ?>		   

                <!--midias-->
                <?php #get_template_part('contents/content','midias' ); ?>
            </div>
        </div><!-- /.container -->
    </nav>
</header>
<!--/ Header -->



<main>
    <article>
        <?php if(! is_home()): ?>

            <!--verifica imagem interna em fuctions-->
            <?php get_template_part('contents/content','header' ); ?>

        <?php endif; ?>
</article>
</main>
