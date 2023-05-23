# TEMA

## Para que serve o Tema?

Quando ouver necessidade de criar condicional para link externo.

## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai xamar o ACV que está na pasta originais.

2 - Verifique se está nos campos personalizados, após isso voce diz onde quer aplicar.

3 - Pronto!

PARTE CÓD:

1 - Insira o código: 
<ul id="owl-demo" class="owl-carousel">

    <?php $bN = New wp_query ( array ( 'post_type' => 'banner') );
        while ( $bN -> have_posts() ): $imoveis -> the_post();
        //habilitando link pelo camp personalizado
        $habilitar = get_field("habilitar_link");
    ?>
    <li class="owl-item">
        <!--habilitando link pelo camp personalizado-->
        <?php if( get_field('habilitar_link') !=False && get_field('url_do_link') !=False) { ?>        
         <a href="<?php the_field('url_do_link'); ?>" title="<?php the_title();?>" target="_blank">
            <?php the_post_thumbnail();?>                          
         </a>             
         <?php  }else{ the_post_thumbnail(); }?> 
    </li>                
   <?php endwhile; ?>
</ul>


* Versão 0.0.1 - Modo inicial, testes e aplicação estão começando.


## Autores

* Allef
* Diego Curuma [Link's'](https://www.github.com/diegocuruma, https://www.behance.net/diegocuruma)
* Jonas Sousa [Behance](https://www.behance.net/onasousa)

## Referências 

* [Sass](http://sass-lang.com/)
* [Compass](http://compass-style.org/)
* [Grunt](http://gruntjs.com/)
* [Normalize CSS](http://necolas.github.io/normalize.css/)
* [HTML5 Boilerplate](http://html5boilerplate.com/)
* [HTML5 Shiv](https://github.com/aFarkas/html5shiv)
