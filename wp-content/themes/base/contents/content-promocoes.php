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
      
        <ul class="acess">
          <a href="javascript:mudaTamanho('texto', -1);">A-</a>
          <a href="javascript:mudaTamanho('texto', 1);">A+</a>
          <a href="javascript:history.back();">Voltar</a>
        </ul>
        
          <div class="promo">
          <?php the_post_thumbnail();?>
          </div>
      
        <ul class="acess2">
          <a href="javascript:linktop;">Voltar</a>
          <a href=""> Topo</a>
        </ul>
    </div>
  </div>
</div>
</div>
  



