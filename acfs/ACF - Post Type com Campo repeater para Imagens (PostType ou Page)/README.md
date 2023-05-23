# TEMA

## Fotos em campo repeater (Campo Repeater)?

Um Post Type com um campo repetidor de imagens e links, útil para criar pagina de logos, fotos e etc. Pode ser utilizada em um carrousel ou pagina de fotos com logos ou qualquer pagina com fotos.

Para galeria tbm é util, mas indicamos a ACF de Galeria.

## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai xamar o ACF - Post Type com Campo repeater para Imagens que está na pasta originais. 

2 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.


3 - Pronto!

PARTE CÓD:

1 - Insira o código: 
## Exemplo de uso em um carrousel dentro do posttype:


<ul>
<!--while do post - -->
<!--posttype 'produtos' pode haver vários post's, então captura-se a ID da page que queira trazer-->
<?php $fotos = new WP_Query ( array ( 'post_type' => 'produto','page_id'=>352));
while($fotos->have_posts()) : $fotos->the_post();
?>

    <!--if dos campos pra cadastrar as imagens-->
    <?php 
        if( have_rows('listagem') ):
        while ( have_rows('listagem') ) : the_row();

    ?>
        <li>  
          <!--if pra ver se tem link ou nao-->                         
            <?php if(get_sub_field('links') != '') : ?>
            <a href="<?php the_sub_field('links'); ?>"  class="pure-u-md-24-24" title="Acesse: <?php the_sub_field('links'); ?>">
                <img src="<?php the_sub_field('imagens'); ?>" alt="" class="">
            </a>
             <!--se nao tiver link joga a imagem-->  
            <?php else : ?>
            <img src="<?php the_sub_field('imagens'); ?>" alt="<?php the_sub_field('links'); ?>" class="">

            <?php endif; ?>
        </li>
        <?php endwhile; endif; ?>

        <?php     
         endwhile; wp_reset_query(); 
        ?>
    </ul>   

<div class="customNavigation">
  <a class="btn prev img_rep">Previous</a>
  <a class="btn next img_rep">Next</a>
</div>



2 - Pronto!


* Versão 0.0.3 - Modo inicial, testes e aplicação estão começando.


## Autores

* Diego Curuma [Link's'](https://www.github.com/diegocuruma, https://www.behance.net/diegocuruma)
* Isabela [Link](https://www.link)
* Jonas Sousa [Behance](https://www.behance.net/onasousa)
* Allef Bruno [Behance](https://www.behance.net/)

## Referências 

* [Sass](http://sass-lang.com/)
* [Compass](http://compass-style.org/)
* [Grunt](http://gruntjs.com/)
* [Normalize CSS](http://necolas.github.io/normalize.css/)
* [HTML5 Boilerplate](http://html5boilerplate.com/)
* [HTML5 Shiv](https://github.com/aFarkas/html5shiv)
