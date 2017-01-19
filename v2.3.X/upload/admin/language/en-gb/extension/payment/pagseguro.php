<?php
// Heading
$_["heading_title"]       				= "PagSeguro";

// Text
$_["text_edit"]                 		= "Configuração do PagSeguro";
$_["text_payment"]        				= "Pagamento";
$_["text_success"]        				= "Sucesso: Você alterou com sucesso as configurações do módulo do PagSeguro!";
$_["text_pagseguro"]					= "<a href=\"https://pagseguro.uol.com.br/\" target=\"_blank\"><img src=\"view/image/payment/pagseguro.png\" alt=\"PagSeguro\" title=\"PagSeguro\" /></a>";
$_["text_enabled"]                 		= "Habilitado";
$_["text_disabled"]                 	= "Desabilitado";
$_["text_edit_tokens"]                 	= "Códigos de segurança";
$_["text_edit_notifications"]           = "Notificações";
$_["text_edit_redirects"]           	= "Redirecionamentos";
$_["text_edit_freight"]           		= "Frete";
$_["text_edit_fields"]           		= "Campos";
$_["text_edit_order_status"]           	= "Situações";
$_["text_edit_settings"]           		= "Ativação";
$_["text_register"]           			= "<a href=\"https://pagseguro.uol.com.br/registration/registration.jhtml?tipo=cadastro#!vendedor\" target=\"_blank\">Clique aqui</a> para realizar o seu cadastro no PagSeguro.";
$_["text_support"]           			= "<a href=\"https://github.com/Marjoel/pagseguro-opencart/issues\" target=\"_blank\">Clique aqui</a> se você tiver problemas ou sugestões de melhoria neste módulo.";
$_["text_freight_store"]           		= "Frete calculado pela loja.";
$_["text_freight_pac"]           		= "Frete calculado pelo PagSeguro usando PAC.";
$_["text_freight_sedex"]           		= "Frete calculado pelo PagSeguro usando Sedex.";
$_["text_freight_pac_sedex"]           	= "Frete calculado pelo PagSeguro usando PAC ou Sedex, de acordo com a escolha do cliente.";

// Entry
$_["entry_min_value_enable"]       		= "Valor mínimo";
$_["entry_token"]         				= "Token de Segurança";
$_["entry_email"]         				= "E-mail";
$_["entry_status"]        				= "Situação";
$_["entry_sort_order"]    				= "Ordem";
$_["entry_notification_url"]    		= "URL de notificação";
$_["entry_redirect_url"]    			= "URL de redirecionamento";
$_["entry_cancel_url"]    				= "URL de cancelamento";
$_["entry_freight"]    					= "Cálculo do frete";
$_["entry_document"]    				= "CPF";
$_["entry_address"]    					= "Rua";
$_["entry_number"]    					= "Número";
$_["entry_complement"]    				= "Complemento";
$_["entry_neighborhood"]				= "Bairro";
$_["entry_cellphone"]					= "Celular";
$_["entry_order_waiting_payment"]		= "Aguardando pagamento";
$_["entry_order_payment_analisys"]		= "Pagamento em análise";
$_["entry_order_approved_payment"]		= "Pagamento confirmado";
$_["entry_order_payment_dispute"]		= "Pagamento em disputa";
$_["entry_order_canceled_payment"]		= "Pedido cancelado";
$_["entry_order_reversed_payment"]		= "Pagamento estornado";
$_["entry_order_chargeback_payment"]	= "Pagamento contestado";

// Help
$_["help_min_value_enable"]				= "Valor mínimo de compra para ativar o PagSeguro. (Deixando em branco o PagSeguro estará sempre ativo)";
$_["help_token"]						= "O Token de Segurança pode ser encontrado no portal do vendedor do PagSeguro: https://pagseguro.uol.com.br > minha conta > preferência > integrações > utilização de apis > gerar token.";
$_["help_email"]						= "E-mail da conta do PagSeguro.";
$_["help_notification_url"]				= "Recebimento da notificação de status de pedido. Cadastre esse endereço no portal do vendedor do PagSeguro: https://pagseguro.uol.com.br > minha conta > preferência > integrações > utilização de apis > notificação de transação.";
$_["help_redirect_url"]					= "O cliente é redirecionado para esta URL quando a compra é finalizada. Cadastre esse endereço no portal do vendedor do PagSeguro: https://pagseguro.uol.com.br > minha conta > preferência > integrações > página de redirecionamento.";
$_["help_cancel_url"]					= "O cliente é redirecionado para esta URL quando o pagamento é cancelado.";
$_["help_freight"]						= "Nas configurações de frete da loja, se o cálculo for feito pela loja configure a opção frete fixo, caso contrário configure a opção frete por peso para que o PagSeguro faça o cálculo.";
$_["help_document"]						= "Campo para CPF.";
$_["help_address"]						= "Campo para rua.";
$_["help_number"]						= "Campo para número.";
$_["help_complement"]					= "Campo para complemento.";
$_["help_neighborhood"]					= "Campo para bairro.";
$_["help_cellphone"]					= "Campo para celular.";
$_["help_order_waiting_payment"]		= "Quando o pagamento ainda não foi confirmado.";
$_["help_order_payment_analisys"]		= "Quando o comprador pagou mas a transação está sendo analisada.";
$_["help_order_approved_payment"]		= "Quando o pagamento foi confirmado.";
$_["help_order_payment_dispute"]		= "Quando o comprador abriu uma disputa.";
$_["help_order_canceled_payment"]		= "Quando o pedido for cancelado.";
$_["help_order_reversed_payment"]		= "Quando o valor da compra for devolvido para o comprador.";
$_["help_order_chargeback_payment"]		= "Quando o portador do cartão não reconheceu a compra e o valor for devolvido. (chargeback)";

// Error
$_["error_token"]         				= "O campo Token de Segurança é obrigatório.";
$_["error_email"]         				= "O campo E-mail é obrigatório.";
$_["error_notification_url"]         	= "O campo URL de notificação é obrigatório.";
$_["error_redirect_url"]         		= "O campo URL de redirecionamento é obrigatório.";
$_["error_cancel_url"]         			= "O campo URL de cancelamento é obrigatório.";
$_["error_document"]         			= "O campo CPF é obrigatório.";
$_["error_address"]         			= "O campo Rua é obrigatório.";
$_["error_number"]         				= "O campo Número é obrigatório.";
$_["error_neighborhood"]         		= "O campo Bairro é obrigatório.";
$_["error_cellphone"]         			= "O campo Celular é obrigatório.";
$_["error_permission"]    				= "Atenção: Você não possui permissão para modificar o módulo PagSeguro.";
?>
