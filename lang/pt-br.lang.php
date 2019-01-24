<?php
  /**
   * Arquivo de linguagem
   *
   * @package Sistemas Folha do Comércio
   * @author Geandro Bessa
   * @copyright 2013
   */
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');
?>
<?php

  //add your locale settings here
  function lang($phrase)
  {
      static $lang = array(
	  
			/* == Dados da Empresa  == */
			'NOME_EMPRESA' => 'João Damasceno Imóveis',
			'TELEFONE_EMPRESA' => '(31) 3842-1003',
			'ENDERECO_EMPRESA' => 'Rua Maria Matos, 155-B - Centro<br/>Coronel Fabriciano/MG<br/>CEP.: 35170-001<br/>',
			'EMAIL_EMPRESA' => 'jcdama<br/>@yahoo.com.br',
			'EMAIL2_EMPRESA' => 'jcdama@yahoo.com.br',
			'GPS_EMPRESA' => '-19.5063074<br/>-42.570710599999984',
			
			/* == Tradução em Português Global  == */
			'VENDA_AQUI' => 'Vendemos seu imóvel',
			'WEBMAIL' => 'webmail',
			'SISTEMA' => 'sistema',
			'PORTUGUES' => 'Português',			
			'FALECONOSCO' => 'Fale Conosco',
			'ENVIEMENSAGEM' => 'Envie uma mensagem',
			'CAMPOOBRIGATORIO' => 'Campo Obrigatório.',
			'NOME' => 'Nome',
			'EMAIL' => 'E-mail',
			'MENSAGEM' => 'Mensagem',
			'ENVIAR' => 'Enviar',
			'ENDERECO' => 'Endereço',
			'TELEFONE' => 'Telefone',
			'GPS' => 'GPS',
			'MAISRECENTES' => 'Mais Recentes',
			'ULTIOMSIMOVEIS' => 'Últimos Imóveis',
			'PERGUNTASFREQUENTES' => 'Perguntas Frequentes',
			'CONTATO' => 'Contato',
			'INFORMACOES' => 'Informações',
			'REMOVER' => 'Remover',
			'ALTERAR' => 'Alterar',
			'IMAGEM' => 'Imagem',
			'PRECO' => 'Preço',
			'AREA' => 'Área',
			'BANHEIROS' => 'Banheiros',
			'QUARTOS' => 'Quartos',
			'ALUGUEL' => 'Aluguel',
			'VENDA' => 'Venda',
			'ULTIMONOME' => 'Último Nome',
			'PRIMEIRONOME' => 'Primeiro Nome',
			'LEIAMAIS' => 'Leia Mais',
			'ATENDIMENTO' => 'Atendimento',
			'DESTAQUES' => 'Destaques',
			'ANTERIOR' => 'Anterior',
			'PROXIMO' => 'Próximo',
			'NOSSOSIMOVEIS' => 'Nossos Imóveis',
			'TIPO' => 'Tipo',	
			'PAGINANAOENCONTRADA' => 'Página não encontrada.',
			'MENSAGEMPAGINANAOENCONTRADA' => 'Desculpe-nos, use o campo de pesquisa ou <a href="index.php">retorne a página principal</a>',
			'DETALHES' => 'Detalhes',
			'OPERACAO' => 'Operação',
			'CARACTERISTICASIMOVEL' => 'Características do Imóvel',
			'SUITES' => 'Suítes',
			'GARAGEM' => 'Garagem',
			'PISCINA' => 'Piscina',
			'CHURRASQUEIRA' => 'Churrasqueira',
			'ELEVADOR' => 'Elevador',
			'PORTAOELETRONICO' => 'Portão Eletrônico',
			'ARMARIOSCOZINHA' => 'Armários na cozinha',
			'GUARDAROUPAS' => 'Guarda-Roupas',
			'POSSUI' => 'Possui',
			'NAOPOSSUI' => 'Não possui',
			'LEGENDA' => 'Legenda',
			'OUTROSIMOVEIS' => 'Outros Imóveis',
			'RELACAOIMOVEIS' => 'Relação de Imóveis',
			'MAIORPRIMEIRO' => 'Maior Primeiro',
			'MENORPRIMEIRO' => 'Menor Primeiro',
			'BAIRRO' => 'Bairro',
			'SELECIONE' => 'Selecione',
			'FILTRARIMOVEIS' => 'Filtrar Imóveis',
			'CIDADE' => 'Cidade',
			'SELECIONECIDADE' => 'Selecione uma cidade',
			'SELECIONEBAIRRO' => 'Selecione um bairro',
			'PREV' => 'Anterior',
			'GOTO' => 'Ir Para',
			'OF' => 'de',
			'NEXT' => 'Próximo',
			'CONTATO' => 'Contato',
			'CONTATO' => 'Contato',
			'CONTATO' => 'Contato',
			
			/* == Tradução do Menu  == */
			'HOME_MENU' => 'Home',
			'EMPRESA_MENU' => 'Empresa',
			'IMOVEIS_MENU' => 'Imóveis',
			'DICAS_MENU' => 'Dúvidas Frequentes',
			'SIMULADORES_MENU' => 'Simuladores',
			'CAIXA_MENU' => 'Caixa Econômica Federal',
			'BB_MENU' => 'Banco do Brasil',
			'ITAU_MENU' => 'Itaú',
			'CONTATO_MENU' => 'Contato',
			
			/* == Tradução do Links  == */
			'TITULO_LINKS' => 'Links Úteis',
			'INQUILIANTO_LINKS' => 'Lei do Inquilinato',
			'CIVIL_LINKS' => 'Código Civil',
			'CONSUMIDOR_LINKS' => 'Código do Consumidor',
			'CORRETORES_LINKS' => 'Conselho dos Corretores de Imóveis',
			'CREA_LINKS' => 'CREA-MG',
			'RECEITA_LINKS' => 'Receita Federal',
			'CONDOMINIO_LINKS' => 'Lei dos Condomínios',
			
			/* == Tradução do Vendemos seu Imóvel  == */
			'BUSCARARQUIVO' => 'Buscar Arquivo',
			'ENVIARIMAGEM' => 'Enviar Imagem',
			'TIPOOPERACAO' => 'Tipo da Operação',
			'TIPOIMOVEL' => 'Tipo do Imóvel',
			'INFPESSOAL' => 'Informações Pessoais',
			'PREENCHAFORMULARIO' => 'Se você é proprietário, utilize nossos serviços para venda do seu imóvel. Envie os dados do seu imóvel, utilizando o formulário abaixo.',
			'INFIMOVEL' => 'Informações do Imóvel',
			'IMAGEMIMOVEL' => 'Imagem do Imóvel',
			
			/* == Tradução do Home  == */
			'ENCONTRESEUIMOVEL' => 'Encontre seu Imóvel',
			'DESC_ENCONTRESEUIMOVEL' => 'Conheça a nossa lista de imóveis em todo o Vale do Aço. O imóvel que você deseja para morar ou investir, lançamentos, salas comerciais.',
			'SOLICITESEUIMOVEL' => 'Solicite seu Imóvel',
			'DESC_SOLICITESEUIMOVEL' => 'Se você não encontrou o imóvel que procura, nossa equipe pode auxiliar nesta busca. Envie uma descrição do imóvel que nós localizamos para você.',
			'SOBREIMOVEIS' => 'Mais sobre Imóveis',
			'DESC_SOBREIMOVEIS' => 'Esclareça suas dúvidas sobre finaciamentos, consórcios imobiliários, impostos, documentos, como comprar, como vender.',
	  );
      
	  return $lang[$phrase];
  }
?>