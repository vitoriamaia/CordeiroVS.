
<script type="text/javascript">
// Início do código de Aumentar/ Diminuir a letra
 
// Para usar coloque o comando:
// "javascript:mudaTamanho('tag_ou_id_alvo', -1);" para diminuir
// e o comando "javascript:mudaTamanho('tag_ou_id_alvo', +1);" para aumentar
 
var tagAlvo = new Array('p'); //pega todas as tags p//
 
// Especificando os possíveis tamanhos de fontes, poderia ser: x-small, small...
var tamanhos = new Array( '12px','13px','14px','15px' );
var tamanhoInicial = 2;
 
function mudaTamanho( idAlvo,acao ){
if (!document.getElementById) return
var selecionados = null,tamanho = tamanhoInicial,i,j,tagsAlvo;
tamanho += acao;
if ( tamanho < 0 ) tamanho = 0;
if ( tamanho > 6 ) tamanho = 6;
tamanhoInicial = tamanho;
if ( !( selecionados = document.getElementById( idAlvo ) ) ) selecionados = document.getElementsByTagName( idAlvo )[ 0 ];
 
selecionados.style.fontSize = tamanhos[ tamanho ];
 
for ( i = 0; i < tagAlvo.length; i++ ){
tagsAlvo = selecionados.getElementsByTagName( tagAlvo[ i ] );
for ( j = 0; j < tagsAlvo.length; j++ ) tagsAlvo[ j ].style.fontSize = tamanhos[ tamanho ];
}
}
// Fim do código de Aumentar/ Diminuir a letra
function goBack() {
    window.history.back();
}
$('linktop').click(function(){
    $('html,body').animate({
        scrollTop:0
        },500);
})
</script>
<div id="oi">
  <div class="headi">
    <div class="head2"id="texto">
      <h3><i class="fas fa-angle-down"></i>
      </h3>
        <ul class="acess">

          <a href="javascript:history.back();">Voltar</a>
        </ul>
        <div class="container">
                <div class="col-md-12">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <section class="contato">
                            <?php the_content(); ?>
                        </section>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                    <iframe src="https://www.google.com/maps/d/embed?mid=1XmEUKt3L6tLU2vIUTKk8RedSh-U" width="375" height="360"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <ul class="acess2">
          <a href="javascript:linktop;">Voltar</a>
          <a href=""> Topo</a>
        </ul>
    </div>
  </div>
</div>
</div>
    <section class=" col-md-12">
        <div class="row">
            
    </section>
    



 




