ValorFreteCorreios: Shipping value on Brazil. Next readme is only in portuguese

Esta é uma classe escrita em PHP de apoio a obter dados do correio eu seu site.
Ela requer PHP 5.3

Guia rápido de uso:
    include_once '../library/ValorFreteCorreios.php';
    $correio = new ValorFreteCorreios;
	$correio->origem( '90650000' )->destino( '86010060' )->json( ); //Imprime JSON

Veja a pasta /doc/ para maiores explicações.


Destaques
    - Fluent Interface (chaning method). Faz muito em apenas uma linha de código
	- Pode retorna a saida e imprime em tela nos formatos XML e JSON; 
	- Pode retornar a saida meramente em um objeto
	
Conteudo deste pacote
readme.txt (descrição da classe)
/doc/
	SCPP_manual_implementacao_calculo_remoto_de_precos_e_prazos.pdf (Guia oficial fornecido pelos Correios do Brasil)
	Documentacao.txt (Documetacao da classe)		
/library/
	ValorFreteCorreios.php ( A classe propriamente dita )
/tests/
		* ( Arquivos com exemplos de uso )		

-----------------------  Changelog  ------------------------

2011-08-23: 0.5beta1


CHANGELOG LEGEND:
+ Added
- Removed
^ Updated
* Bugfix
# Security Fix
! Relevant message
