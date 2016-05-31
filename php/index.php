<?php
    // TODO: poderíamos colocar validações HTML 5 simples?
    //
    session_start();
    require_once('ApiClient.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // ---> as informações são colocadas na sessão, para uso posterior
        $_SESSION['sdk_api_client_apelido'] = $_POST['api_client_apelido'];
        $_SESSION['sdk_api_client_id'] = $_POST['api_client_id'];
        $_SESSION['sdk_api_secret'] = $_POST['api_secret'];
        $_SESSION['sdk_api_environment'] = $_POST['api_environment'];

        header('Location: novo-cliente.php');
        exit;
    }
?>

<form method="post">
    <h3>Acesso a API :)</h3>

    <p>
        Para interagir com a plataforma através da API, em nome de sua Organização,
        é necessário que você possua as credenciais de acesso solicitadas a seguir.
        <b>Obtenha esses dados em seu seu cadastro na plataforma</b>
    </p>

    <table>
        <tr>
            <th>
                API Client Apelido
            </th>
            <td>
                <input type="text" name="api_client_apelido">
                <B>(apenas como lembrete)</B>
            </td>
        </tr>
        <tr>
            <th>
                API Client
            </th>
            <td>
                <input type="text" name="api_client_id">
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
        <tr>
            <th>
                Ambiente
            </th>
            <td>
                <select name="api_environment">
                    <option value="">-- selecione</option>
                    <?php foreach( ApiClient::getEnvironments() as $envKey => $environment ): ?>
                        <option value="<?php echo $envKey ?>">
                            <?php echo $envKey ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>

    <button type="submit">Prosseguir</button>
</form>