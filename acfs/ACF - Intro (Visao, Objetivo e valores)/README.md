# TEMA

## Introdução na Pagina

Quando ouver necessidade de criar uma pagina com Missão, Valores e etc

## Como aplica?

PARTE WP:

1 - Em ferramentas -> importar -> wordpress voce vai xamar o ACF - Intro que está na pasta originais.

2 - Verifique se está nos campos personalizados, após isso voce diz quais páginas quer aplicar.3

3 - Pronto!

PARTE CÓD:

1 - Insira o código: 
<section class="cem cf seja">
     <div class="grid cf" style="background:#">
       <header class="tits">
           <h2 class="tit-nivel2">Seja bem vindo</h2> 
       </header>
        <?php
            $Query = new WP_Query( array('page_id' => 10));
            while ( $Query -> have_posts() ) : $Query-> the_post();
        ?>


       <article class="intro pure-u-1 pure-u-md-18-24" style="background:#">   	               
       <p><?php echo limit(get_the_content(),350); ?> </p>
       </article>


        <?php endwhile; wp_reset_query(); ?>	
        <div class="pure-g">								
            <article class="pure-u-1 pure-u-md-8-24 pure-u-sm-12-24" style="background:#">                
                <div class="l-box">
                    <h2 class="tit-nivel3">Missão</h2>                    
                    <p><?php the_field('missao') ;?></p>
                </div>
            </article>

            <article class="pure-u-1 pure-u-md-8-24 pure-u-sm-12-24" style="background:#">
                <div class="l-box">
                <h2 class="tit-nivel3">Objetivos</h2>                    
                <p><?php the_field('objetivos') ;?></p>
                </div>
            </article>

            <article class="pure-u-1 pure-u-md-8-24 pure-u-sm-12-24" style="background:#">
                <div class="l-box">                        
                <h2 class="tit-nivel3">Valores</h2>                    
                <p><?php the_field('valores') ;?></p>
                </div>				    
            </article>
         </div>  
     </div>
</section>


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
