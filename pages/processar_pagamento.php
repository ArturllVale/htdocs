<?php
// Inclua suas funções aqui
include 'functions.php';

// Inicie a sessão se ainda não tiver sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifique se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}

// Obtenha o nome de usuário do usuário logado
$usuario = $_SESSION["usuario"];

// Obtenha o account_id do usuário logado
$accountId = obterAccountIdDoBancoDeDados($usuario);

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtenha o valor do pagamento do formulário
    $paymentAmount = $_POST['valor'];

    // Processar o pagamento
    $paymentResult = processPayment($paymentAmount);

    // Verifique se o pagamento foi bem-sucedido
    if ($paymentResult['status'] == 'success') {
        // Calcule os pontos do usuário (R$1 = 1000 pontos)
        $userPoints = $paymentAmount * 1000;

        // Atualize os pontos do usuário
        updateUserPoints($accountId, $userPoints);

        // Exiba um pop-up de alerta e recarregue a página
        echo "<script>alert('Pagamento realizado com sucesso!'); location.reload();</script>";
    }
}
?>
