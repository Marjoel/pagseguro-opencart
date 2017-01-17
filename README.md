[<p align="center"><img src="https://stc.useredepay.com.br/portal/assets/institucional/img/logo.svg" width="90%"/></p>](https://www.useredepay.com.br "Rede Pay")

<p align="center">Módulo de pagamento para a plataforma de e-commerce Opencart</p>

```Importante! Este módulo é opensource e não possui vínculo com a Rede ou Itaú.```

### Instalação
1. Faça download da versão estável do módulo através do site oficial do Opencart, [clique aqui](https://www.opencart.com/index.php?route=marketplace/extension/info&extension_id=28757 "Rede Pay").
1. Descompacte o arquivo ```.zip``` que foi baixado.
1. Copie o conteúdo da pasta ```upload``` (referente a sua versão) para a pasta onde o Opencart estiver instalado.
1. Vá ao painel de administração do Opencart e ative/configure o módulo Rede Pay.

### Notas & Compatibilidade

| Versão | Notas | Compatibilidade |
| ------ | ----- | --------------- |
| 1.4    | Adicionando compatibilidade com outras versões do Opencart. | 2.0.X, 2.1.X, 2.2.X, 2.3.X |
| 1.3.2  | Resolvendo bug que acontecia no momento do callback, os dados vem do body não da url. | 2.0.X, 2.1.X, 2.2.X |
| 1.3.1  | Resolvendo bug que acontecia no momento da primeira entrada na página de checkout, o número do pedido ainda não havia sido criado. | 2.0.X, 2.1.X, 2.2.X |
| 1.3    | Organizando melhor os campos no painel de configuração, tornando os campos de telefone e complemento opcionais, adicionando valor mínimo para ativar o parcelamento, adicionando valor mínimo para as parcelas, e adicionando valor mínimo para ativar o módulo. | 2.0.X, 2.1.X, 2.2.X |
| 1.2    | Adicionando compatibilidade com outras versões do Opencart. | 2.0.X, 2.1.X, 2.2.X |
| 1.1    | Melhorias nos textos na seção de configuração do módulo. | 2.0.1.1 |
| 1.0    | Integração com as APIs de pagamento e notificação. | 2.0.1.1 |

## To dos

- [ ] Integração com a API de estorno, estornar valor do pedido direto do admin.
- [ ] Integração com a API de código de rastreio, adicionar e remover código de rastreio direto do admin.
- [ ] Adicionar funcionalidade de oferecer desconto quando o Rede Pay for escolhido como forma de pagamento.

## Contribua

Faça um fork do repositório, realize suas alterações e [crie um pull request](https://github.com/Marjoel/redepay-opencart/pulls "Clique aqui para criar um pull request").<br>
Você está tendo algum problema com o módulo? [crie uma issue](https://github.com/Marjoel/redepay-opencart/issues "Clique aqui para criar uma issue").

### Contribuidores

[Marjoel Moreira](https://www.marjoel.com/ "Marjoel Moreira") (@[MarjoeM](https://www.twitter.com/MarjoelM "Twitter"))
