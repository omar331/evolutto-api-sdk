<?php
    $produtosDisponiveis = [
        [
            'id' => 1,
            'nome' => 'ISO 9001'
        ],
        [
            'id' => 2,
            'nome' => 'ISO 14001'
        ],
    ];


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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "form sendo processado <br><br>";
        var_dump($_POST);
    }
?>

<form method="post">
    <h3>Acesso a API</h3>
    <p><b>Obtenha esses dados em seu seu cadastro na plataforma</b></p>

    <table>
        <tr>
            <th>
                API Client
            </th>
            <td>
                <input type="text" name="api_client">
            </td>
        </tr>
        <tr>
            <th>
                API Secret
            </th>
            <td>
                <input type="text" name="api_secret">
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
                <input type="text" name="empresa_nome">
            </td>
        </tr>
        <tr>
            <th>
                Razão Social
            </th>
            <td>
                <input type="text" name="empresa_nome">
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
                <select name="produtos_contratados" multiple>
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


