## SDKs para a plataforma Templum

Aqui você encontrará exemplos de como integrar seus sistemas (sites, aplicativos e outros softwares) 
à Plataforma de Consultoria Templum.
 

## Clients disponíveis
 
### PHP



### Web API Endpoint Reference

----
  <_Additional information about your API call. Try to use verbs that match both request type (fetching vs modifying) and plurality (one vs multiple)._>

* **URL:** /api/v1/{{clientId}}/produtos-disponiveis

* **Method:** `GET`
  
*  **URL Params:**
   **Required:** `clientId=[string]`
   **Descrição:** `ID do cliente da API fornecido pela Evolutto` 


* **Data Params**
   **Required:** `api_secret=[string]`
   **Descrição:** `segredo da API fornecido pela Evolutto`

* **Success Response:**
   **Code:** 200
   **Type:** Json
   **Content:** `{ id : 12 }`
 
* **Error Response:**
  * **Code:** 401 UNAUTHORIZED <br />
     **Type:** Json
     **Content:** `{ error : "Log in" }`
     
* **Sample Call:**

     
   ```php
   
           $urlBase = http://acesso.evolutto.com.br/api/v1/;
           
           $clientId = 5698555541111463652;
           
           $endpointUrl = sprintf('%s/%s/produtos-disponiveis.json',
                                     $urlBase,
                                     $clientId
                                 );

   ```


 
 