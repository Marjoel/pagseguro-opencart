<?php
// Heading
$_['heading_title']       				= 'Rede Pay';

// Text
$_['text_edit']                 		= 'Configuração do Rede Pay';
$_['text_payment']        				= 'Pagamento';
$_['text_success']        				= 'Sucesso: Você alterou com sucesso as configurações do módulo do Rede Pay!';
$_['text_redepay']						= '<a href="https://www.useredepay.com.br" target="_blank"><img src="view/image/payment/redepay.png" alt="Rede Pay" title="Rede Pay" /></a>';
$_['text_enabled']                 		= 'Habilitado';
$_['text_disabled']                 	= 'Desabilitado';
$_['text_edit_tokens']                 	= 'Códigos de segurança';
$_['text_edit_installments']            = 'Parcelamento';
$_['text_edit_notifications']           = 'Notificações';
$_['text_edit_redirects']           	= 'Redirecionamentos';
$_['text_edit_fields']           		= 'Campos';
$_['text_edit_order_status']           	= 'Situações';
$_['text_edit_settings']           		= 'Ativação';
$_['text_register']           			= '<a href="https://portal.useredepay.com.br/credenciamento/" target="_blank">Clique aqui</a> para realizar o seu cadastro no Rede Pay.';

// Entry
$_['entry_max_installments']         	= 'Quantidade de parcelas';
$_['entry_min_value_installment']       = 'Valor mínimo';
$_['entry_min_installment_value']       = 'Parcela mínima';
$_['entry_min_value_enable']       		= 'Valor mínimo';
$_['entry_api_key']         			= 'API key';
$_['entry_token_nip']         			= 'Token NIP';
$_['entry_public_token']         		= 'Public token';
$_['entry_status']        				= 'Situação';
$_['entry_sort_order']    				= 'Ordem';
$_['entry_notification_url']    		= 'URL de notificação';
$_['entry_redirect_url']    			= 'URL de redirecionamento';
$_['entry_cancel_url']    				= 'URL de cancelamento';
$_['entry_document']    				= 'CPF';
$_['entry_address']    					= 'Rua';
$_['entry_number']    					= 'Número';
$_['entry_complement']    				= 'Complemento';
$_['entry_neighborhood']				= 'Bairro';
$_['entry_phone']						= 'Telefone';
$_['entry_cellphone']					= 'Celular';
$_['entry_order_waiting_payment']		= 'Aguardando pagamento';
$_['entry_order_payment_analisys']		= 'Pagamento em análise';
$_['entry_order_approved_payment']		= 'Pagamento confirmado';
$_['entry_order_payment_dispute']		= 'Pagamento em disputa';
$_['entry_order_canceled_payment']		= 'Pedido cancelado';
$_['entry_order_reversed_payment']		= 'Pagamento estornado';
$_['entry_order_chargeback_payment']	= 'Pagamento contestado';

// Help
$_['help_max_installments']				= 'Quantidade máxima de parcelas que estará disponível para os clientes.';
$_['help_min_value_installment']		= 'Valor mínimo da compra para habilitar o parcelamento para o cliente. (Deixando em branco qualquer valor habilita o parcelamento)';
$_['help_min_installment_value']		= 'Valor mínimo das parcelas. (Deixando em branco não haverá valor mínimo para as parcelas)';
$_['help_min_value_enable']				= 'Valor mínimo de compra para ativar o Rede Pay. (Deixando em branco o Rede Pay estará sempre ativo)';
$_['help_api_key']						= 'A API Key pode ser encontrada no portal do vendedor do Rede Pay: https://portal.useredepay.com.br > configurações > chaves de segurança.';
$_['help_token_nip']					= 'O Token NIP pode ser encontrado no portal do vendedor do Rede Pay: https://portal.useredepay.com.br > configurações > chaves de segurança.';
$_['help_public_token']					= 'O Public token pode ser encontrado no portal do vendedor do Rede Pay: https://portal.useredepay.com.br > configurações > chaves de segurança.';
$_['help_notification_url']				= 'Recebimento da notificação de status de pedido.';
$_['help_redirect_url']					= 'O cliente é redirecionado para esta URL quando a compra é finalizada.';
$_['help_cancel_url']					= 'O cliente é redirecionado para esta URL quando o pagamento é cancelado.';
$_['help_document']						= 'Campo para CPF.';
$_['help_address']						= 'Campo para rua.';
$_['help_number']						= 'Campo para número.';
$_['help_complement']					= 'Campo para complemento.';
$_['help_neighborhood']					= 'Campo para bairro.';
$_['help_phone']						= 'Campo para telefone.';
$_['help_cellphone']					= 'Campo para celular.';
$_['help_order_waiting_payment']		= 'Quando o pagamento ainda não foi confirmado.';
$_['help_order_payment_analisys']		= 'Quando o comprador pagou mas a transação está sendo analisada.';
$_['help_order_approved_payment']		= 'Quando o pagamento foi confirmado.';
$_['help_order_payment_dispute']		= 'Quando o comprador abriu uma disputa.';
$_['help_order_canceled_payment']		= 'Quando o pedido for cancelado.';
$_['help_order_reversed_payment']		= 'Quando o valor da compra for devolvido para o comprador.';
$_['help_order_chargeback_payment']		= 'Quando o portador do cartão não reconheceu a compra e o valor for devolvido. (chargeback)';

// Error
$_['error_api_key']         			= 'O campo API key é obrigatório.';
$_['error_token_nip']         			= 'O campo Token NIP é obrigatório.';
$_['error_public_token']         		= 'O campo Public token é obrigatório.';
$_['error_notification_url']         	= 'O campo URL de notificação é obrigatório.';
$_['error_redirect_url']         		= 'O campo URL de redirecionamento é obrigatório.';
$_['error_cancel_url']         			= 'O campo URL de cancelamento é obrigatório.';
$_['error_document']         			= 'O campo CPF é obrigatório.';
$_['error_address']         			= 'O campo Rua é obrigatório.';
$_['error_number']         				= 'O campo Número é obrigatório.';
$_['error_neighborhood']         		= 'O campo Bairro é obrigatório.';
$_['error_cellphone']         			= 'O campo Celular é obrigatório.';
$_['error_permission']    				= 'Atenção: Você não possui permissão para modificar o módulo Rede Pay.';
?>
