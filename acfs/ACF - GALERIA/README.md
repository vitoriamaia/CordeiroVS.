# TEMA

## Para que serve a Galeria (Campo Repeater)?

Para a criação de galerias independente do content wordpress.

## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai chamar o ACF - Campo Repetidor (Galeria) que está na pasta originais.

2 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar. 

3 - Insira um lightbox de sua preferência.

4 - Pronto!

PARTE CÓD:

1 - Insira o código: 

<ul>
    <?php 
        if( have_rows('imagens') ):
        while ( have_rows('imagens') ) : the_row();
    ?>
    <li>
        <a href="<?php the_sub_field('imagem'); ?>" class="fancybox">
            <img src="<?php the_sub_field('imagem'); ?>" alt="Galeria de produtos" />
        </a>
    </li>
    <?php endwhile; endif; ?>
</ul>

2 - Pronto!


* Versão 0.0.1 - Modo inicial, testes e aplicação estão começando.


## Autores

* Isabela [Link](https://www.link)
* Diego Curuma [Link's'](https://www.github.com/diegocuruma, https://www.behance.net/diegocuruma)
* Jonas Sousa [Behance](https://www.behance.net/onasousa)

## Referências 

* [Sass](http://sass-lang.com/)
* [Compass](http://compass-style.org/)
* [Grunt](http://gruntjs.com/)
* [Normalize CSS](http://necolas.github.io/normalize.css/)
* [HTML5 Boilerplate](http://html5boilerplate.com/)
* [HTML5 Shiv](https://github.com/aFarkas/html5shiv)
