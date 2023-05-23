
    <ul>	
        
        <!--is home-->      
        <?php if (is_home() ) {?>
            <div class="swiper-container s2">
                <ul class="swiper-wrapper">							
                        <!--if dos campos pra cadastrar as imagens-->
                        <?php

                        $lists = get_field('listagem');
                        if(!empty($lists)) :

                            // embaralhar
                            shuffle($lists);

                            foreach($lists as $list) :
                                ?>

                                <li class="swiper-slide imgempresa">
                                    <!--if pra ver se tem link ou nao-->
                                    <?php if(!empty($list['links'])) : ?>

                                        <a href="<?php echo $list['links']; ?>" title="<?php echo $list['links']; ?>" target="_blank">
                                            <figure>
                                                <img src="<?php echo $list['imagens']; ?>" alt="<?php echo $list['links']; ?>">
                                            </figure>
                                        </a>

                                        <!--se nao tiver link joga a imagem-->
                                    <?php else : ?>

                                        <img src="<?php echo $list['imagens']; ?>" alt="<?php echo $list['links']; ?>">

                                    <?php endif; ?>

                                </li>
                                <?php

                            endforeach;

                        endif; ?>
                </ul>

                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            
            
            
        <!--fecha o if e traz a outrapage-->
        <?php } 
        elseif (is_page( 634 ) ) {?>

            <div>
                <ul>							
                        <!--if dos campos pra cadastrar as imagens-->
                        <?php

                        $lists = get_field('listagem');
                        if(!empty($lists)) :

                            // embaralhar
                            shuffle($lists);

                            foreach($lists as $list) :
                                ?>

                                <li class="col-md-3 mb-50">
                                    <!--if pra ver se tem link ou nao-->
                                    <?php if(!empty($list['links'])) : ?>

                                        <a class="thumbnail" href="<?php echo $list['links']; ?>" title="<?php echo $list['links']; ?>" target="_blank">
                                            <figure>
                                               
                                                <img src="<?php echo WP_IMAGES; ?>/ring.gif" data-original="<?php echo $list['imagens']; ?>" alt="<?php echo $list['imagens']; ?>" class="lazy img-responsive" />
                                            </figure>
                                        </a>

                                        <!--se nao tiver link joga a imagem-->
                                    <?php else : ?>

                                        <div class="thumbnail">
                                            <img src="<?php echo WP_IMAGES; ?>/ring.gif" data-original="<?php echo $list['imagens']; ?>" alt="<?php echo $list['imagens']; ?>" class="lazy img-responsive" />
                                        </div>

                                    <?php endif; ?>

                                </li>
                                <?php

                            endforeach;

                        endif; ?>
                </ul>

                <!-- Add Arrows -->
                <!--<div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>-->
            </div>

        
        <?php } ?>
        
        		
    </ul>

		           