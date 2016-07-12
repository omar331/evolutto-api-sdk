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
        
        
