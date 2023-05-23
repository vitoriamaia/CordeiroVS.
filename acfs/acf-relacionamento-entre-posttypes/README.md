# TEMA

## Para que serve ?

Quando ouver necessidade de relacionar itens de um posttype.

## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> ACF - acf-relacionamento-entre-posttypes.

2 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.3
4 - Pronto!

PARTE CÓD:

1 - Insira o código: 

<div>
<?php 
$posts = get_field('segmento');

if( $posts ): ?>
    <div>
        <h2 class="tit-nivel2">Segmentos:</h2>
            <ul class="box-seg">
            <?php foreach( $posts as $post): ?>

                <li class="blc-seg-li col-md-3">
                    <a href="<?php the_permalink(); ?>">
                    <img src="<?php the_field('imagem');?>"">
                    <h3><?php the_title(); ?></h3>
                    </a>                            
                </li>
            <?php endforeach; ?>
            </ul>
    </div>
<?php endif; ?>
</div>


<div>
<?php 
$relations = get_field('relacione_a_solucao', $post->ID);
if( $relations ): ?>
<div>
    <h2>Soluções</h2>

        <ul>
        <?php foreach( $relations as $relation) : ?>

            <li>
                <a href="<?php echo get_permalink($relation->ID); ?>">
                    <img src="<?php echo get_field('imagem', $relation->ID);?>">

                    <h3>
                        <?php echo get_the_title($relation->ID); ?>
                    </h3>
                </a>                            
            </li>
        <?php endforeach; ?>
        </ul>

</div>
<?php endif; ?>
</div>




2 - Pronto!


* Versão 2.0 - Modo inicial, testes e aplicação estão começando.


## Autores

* Diego Curuma [Link's'](https://www.github.com/diegocuruma, https://www.behance.net/diegocuruma)

## Referências 

* [Sass](http://sass-lang.com/)
* [Compass](http://compass-style.org/)
* [Grunt](http://gruntjs.com/)
* [Normalize CSS](http://necolas.github.io/normalize.css/)
* [HTML5 Boilerplate](http://html5boilerplate.com/)
* [HTML5 Shiv](https://github.com/aFarkas/html5shiv)
