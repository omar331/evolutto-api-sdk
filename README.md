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
             "api_secret":"25698556",
             "data":{
                "empresa":{
                   "tipo_pessoa":"j",
                   "nome_fantasia":"Exemple 1 cliente",
                   "razao_social":"Exemple 1 cliente S\/A",
                   "cnpj":"18.315.196\/0001-79"
                },
                "usuario":{
                   "nome":"Tadedu",
                   "email":"tadeu@gmial.com.dbr",
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
             }
          }




 
 