# TEMA

## Para que serve o Linkd (Campo Repeater)?

Quando ouver necessidade de criar uma pagina com Titulo e lista de Links.

## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai xamar o ACF - Campo Repetidor (LINKS) que está na pasta originais.

2 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.3
4 - Pronto!

PARTE CÓD:

1 - Insira o código: 


<!--<dl class="links">
<?php 

    //verifica se o campo existe
    if( have_rows('campo') ):

    // faz um loop pelo sub-campos
    while ( have_rows('campo') ) : the_row();

    ?>
    <!-- titulo do link -->
    <dt class="tit-links">             
    <?php the_sub_field('titulo'); ?>
    </dt>
    <?php 
        //for dos links
        $link = get_sub_field('link');

        $limit = count($link); 

        for($z=0; $z<=$limit; $z++){ 
    ?>

    <!-- link's -->
    <dd class=txt-links>
      <a href="<?php echo $link[$z]["link_url"]?>" target="_blank">
       <?php
       echo $link[$z]["link_repeater"]; 
       ?>
       </a>                    
    </dd> 

   <?php } ?>

    <?php endwhile;

    else :
       // no rows found
    endif;

?>                                  
</dl>-->

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
