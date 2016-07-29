# Evolutto Restful API - informações gerais

A plataforma Evolutto está em constante evolução e fornece meios para integração através de sua API.

Novos serviços (endpoints) são criados constantemente. Seu acesso é controlado primariamente
através das credenciais de sua organização:

- **{{clientId}}** - obrigatório em todas as requisições. Sempre como parte da URL do endpoint 
- **{{api_secret}}** - obrigatório na maioria das requisições. Enviado através do corpo de POST ou no HEADER HTTP das requisições.

As credenciais acima são fornecidas pela plataforma Evolutto.


# Endpoints

A URL base é **http://acesso.evolutto.com.br** para todos os endpoints. 

### `GET /api/v1/{{clientId}}/produtos-disponiveis.json`

Obtem lista dos produtos disponiveis para a sua Organização.

* Parâmetros:** `{{clientId}} [string]` - ID do cliente da API fornecido pela Evolutto (obrigatório)
* Resposta:


Exemplo de chamada em HTTP puro:

```  
GET /api/v1/d1885da7474cc37a39aff2573d607d71/produtos-disponiveis.json HTTP/1.1
Host: acesso.evolutto.com.br
Content-Type: application/json; charset=utf-8
```  



Em caso de **sucesso (status 200)**, será gera um documento JSON contendo as informações sobre os produtos. Exemplo:

```json
            [
              {
                "id": 334,
                "nome": "SGQv6.0 - SISTEMA DE GESTÃO DA QUALIDADE - ISO9001:2015",
                "nick": "ISO 9001 v6"
              },
              {
                "id": 352,
                "nome": "PBQP-H v2",
                "descricao_html": "0",
                "nick": "PBQP-H v2"
              }
            ]
```

Em caso de **falha (status 401)**:
  
```json
            [
                {
                    "message":"Client n\u00e3o autorizado a acessar API"
                }
            ]
```
        





### `POST /api/v1/{{clientId}}/novo-cliente.json`

Cria um novo conjunto **EMPRESA + USUARIO + CONTRATO**. 

#### Definições gerais

Os **contratos** de consultoria sempre estão vinculados à uma **empresa (ou pessoa física)**. 
A plataforma é acessada por **usuários** através de seus dados de acesso (username e senha). 
Todos os usuários ficam vinculados à **empresa** e ao **contrato**.

Ao fazer uma requisição para criação de um novo **cliente + contrato + usuario**, os dados 
das entidades a serem criadas ficam envelopados dentro da propriedade **data** do documento JSON.

Observe que os três tipos de entidade mencionados acima (empresa, usuário e contratos) ocorrem como propriedades raizes dentro de **data**.
 
Note também que é possível criar múltiplos contratos para cada cliente. 
Em cada contrato é possível criar múltiplas anotações e em cada anotação é possível anexar múltiplos arquivos.


**Exemplo de requisição HTTP**

O corpo da requisição deve conter as informações codificadas como um documento JSON:

```
POST /{{ api_version }}/{{ api_client_id }}/novo-cliente.json HTTP/1.1
Host: {{ url_base }}
Content-Type: application/json; charset=utf-8
Cache-Control: no-cache

{
   "api_secret":"{{ api_secret }}",
   "data":{
      "empresa":{
         "tipo_pessoa":"j",
         "nome_fantasia":"Velho Mundo Testes Funcionais",
         "razao_social":"Velho Mundo Testes Funcionais S\/A",
         "cnpj":"18.315.196\/0001-79"
      },
      "usuario":{
         "nome":"Ad\u00e3o Silvestre Matias",
         "email":"jsilva@terra.com.br",
         "telefone1":"(19) 999999999",
         "telefone2":"(19) 888888888",
         "telefone3":"(19) 777777777",
         "senha":"senha1"
      },
      "contratos":[
         {
            "produto_id":123,
            "contrato_inicio":"2016-01-01",
            "contrato_fim":"2016-12-31",
            "freemium":true,
            "ativo_consultoria":true,
            "ativo_acesso_conteudo":true,
            "anotacoes": [
                {
                    "texto": "Informações gerais do cliente. Profissão: Carteiro   Estado Civil: casado",
                    "disponivelCliente": false,
                    "arquivos": [
                           {
                                "nome_original": "Dados do cliente.docx",
                                "conteudo_base_64": "T3MgZGFkb3MgZG8gY2xpZW50ZSBlbSBiYXNlNjQuDQo"
                           }
                    ]
                }
            ]
         }
      ]
   }
}
```

Resposta em caso de **sucesso (status 200)**. Exemplo:

```json
{
  "message": "Cliente + Usuário + Contratos criados com sucesso",
  "log_id": 69,
  "info": {
    "empresa_id": 77343,
    "contratos_gerados": [
      {
        "id": 99910,
        "produto_id": 123
      }
    ],
    "usuario_gerado": {
      "id": 52676,
      "username": "jsilva123"
    }
  }
}
```

     
Resposta em caso de **falha (status 401)**:
     
```json     
        {
           "message":"Falha ao criar Cliente + Usuário + Contratos - Produto com id 27 encontrado, mas não disponível para a organização exemple23",
           "info":{
              "data":{
                 "empresa":{
                    "tipo_pessoa":"j",
                    "nome_fantasia":"Empresa nome Teste",
                    "razao_social":"Empresa nome Teste S\/A",
                    "cnpj":"18.315.196\/0001-79"
                 },
                 "usuario":{
                    "nome":"Ad\u00e3o Silvestre",
                    "email":"exemple@gmial.com.br",
                    "telefone1":"(19) 999999999",
                    "telefone2":"(19) 888888888",
                    "telefone3":"(19) 777777777",
                    "senha":"159357"
                 },
                 "contratos":[
                    {
                       "produto_id":27,
                       "contrato_inicio":"2016-06-01",
                       "contrato_fim":"2016-08-31",
                       "freemium":false,
                       "ativo_consultoria":true,
                       "ativo_acesso_conteudo":true
                    }
                 ]
              },
              "log_id":168
           }
        }
```
              
        
### `GET /api/v1/{{clientId}}/contrato/{{ contratoId }}.json`

Obtem dados do **CONTRATO** 

#### Definições gerais

Retorna as principais informações relacionadas ao contrato, 
tais como: Empresa, Usuarios, Chamados, Diagnostico(Perguntas e Repostas), Eventos, Anotacoes, Produto, Etapas do Cronograma.


**Exemplo de requisição HTTP**

O corpo da requisição deve conter as informações codificadas como um documento JSON:

```
GET /{{ api_version }}/{{ api_client_id }}/contrato/{{ contratoId }}.json HTTP/1.1
Host: {{ url_base }}
Content-Type: application/json; charset=utf-8
Cache-Control: no-cache
apisecret: {{ apisecret }}

```

Resposta em caso de **sucesso (status 200)**. Exemplo:

```json
{
  "message": "Dados do contrato obtido com sucesso",
  {
     "info":{
        "contrato":{
           "id":38483,
           "data_compra":"2015-06-30T10:31:35-0400",
           "contrato_data_inicio":"2015-07-01T00:00:00-0400",
           "contrato_data_expiracao":"2016-08-12T00:00:00-0400",
           "contrato_encerrado_em":"2016-06-30T00:00:00-0400",
           "contrato_encerrado_motivo":"expirado",
           "cronograma_inicio":"2015-07-02T00:00:00-0400",
           "cronograma_previsao_termino":"2016-03-04T00:00:00-0500",
           "empresa":{
              "tipo_pessoa":"j",
              "fantasia":"Empresa ficticia.",
              "razao":"Empresa ficticia.",
              "cnpj":"11.455.455\/0001-55",
              "telefone":"(00)55669988",
              "id":26485
           },
           "produto":{
              "id":221,
              "nome":"SGQv4.0 - SISTEMA DE GEST\u00c3O DA QUALIDADE - ISO9001:2008",
              "descricao_html":"0",
              "freemium":false,
              "disponibilizar_opr":true,
              "nick":"ISO 9001 v4",
              "ativo_comercial":false,
              "ativo_consultor":true,
              "titulo_simples":"ISO 9001"
           },
           "ativo_consultoria":true,
           "ativo_acesso_conteudo":true,
           "respostas_diagnostico":[
              {
                 "id":51982,
                 "pergunta":{
                    "id":828,
                    "descricao":"Pergunta Exemplo Api",
                    "ordem_lista":1,
                    "tipo":1,
                    "visivel_cliente":true
                 },
                 "resposta":"Resposta Exemplo Api"
              },
              {
                 "id":51983,
                 "pergunta":{
                    "id":829,
                    "descricao":"QUANTOS FUNCION\u00c1RIOS TRABALHAM EM SUA EMPRESA? ",
                    "ordem_lista":2,
                    "tipo":1,
                    "visivel_cliente":true
                 },
                 "resposta":"21"
              }
           ],
           "cronograma_etapas":[
              {
                 "id":214764,
                 "previsao_inicio":"2015-07-02T00:00:00-0400",
                 "previsao_termino":"2015-07-07T00:00:00-0400",
                 "etapa_atual":false,
                 "iniciado_em":"2015-07-02T10:15:48-0400",
                 "terminado_em":"2015-07-02T10:43:46-0400"
              },
              {
                 "id":214765,
                 "previsao_inicio":"2015-07-07T00:00:00-0400",
                 "previsao_termino":"2015-07-13T00:00:00-0400",
                 "etapa_atual":false,
                 "iniciado_em":"2015-07-02T10:43:46-0400",
                 "terminado_em":"2015-07-16T09:52:03-0400"
              }
           ],
           "usuarios":[
              {
                 "representante_direcao":false,
                 "usuario_conta":{
                    "id":8982,
                    "nome":"Usuario Exemplo Api",
                    "username":"usuarioexemplo@api.com.br",
                    "telefone1":"(00)44558877"
                 },
                 "ativo":true
              },
              {
                 "representante_direcao":true,
                 "usuario_conta":{
                    "id":29723,
                    "nome":"Outro Exemplo Api",
                    "username":"apiexemplo.test",
                    "telefone1":"(00)44558877"
                 },
                 "ativo":true
              }
           ]
        },
        "chamados":[
           {
              "chamado":{
                 "id":334369,
                 "assunto":"Registro de treinamento interno",
                 "status":"resolvido",
                 "criado_em":"2015-07-16T09:51:33-0400",
                 "ultima_interacao_em":"2015-08-06T08:58:32-0400"
              }
           },
           {
              "chamado":{
                 "id":334968,
                 "assunto":"Diagn\u00f3stico sobre a situa\u00e7\u00e3o da organiza\u00e7\u00e3o",
                 "status":"resolvido",
                 "criado_em":"2015-07-24T14:45:51-0400",
                 "ultima_interacao_em":"2015-07-24T15:54:19-0400"
              }
           }
        ],
        "eventos":[
           {
              "evento":{
                 "id":37658,
                 "tipo":{
                    "id":8,
                    "apelido":"reuni\u00e3o virtual",
                    "nome":"Reuni\u00e3o Virtual",
                    "titulo_padrao":"Reuni\u00e3o Virtual",
                    "descricao_padrao":"Reuni\u00e3o Virtual",
                    "criado_em":"2014-07-09T10:01:30-0400",
                    "atualizado_em":"2014-07-09T10:01:30-0400"
                 },
                 "titulo":"Reuni\u00e3o Virtual",
                 "visivel_para_cliente":true,
                 "agendado_para":"2015-07-01T03:00:00-0400",
                 "criado_em":"2015-07-02T10:15:47-0400",
                 "atualizado_em":"2015-07-02T10:15:47-0400"
              }
           },
           {
              "evento":{
                 "id":37659,
                 "tipo":{
                    "id":6,
                    "apelido":"visita",
                    "nome":"Visita",
                    "titulo_padrao":"Visita T\u00e9cnica",
                    "descricao_padrao":"Visita T\u00e9cnica",
                    "criado_em":"2014-07-09T10:01:30-0400",
                    "atualizado_em":"2014-07-09T10:01:30-0400"
                 },
                 "titulo":"Visita T\u00e9cnica",
                 "visivel_para_cliente":true,
                 "agendado_para":"2015-07-01T03:00:00-0400",
                 "criado_em":"2015-07-02T10:15:47-0400",
                 "atualizado_em":"2015-07-02T10:15:47-0400"
              }
           }
        ],
        "anotacoes":[
           {
              "anotacao":{
                 "id":60520,
                 "texto":"Cronograma : 42%\nConforme solicitado pela ApiConsultora, alterei a data da auditoria interna para a data xx-xx-xx.",
                 "criado_em":"2016-07-12T13:56:54-0400"
              }
           },
           {
              "anotacao":{
                 "id":59634,
                 "texto":"Cronograma : 40%\nenviado anteriormene: bla bla bla",
                 "criado_em":"2016-06-22T16:54:17-0400"
              }
           }
        ]
     }
  }
}
```

     
Resposta em caso de **falha (status 401)**:
     
```json     
        {  
           "message":"Falha ao tentar obter o Contrato - O ID do contrato n\u00e3o existe em nossa base de dados.",
           "info":{  
              "data":{  
                 "contratoId":"384832222"
              }
           }
        }
```        
