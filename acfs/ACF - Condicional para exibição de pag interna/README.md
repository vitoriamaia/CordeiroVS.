# TEMA

## Condicional de pagina

Quando ouver necessidade de criar página com possibilidade de haver ou nao pag interna.

## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai xamar o ACV que está na pasta originais.

2 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.

3 - Pronto!

PARTE CÓD:

1 - Insira o código:

<li>
<?php if(get_field('detalhes') != '' ) : ?>
<a href="" title="<?php the_title(); ?>">
    <?php the_post_thumbnail('post', array('class' => 'pure-img')); ?>
</a>
<?php else: ?>
    <?php the_post_thumbnail('post', array('class' => 'pure-img')); ?>
<?php endif;?>

</li>


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
