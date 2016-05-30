<?php

class ApiClient {
    /**
     * @var $enviroment
     */
    protected $enviroment;


    /** @var  string $clientId
     * ID do cliente obtido a partir das configurações de sua Organização na plataforma
     */
    protected $clientId;


    /**
     * @var string $clientSecrect
     * Secredo de acesso a API - obtido a partir das configurações de sua Organização na plataforma
     */
    protected $clientSecret;

    /**
     * @param $clientId
     * @param $clientSecret
     * @param string $enviroment
     * @param string $apiVersion
     */
    public function __construct( $clientId, $clientSecret, $enviroment = 'prod', $apiVersion = 'v1' ) {
        $environments = $this->getEnvironments();

        if ( ! array_key_exists($enviroment, $environments) ) {
            throw new \InvalidArgumentException(
                sprintf("Environment %s doesn't exists. Available ones are %s",
                        $enviroment,
                        implode("'", array_keys($environments) )
                    )
            );
        }

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->enviroment = $enviroment;
        $this->apiVersion = $apiVersion;
    }


    /**
     * Get the base URL for current setup
     * @return string
     */
    public function getBaseUrl() {
        $environments = $this->getEnvironments();
        $env = $environments[ $this->enviroment ];

        $url = sprintf("%s%s/api/%s",
                        $env['baseUrl'],
                        $env['script'],
                        $this->apiVersion,
                        $this->clientId
        );

        return $url;
    }


    /**
     * Obtem os produtos disponiveis para a organização
     *
     * @return string
     */
    public function produtosDisponiveis() {
        $baseUrl = $this->getBaseUrl();

        $url = sprintf("%s/produtos-disponiveis.json", $baseUrl );

        return $url;
    }



    /**
     * Cria um novo registro de CLIENTE + USUÁRIO + CONTRATOS
     * @param array $novoClienteInfo
     * @return array
     */
    public function novoCliente( Array $novoClienteInfo = [] ) {
        $baseUrl = $this->getBaseUrl();

        $url = sprintf("%s/novo-cliente.json", $baseUrl);

        $data = [
            'api_secret' => $this->clientSecret,
            'data' => $novoClienteInfo
        ];

        $result = $this->send($url, 'POST', $data );

        return $result;
    }



    /**
     * Send a request to API
     * @param $url
     * @param string $method
     * @param array|null $data
     * @return array
     */
    public function send( $url, $method = "POST", Array $data = null ) {
        $method = strtoupper($method);

        $allowedMethods = ['POST', 'GET', 'DELETE', 'PATCH', "PUT", "OPTIONS", "HEAD"];

        if ( ! in_array($method, $allowedMethods) ) {
            throw new \InvalidArgumentException(
                sprintf('Method %s not allowed. Allowed methods are %s',
                            $method, implode(', ', $allowedMethods)
                )
            );
        }

        $dataEncoded = http_build_query($data);

        $curlClient = curl_init();
        curl_setopt($curlClient, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curlClient, CURLOPT_URL, $url);
        curl_setopt($curlClient, CURLOPT_POST, 1); //0 for a get request
        curl_setopt($curlClient, CURLOPT_POSTFIELDS, $dataEncoded);
        curl_setopt($curlClient, CURLOPT_CUSTOMREQUEST, $method );
        curl_setopt($curlClient, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlClient, CURLOPT_HEADER, 0);
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlClient, CURLOPT_TIMEOUT,1000000);

        $result = curl_exec($curlClient);
        $http_status_code = curl_getinfo($curlClient, CURLINFO_HTTP_CODE);

        curl_close($curlClient);

        return [
            'result' => $result,
            'statusCode' =>  $http_status_code
        ];
    }



    /**
     * Get available environments and their configuration
     * @return array
     */
    protected function getEnvironments() {
        return [
            'prod' => [
                'baseUrl' => 'http://acesso.templum.com.br/',
                'script' => '/'
            ],
            'teste3' => [
                'baseUrl' => 'http://teste3.templum.com.br/',
                'script' => '/'
            ],
            'dev' => [
                'baseUrl' => 'http://templum.dev/',
                'script' => '/app_multi_dev.php'
            ],
        ];
    }

}