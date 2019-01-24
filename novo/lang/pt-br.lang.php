<?php
  /**
   * Arquivo de linguagem
   *
   * @package Sistema Divulgação Online
   * @author Geandro Bessa
   * @copyright 2013
   * @version 2
   */
   
  if (!defined("_VALID_PHP"))
      die('Acesso direto a esta classe não é permitido.');
?>
<?php

  //add your locale settings here
  function lang($phrase)
  {
      static $lang = array(

	  		'EMPRESA_NOME' => 'Damasceno Imóveis',
			'EMPRESA_TEL' => '(31) 3842-1003',
			'EMPRESA_WHATSAPP' => '(31) 9 8691 1004 (WhatsApp)',
			'EMPRESA_EMAIL' => 'jcdama@yahoo.com.br',
			'EMPRESA_ENDERECO' => 'Rua Maria Matos, 155-B - Centro <br> Coronel Fabriciano/MG CEP.: 35170-111',
	  
			/* == Tradução em Português Global  == */
			'INICIO' => 'Início',
			'SOBRE' => 'Empresa',
			'IMOVEIS' => 'Imóveis',
			'DETALHES' => 'Detalhes',
			'DETALHES_DO_IMOVEL' => 'Detalhes do Imóvel',
			'SIMULADOR_CAIXA' => 'Simulador Caixa',
			'SIMULADORES' => 'Simuladores',
			'FAQ' => 'FAQ',
			'CONTATO' => 'Contato',
			
			'TELEFONE' => 'Telefone',
			'EMAIL' => 'E-mail',
			'LINK_LOGIN_SISTEMA' => 'Sistema',
			
			/* == Atributos  == */
			'CIDADE_OU_BAIRRO' => 'Cidade ou Bairro',
			'DISP_PARA' => 'Disp. para',
			'TIPO' => 'Tipo',
			'VENDA' => 'Venda',
			'ALUGUEL' => 'Aluguel',
			'GARAGEM' => 'Garagem',
			'PISCINA' => 'Piscina',
			'SUITE' => 'Suíte',
			'QUARTO' => 'Quarto',
			'BANHEIRO' => 'Banheiro',
			'PRECO_MIN' => 'Preço Mínimo',
			'PRECO_MAX' => 'Preço Máximo',
			'PORTAO' => 'Portão Eletrônico',
			'ELEVADOR' => 'Elevador',			
			'CHURRASQUEIRA' => 'Churrasqueira',
			'ARMARIO' => 'Armários na cozinha',
			'GUARDA_ROUPA' => 'Guarda-Roupas',
			'APLICAR' => 'Aplicar',
			'PROCURAR' => 'Procurar',
			
			/* == Chamadas == */
			'APLICAR_FILTROS' => 'Aplicar Filtros',
			'ADICIONADO_RECENTEMENTE' => 'Adicionado Recentemente',
			'PERGUNTAS_FREQUENTES' => 'Perguntas Frequentes',
			'CARACTERISTICAS' => 'Características do Imóvel',
			'IMOVEIS_SIMILARES' => 'Imóveis Similares',
			
			/* == CONTATO FORM  == */
			'FALE_CONOSCO' => 'Fale Conosco',
			'SEU_NOME' => 'Nome',
			'SEU_EMAIL' => 'E-mail',
			'SEU_ASSUNTO' => 'Assunto',
			'SUA_MENSAGEM' => 'Mensagem',
			'ENVIAR_MSG' => 'Enviar Mensagem',
			
			/* == Outros  == */
			'SIM' => 'SIM',
			'NAO' => 'NÃO',
			'VOLTAR' => 'Voltar',
			'LINKS_RAPIDOS' => 'Links Rápidos',
			'TODOS_OS_IMOVEIS' => 'Todos os Imóveis',
			'ENCONTRE_SEU_CORRETOR' => 'Encontre seu corretor',
			'FALE_COM_A_GENTE' => 'Fale com a gente',
			
			/* == Admin Mensagens de Erro  == */
			'MSG_PADRAO' => 'Campo inválido',			
			'MSG_ERRO_IMOVEIS' => 'Nenhum imóvel encontrado na pesquisa.',	
			'MSG_ERRO_NOME' => 'O campo NOME é obrigatório.',
			'MSG_ERRO_TEL' => 'O campo TELEFONE é obrigatório.',	
			'MSG_ERRO_ENDERECO' => 'O campo ENDEREÇO é obrigatório.',	
			'MSG_ERRO_BAIRRO' => 'O campo BAIRRO é obrigatório.',	
			'MSG_ERRO_CIDADE' => 'O campo CIDADE é obrigatório.',	
			'MSG_ERRO_FORMA_PAG' => 'O campo FORMA DE PAGAMENTO é obrigatório.',
			
			'MSG_ERRO_GENERICO' => 'Ocorreu um ou mais erros ao processar a solicitação'
	  );
      
	  return $lang[$phrase];
  }
?>
