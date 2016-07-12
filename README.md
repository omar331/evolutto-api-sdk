## SDKs para a plataforma Templum

Aqui você encontrará exemplos de como integrar seus sistemas (sites, aplicativos e outros softwares) 
à Plataforma de Consultoria Templum.
 

## Clients disponíveis
 
### PHP



### Web API Endpoint Reference

----
 Obtem lista dos produtos disponiveis.

* **URL:** `GET` /api/v1/{{clientId}}/produtos-disponiveis HTTP/1.1
  **Required:** `clientId=[string]`
  **Descrição:** `ID do cliente da API fornecido pela Evolutto` 

* **Data Params**
  **Required:** `api_secret=[string]`
  **Descrição:** `segredo da API fornecido pela Evolutto`

* **Success Response:**
  **Code:** 200
  **Content:** 
        
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
 
* **Error Response:**
  **Code:** 401 UNAUTHORIZED
  **Content:**   
  
            [
                {
                    "message":"Client n\u00e3o autorizado a acessar API"
                }
            ]
        
* **Sample Call:**

          GET /api/v1/ee2556daaa3694aaadddcff1/produtos-disponiveis.json HTTP/1.1
          Host: acesso.evolutto.com.br
          Content-Type: application/json; charset=utf-8
          conteudoId: 4341
          apisecret: 986354111
          Cache-Control: no-cache


Cadastra novo cliente

* **URL:** `POST` /api/v1/{{clientId}}/novo-cliente HTTP/1.1
   **Required:** `clientId=[string]`
   **Descrição:** `ID do cliente da API fornecido pela Evolutto` 

* **Data Params**
   **Required:** `api_secret=[string]`
   **Descrição:** `segredo da API fornecido pela Evolutto`

* **Success Response:**
   **Code:** 200
   **Content:** 
        
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
 
* **Error Response:**
  **Code:** 401 UNAUTHORIZED
     **Type:** Json
     **Content:** 
     
     
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
        
        
* **Sample Call:**

          POST /api/v1/ee2556daaa3694aaadddcff1/novo-cliente.json HTTP/1.1
          Host: acesso.evolutto.com.br
          Content-Type: application/json; charset=utf-8
          Cache-Control: no-cache
          {
             "api_secret":"segredo",
             "data":{
                "empresa":{
                   "tipo_pessoa":"j",
                   "nome_fantasia":"Exemplo Empresa 1",
                   "razao_social":"Exemplo Empresa 1 S\/A",
                   "cnpj":"15.369.365\/0001-79"
                },
                "usuario":{
                   "nome":"Ad\u00e3o Silvestre",
                   "email":"exemple1@terra.com.br",
                   "telefone1":"(19) 999999999",
                   "telefone2":"(19) 888888888",
                   "telefone3":"(19) 777777777",
                   "senha":"159357"
                },
                "contratos":[
                   {
                      "produto_id":7226,
                      "contrato_inicio":"2016-01-01",
                      "contrato_fim":"2016-12-31",
                      "freemium":true,
                      "ativo_consultoria":true,
                      "ativo_acesso_conteudo":true,
                      "anotacoes":[
                         {
                            "texto":"minha anotacao 1",
                            "disponivelCliente":false,
                            "arquivos":[
                               {
                                  "nome_original":"ficha_cadastral1.docx",
                                  "conteudo_base_64":"conteudo codificado em base 64"
                               },
                               {
                                  "nome_original":"ficha_cadastral2.docx",
                                  "conteudo_base_64":"conteudo codificado em base 64"
                               }
                            ]
                         },
                         {
                            "texto":"minha anotacao 2",
                            "disponivelCliente":0,
                            "arquivos":[
                               {
                                  "nome_original":"ficha_cadastral3.docx",
                                  "conteudo_base_64":"conteudo codificado em base 64"
                               },
                               {
                                  "nome_original":"ficha_cadastral4.docx",
                                  "conteudo_base_64":"conteudo codificado em base 64"
                               }
                            ]
                         }
                      ]
                   },
                   {
                      "produto_id":7227,
                      "contrato_inicio":"2016-02-25",
                      "contrato_fim":"2016-07-31",
                      "freemium":false,
                      "ativo_consultoria":true,
                      "ativo_acesso_conteudo":true
                   }
                ]
             }
          }




 
 