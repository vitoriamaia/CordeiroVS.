ToolKit Plugin WP
====================

Descrição
---------
Esse projeto é um conjunto de ferramentas para desenvolvedores PHP. 
Ele contém as mais variadas funções para customização do projeto.

Instalação
----------
Para usá-lo basta colocar o plugin na pasta wp-content/plugins e depois
ativá-lo no administrador.

Modo de Uso
-----------
- Ative o plugin 
- Use as funções estáticas onde precisar:
```php
	echo TK_Convert::month2Nom(2);
	// Retorna Fevereiro
	
	echo TK_Convert::val_am2br(1000.99);
	// Retorna 1.000,99
```  
