<?php
        while (have_posts()) : the_post()
        ?>
<?php
                            $args =array(
                            'post_type' => 'dica',
                            'posts_per_page' => -1,
                
                                );
               
               
              
                                $dicav = new WP_Query($args);
                                while ( $dicav -> have_posts() ) : $dicav-> the_post();
              
                   
                        ?>


<div id="oi">
  <div class="headi">
    <div class="head2"id="texto">
      <h3><i class="fas fa-angle-down"></i>Saiba um pouco mais sobre nós
      </h3>
        <ul class="acess">
          <a href="javascript:mudaTamanho('texto', -1);">A-</a>
          <a href="javascript:mudaTamanho('texto', 1);">A+</a>
          <a href="javascript:history.back();">Voltar</a>
        </ul>
        <div class="texto">
          <?php the_content();?> 
        </div>
        <ul class="acess2">
          <a href="javascript:linktop;">Voltar</a>
          <a href=""> Topo</a>
        </ul>
    </div>
  </div>
</div>
</div>
  

    




