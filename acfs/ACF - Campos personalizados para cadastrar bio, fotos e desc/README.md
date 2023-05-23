# TEMA

## Destaque ná Página repeater (Campo Repeater)

Campos personalizados para cadastrar bio, fotos e desc


## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai xamar o ACF - Destaque de Página que está na pasta originais. 

2 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.


3 - Pronto!

PARTE CÓD:

1 - Insira o código: 

<ul class="">
<?php 

//verifica se o campo existe
if( have_rows('campo_texto') ):

// faz um loop pelo sub-campos
while ( have_rows('campo_texto') ) : the_row();

?>

<li class="pure-u-1 pure-u-md-6-24 pure-u-sm-10-24" style="background:#">
<div class="pure-u-md-1-1"> 
<img src="<?php the_sub_field('foto'); ?>">
</div>
<strong class=""><?php the_sub_field('nome'); ?></strong>
<p>
<?php echo the_sub_field("texto");?>                  
</p>   

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
