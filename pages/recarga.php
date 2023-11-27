<?php

// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}

require_once('vendor/autoload.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client = new \GuzzleHttp\Client();

    $response = $client->request('POST', 'https://sandbox.api.pagseguro.com/oauth2/application', [
        'headers' => [
            'Authorization' => 'Bearer seu-token',
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ],
        'json' => [
            'email' => 'artursantosvale2@gmail.com',
            'token' => '44E777010D0D5F777495EFAAFD2C37E8',
            'currency' => 'BRL',
            'itemId1' => '0001',
            'itemDescription1' => 'Pontos',
            'itemAmount1' => $_POST['amount'],
            'itemQuantity1' => '1',
            'reference' => 'REF1234',
            'redirectURL' => 'https://lseyvwh2.srv-108-181-92-76.webserverhost.top/',
        ]
    ]);

    $body = $response->getBody();
    header('Location: ' . $body);
} else {
    echo '<form method="POST">';
    echo '<label for="amount">Quantidade de pontos:</label><br>';
    echo '<input type="number" id="amount" name="amount" min="1" max="10"><br>';
    echo '<input type="submit" value="Comprar">';
    echo '</form>';
}
?>
