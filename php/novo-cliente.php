<?php
    session_start();
    require_once('ApiClient.php');

    // ---> as informaçoes de acesso já devem  estar armazenadas na API
    $apiClientApelido = $_SESSION['sdk_api_client_apelido'];
    $apiClientId = $_SESSION['sdk_api_client_id'];
    $apiSecret = $_SESSION['sdk_api_secret'];
    $apiEnvironment = $_SESSION['sdk_api_environment'];

    $apiClient = new ApiClient( $apiClientId, $apiSecret, $apiEnvironment );

    // ---> obtem os produtos disponíveis através da API
    //
    $produtosDisponiveis = $apiClient->produtosDisponiveis();

//    $postData = [
//        'api_secret' => $aplicacaoTeste->getClientSecret(),
//        'data' => [
//            'empresa' => [
//                'tipo_pessoa' => 'j',
//                'nome_fantasia' => static::TEST_NOVO_CLIENTE_CONTRATO_CLIENTE_EMPRESA_NOME_FANTASIA,
//                'razao_social' => static::TEST_NOVO_CLIENTE_CONTRATO_CLIENTE_EMPRESA_RAZAO_SOCIAL,
//                'cnpj' => static::TEST_NOVO_CLIENTE_CONTRATO_CLIENTE_EMPRESA_CNPJ,
//            ],
//            'usuario' => [
//                'nome' => static::TEST_NOVO_CLIENTE_CONTRATO_USUARIO_NOME,
//                'email' => static::TEST_NOVO_CLIENTE_CONTRATO_USUARIO_EMAIL,
//                'telefone1' => static::TEST_NOVO_CLIENTE_CONTRATO_USUARIO_TELEFONE1,
//                'telefone2' => static::TEST_NOVO_CLIENTE_CONTRATO_USUARIO_TELEFONE2,
//                'telefone3' => static::TEST_NOVO_CLIENTE_CONTRATO_USUARIO_TELEFONE3,
//                'senha' => static::TEST_NOVO_CLIENTE_CONTRATO_USUARIO_SENHA,
//            ],
//            'contratos' => [
//                [
//                    'produto_id' => $produto1Ref->getId(),
//                    'contrato_inicio' => '2016-01-01',
//                    'contrato_fim' => '2016-12-31',
//                    'freemium' => true,
//                    'ativo_consultoria' => true,
//                    'ativo_acesso_conteudo' => true,
//                ],
//                [
//                    'produto_id' => $produto2Ref->getId(),
//                    'contrato_inicio' => '2016-02-25',
//                    'contrato_fim' => '2016-07-31',
//                    'freemium' => false,
//                    'ativo_consultoria' => true,
//                    'ativo_acesso_conteudo' => true,
//                ]
//            ]
//        ]
//    ];
?>

<?php
    // ---> tenta criar um novo CLIENTE + USUÁRIO + CONTRATOS
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $contratoInicio = new \DateTime();

        $contratoTermino = clone $contratoInicio;
        $contratoTermino->add( new \DateInterval('P12M') );

        $contratosCriar = [];
        foreach( $_POST['produtos_contratados'] as $produtoId ) {
            $contratosCriar[] = [
                'produto_id' => $produtoId,
                'contrato_inicio' => $contratoInicio->format('Y-m-d'),
                'contrato_fim' => $contratoTermino->format('Y-m-d'),
                'freemium' => false,
                'ativo_consultoria' => true,
                'ativo_acesso_conteudo' => true,
            ];
        }


        //
        // ---> informações do cliente a ser cadastrado
        //
         $clienteCriarInfo = [
            'empresa' => [
                'tipo_pessoa' => 'j',
                'nome_fantasia' => $_POST['nome_fantasia'],
                'razao_social' => $_POST['razao_social'],
                'cnpj' => $_POST['cnpj'],
            ],
            'usuario' => [
                'nome' => $_POST['usuario_nome'],
                'email' => $_POST['usuario_email'],
                'telefone1' => $_POST['usuario_telefone1'],
                'telefone2' => $_POST['usuario_telefone2'],
                'telefone3' => '99 99999999',
                'senha' => $_POST['usuario_senha'],
            ],
            'contratos' => $contratosCriar
        ];

        $criarResultado = $apiClient->novoCliente( $clienteCriarInfo );
        $resultInfo = json_decode($criarResultado['result'], true);


        echo "<H1>Resultados</H1><br>";

        echo "<pre>";
        print_r($resultInfo);
        echo "</pre>";
        exit;
    }
?>

<form method="post">
    <h3>API - Credenciais de Acesso</h3>

    <table>
        <tr>
            <th>
                Apelido
            </th>
            <td>
                <?php echo $apiClientApelido ?>
            </td>
        </tr>
        <tr>
            <th>
                API Client
            </th>
            <td>
                <?php echo $apiClientId ?>
            </td>
        </tr>
        <tr>
            <th>
                API Secret
            </th>
            <td>
                <?php echo $apiSecret ?>
            </td>
        </tr>
        <tr>
            <th>
                Ambiente
            </th>
            <td>
                <?php echo $apiEnvironment ?>
            </td>
        </tr>
    </table>

    <h3>Dados da empresa</h3>
    <table>
        <tr>
            <th>
                Nome Fantasia
            </th>
            <td>
                <input type="text" name="nome_fantasia">
            </td>
        </tr>$apiClient->novoCliente( $clienteCriarInfo
        <tr>
            <th>
                Razão Social
            </th>
            <td>
                <input type="text" name="razao_social">
            </td>
        </tr>
        <tr>
            <th>
                CNPJ
            </th>
            <td>
                <input type="text" name="cnpj">
            </td>
        </tr>
    </table>

    <h3>Dados do usuário</h3>
    <table>
        <tr>
            <th>
                Nome
            </th>
            <td>
                <input type="text" name="usuario_nome">
            </td>
        </tr>
        <tr>
            <th>
                Email
            </th>
            <td>
                <input type="text" name="usuario_email">
                <br
                <b>Atenção:</b> o nome de usuário é criado a partir do email
            </td>
        </tr>
        <tr>
            <th>
                Senha
            </th>
            <td>
                <input type="text" name="usuario_senha">
            </td>
        </tr>
        <tr>
            <th>
                Telefone 1
            </th>
            <td>
                <input type="text" name="usuario_telefone1">
            </td>
        </tr>
        <tr>
            <th>
                Telefone 2
            </th>
            <td>
                <input type="text" name="usuario_telefone2">
            </td>
        </tr>
    </table>

    <h3>Produtos contratados</h3>

    <table>
        <tr>
            <th>
                Selecione
            </th>
            <td>
                <select name="produtos_contratados[]" multiple>
                    <?php foreach( $produtosDisponiveis as $produto ): ?>
                        <option value="<?php echo $produto['id']; ?>">
                            <?php echo $produto['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>

    <button type="submit">Cadastrar cliente</button>
</form>


