<?php
require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();
$response = $client->request('POST', 'https://sandbox.api.pagseguro.com/notifications', [
    'headers' => [
        'Authorization' => 'Bearer seu-token',
        'accept' => 'application/json',
        'content-type' => 'application/json',
    ],
]);

$body = json_decode($response->getBody(), true);

// Se a transação foi paga
if ($body['status'] == 3) {
    $usuario = $body['reference']; // Supondo que o nome de usuário foi passado como referência
    $valor = $body['grossAmount'];

    $accountId = obterAccountIdDoBancoDeDados($usuario);
    $cash_coins = $valor * 1000; // 1 real = 1000 pontos

    $conexao = conectarBanco();
    $sql = "UPDATE login SET cash_coins = cash_coins + ? WHERE account_id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $cash_coins, $accountId);
    $stmt->execute();
    $stmt->close();

    $conexao->close();
}
?>