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
?>

<?php
    /*
     * Quando o formulário estiver sendo postado,
     * tenta criar um novo CLIENTE + USUÁRIO + CONTRATOS
     *
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //
        // ---> popula informações sobre contratos
        //
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
            'contratos' => $contratosCriar,
            'anotacoes' => [

                 [
                     'texto' => $_POST['conteudo'],
                     // 0 ou mais arquivos por anotacao
                     'arquivos' => [
                         [
                             'nome_original' => basename($_FILES['fileToUpload']['name']),
                             'conteudo_base_64' => base64_encode(file_get_contents($_POST['anexo']))
                         ]

                     ]
                 ]
            ]
        ];


        //
        //  ---> faz a solicitação de criação para a API
        //
        $criarResultado = $apiClient->novoCliente( $clienteCriarInfo );
        $resultInfo = json_decode($criarResultado['result'], true);

        // ---> exibe os resultados, de forma rudimentar
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
        </tr>
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

    <h3>Anotação no contrato</h3>

    <table>
        <tr>
            <th>

            </th>
            <td>
                <textarea name="conteudo" cols="40" rows="5"></textarea>
                <input type="file" name="anexo" id="fileToUpload" />
            </td>
        </tr>
    </table>

    <button type="submit">Cadastrar cliente</button>
</form>


