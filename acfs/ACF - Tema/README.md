# TEMA

## Para que serve o Tema?

Quando ouver necessidade de criar páginas iguais mas com cores, tamanhos e fontes diferentes.

## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai xamar o ACV que está na pasta originais.

2 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.

3 - Após escolhido o local de uso, vá na página e escolha o tema!

4 - Pronto!

PARTE CÓD:

1 - Insira o código: | <?php the_field('cor_do_tema'); ?> | onde voce quer utilizar, isso vai puxar a id da cor do tema que voce escolheu.

2 - Veja o exemplo de como personalizar: https://gist.github.com/diegocuruma/86e5787d5e33dd5a1f64

/*
$ids: 'Blue', 'Green', 'Purple';
$cores: red, yellow, gray;
$cores2: orange, white, black;
 
$tema: zip($ids,$cores, $cores2);
 
@each $elemento in $tema {
  
    ##{nth($elemento, 1)} {
          .bloc-2{
            background:#{nth($elemento, 2)};
            }

            .bloc-3{
            background:#{nth($elemento, 3)};  
            }
            .bloc-4{
            background:#{nth($elemento, 2)};
            }

        }
}


*/


3 - Personalize!

4 - Pronto!


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
