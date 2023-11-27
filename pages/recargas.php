<?php
// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}
// Obtenha o account_id do usuário logado
$usuario = $_SESSION["usuario"];
$accountId = obterAccountIdDoBancoDeDados($usuario);
?>

<h1 class="mt-5 mb-3">Recargas</h1>

<form action="processar_pagamento.php" method="post">
    <div class="mb-3">
        <label for="valor" class="form-label">Valor do pagamento</label>
        <input type="number" class="form-control" id="valor" name="valor" min="1" step="any" required>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
</form>