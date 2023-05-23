# TEMA

## Upload de foto

Campo personalizado para adicionar foto no wordpress (Ex: Upload de foto lateral)

## Como aplica?

PARTE WP:

1 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.

2 - Pronto!

PARTE CÓD:

1 - Insira o código:
## Exemplo de uso:

<?php if(get_field('imagem') != '' ) : ?>
    <aside class="">
     <img src="<?php the_field('imagem');?>" class="">

    </aside>
    <?php else : ?>

<?php endif; ?>

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
