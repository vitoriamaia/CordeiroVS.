# TEMA

## ACF de receitas(Campo Repeater)?

Campo personalizado para criar receitas com ingredientes e modo de preparo.


## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai xamar o ACV que está na pasta originais.

2 - Verifique se está nos campos personalizados, após isso voce diz onde quer aplicar.

3 - Pronto!

PARTE CÓD:

1 - Insira o código: 
## Exemplo de uso:


<!-- ingredientes -->
<ul class="blc-campos">
    <?php
            if( have_rows('ingredientes') ):
            while ( have_rows('ingredientes') ) : the_row();
    ?>
    <li class="">
        <?php the_sub_field('ingrediente_item');?>
    </li>
    <?php endwhile; endif; ?>
</ul>

<!-- modeo de preparo -->
<ul class="blc-campos">
    <?php
            if( have_rows('modo_de_preparo') ):
            while ( have_rows('modo_de_preparo') ) : the_row();
    ?>
    <li class="">
        <?php the_sub_field('modo_de_preparo_item');?>
    </li>
    <?php endwhile; endif; ?>
</ul>



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
