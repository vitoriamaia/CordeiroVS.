# TEMA

## Títulos em campo repeater (Campo Repeater)?

Campo personalizado para adicionar campos no estilo de lista, e campo para campos com título e texto.


## Como aplica?

PARTE WP:

1 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.

2 - Pronto!

PARTE CÓD:

1 - Insira o código: 
## Exemplo de uso:


<ul class="blc-campos">
<?php
if( have_rows('adicionar_campos') ):
while ( have_rows('adicionar_campos') ) : the_row();
?>
    <li class="blc-campo-li">
    <?php the_sub_field('campo');?>
    </li>
<?php endwhile; endif; ?>
</ul>



<!-- campo e título -->
<dl class="blc-campos">
<?php
    if( have_rows('adicionar_campos_com_titulo') ):
    while ( have_rows('adicionar_campos_com_titulo') ) : the_row();
?>
<dt>
<h3><?php the_sub_field('titulo');?></h3>
</dt>

        <?php
                if( have_rows('campos_adicionais') ):
                while ( have_rows('campos_adicionais') ) : the_row();
        ?>    
        <dd>

                <?php the_sub_field('campo_adicional');?>


        </dd>
        <?php endwhile; endif; ?>

<?php endwhile; endif; ?>
</dl>



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
