<ul class="equipe cards">
    <!--if dos campos pra cadastrar as imagens-->
    <?php

    $equipe = get_field('equipe');
    if(!empty($equipe)) :

//             embaralhar
        //shuffle($equipe);

        foreach($equipe as $equi) :
            ?>

            <li class="equipe__li col-md-12 mb-50">
                    <div class="col-md-2">
                        <?php if( $equi['foto']) : ?>
                        <img src="<?php echo $equi['foto']; ?>" alt="<?php echo $equi['nome']; ?>" class="img-circle img-responsive">

                            <?php else: ?>
                            <img src="<?php echo WP_IMAGES; ?>/sem-imagem2.jpg" alt="Sem imagem para o artigo" class="img-circle img-responsive" width="370" height="270" />

                        <?php endif; ?>                                                
                    </div>
                    <div class="col-md-9">

                    <h3 class="tit__3"><?php echo $equi['nome']; ?></h3>
                    <h4 class="tit__4"><?php echo $equi['funcao']; ?></h4>
                    <p><?php echo $equi['bio']; ?></p>


                    <?php if( $equi['playlist']) : ?>
                        <a href="<?php echo $equi['playlist']; ?>" title="Playlist no Spotify" target="_blank">
                            <i class="fa fa-spotify fa-2x" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                    </div>
            </li>
        <?php

        endforeach;

    endif; ?>
</ul>