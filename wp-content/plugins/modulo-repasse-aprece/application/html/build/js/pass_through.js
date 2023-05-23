function comprova_extensao(formulario, arquivo) { 
   extensoes_permitidas = new Array(".csv"); 
   meuerro = ""; 
   if (!arquivo) { 
      //Se não tenho arquivo, é porque não se selecionou um arquivo no formulário. 
      	meuerro = "Nenhum arquivo foi selecionado!"; 
   } else { 
      //recupero a extensão deste nome de arquivo 
      extensao = (arquivo.substring(arquivo.lastIndexOf("."))).toLowerCase(); 
      //alert (extensao); 
      //comprovo se a extensão está entre as permitidas 
      permitida = false; 
      for (var i = 0; i < extensoes_permitidas.length; i++) { 
         if (extensoes_permitidas[i] == extensao) { 
         permitida = true; 
         break; 
         } 
      }
      
      if (!permitida) {
         meuerro = "Só é permitido subir arquivos com \nextensão: " + extensoes_permitidas.join();
      } else { 
      		// alert('Seu arquivo é '+arquivo);
      		if(document.getElementById("tipo").value == 0){
      			meuerro = "Selecione um tipo de repasse!";
      		} else {
      			jQuery('#form-repasse').submit();
	      		return 1;
      		}
      	} 
   } 
   //se estou aqui é porque não se pode submeter 
   alert (meuerro); 
   return 0; 
}