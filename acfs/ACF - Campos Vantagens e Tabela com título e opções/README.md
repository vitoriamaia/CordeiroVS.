# TEMA

## Para que serve?

Quando ouver necessidade de criar páginas com itens para adicionar em loop e quando tiver titulo e sub titulos

## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai xamar o ACF - Tabela com título e opções que está na pasta originais.

2 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.


4 - Pronto!

PARTE CÓD:

<!-- detalhes -->
<div class="pure-u-md-8-24 pure-u-1 l-box">
	<header>
		<h2 class="tit-nivel3">DETALHES</h2>
		<h3 class="tit-nivel4">Dimensões Externas</h3>
	</header>

	<dl class="dest-vant pure-u-1">
	<!-- loop para dimensões -->
		<?php
        if( have_rows('dimensoes') ):
        while ( have_rows('dimensoes') ) : the_row();
    ?>
			<dt class="pure-u-md-12-24"><?php the_sub_field('titulo');?></dt>

			<dd class="pure-u-md-5-24"><?php the_sub_field('subtitulo');?></dd>
  	<?php endwhile; endif; ?>
	</dl>
</div>


<!-- loop para descrição completa e descritivo técnico  -->
<?php
//verifica se o campo existe
if( have_rows('destaques') ):

// faz um loop pelo sub-campos
while ( have_rows('destaques') ) : the_row();
?>
	<!--  loop para descrição completa-->
  <article class="pure-u-md-24-24 pure-u-1 destaque">
		  <h2 class="tit-nivel3">Descrição completa</h2>
      <!--  campos de destaques-->
      <ul class="dest-vant pure-u-1">
				<?php
            if( have_rows('descricao') ):
            while ( have_rows('descricao') ) : the_row();
        ?>
        <li><?php the_sub_field('titulo');?></li>
      	<?php endwhile; endif; ?>
      </ul>
  </article>

	<!-- comum ao 20gp e 40gp -->
	<article class="pure-u-md-24-24 pure-u-1 destaque">
		<header>
			<h2 class="tit-nivel3">Descritivo Técnico</h2>
			<h3 class="tit-nivel4">Comum tanto ao 20gp (6m) quanto ao 40gp (12m)</h3>
		</header>
      <!-- campos comuns -->
      <ul class="dest-vant pure-u-1">
				<?php
            if( have_rows('comum') ):
            while ( have_rows('comum') ) : the_row();
        ?>
          <li><?php the_sub_field('titulo');?></li>
					<?php endwhile; endif; ?>
      </ul>
  </article>
<?php endwhile; endif; ?>

<!--  descritivos tecnicos-->
<div class="pure-u-md-12-24 pure-u-1 l-box" >
<h3 class="tit-nivel4">Dimensões Externas Padrão</h3>

<dl class="dest-vant pure-u-1" >
	<?php
			//loop para descritivo
			if( have_rows('descritivo') ):
			while ( have_rows('descritivo') ) : the_row();
	?>
		<dt class="pure-u-md-13-24" >
			<?php the_sub_field('titulo');?>
		</dt>

		<dd class="pure-u-md-5-24">
			<strong>20pés</strong><br>
			<?php the_sub_field('vinte');?>
		</dd>

		<dd class="pure-u-md-5-24">
			<strong>40pés</strong><br>
			<?php the_sub_field('quarenta');?>
		</dd>
<?php endwhile; endif; ?>
</dl>
</div>


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
