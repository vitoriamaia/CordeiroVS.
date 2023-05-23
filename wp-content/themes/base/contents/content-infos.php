





<div class="hora-func">
    
<h2 class="tit__2 tit__2--gold">Horário de funcionamento</h2>


<?php if( have_rows('informacoes_do_cabecalho','option') ) : ?>
<?php while (have_rows('informacoes_do_cabecalho','option') ) : the_row(); ?>

   <dl class="blc-campos row">
        <?php
            if( have_rows('horario_de_funcionamento','option') ):
            while ( have_rows('horario_de_funcionamento','option') ) : the_row();
        ?>
        <div class="col-md-6">
            
        <dt>
            <h3 class="tit__3"><?php the_sub_field('titulo');?></h3>
        </dt>

            <?php
                    if( have_rows('campos_adicionais','option') ):
                    while ( have_rows('campos_adicionais','option') ) : the_row();
            ?>    
            <dd>
                <?php the_sub_field('campo_adicional','option');?>
            </dd>
            <?php endwhile; endif; ?>
        </div>

        <?php endwhile; endif; ?>
    </dl>

</div>
  
    <address class="address">
       <?php if(! empty( get_sub_field('telefone')) )	: ?>
            <a href="tel:<?php the_sub_field('telefone'); ?>" class="headertop__subitem" title="Telefone: <?php the_sub_field('telefone_fixo'); ?>">
                <i class="fa fa-phone-square" aria-hidden="true"></i>
                <?php the_sub_field('telefone'); ?>
            </a>
        <?php endif; ?>	

        <?php if(! empty( get_sub_field('whatsapp')) )	: ?>
        <a href="tel:<?php the_sub_field('whatsapp'); ?>" class="headertop__subitem" title="Whatsapp">
            <i class="ion-social-whatsapp-outline" aria-hidden="true"></i>
            <?php the_sub_field('whatsapp'); ?>								
        </a>		
        <?php endif; ?>                    

    </address>    
                
<?php endwhile; endif; ?>  
