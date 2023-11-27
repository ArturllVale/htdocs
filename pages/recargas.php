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

<!-- INICIO DO BOTAO PAGSEGURO --><a href="https://pag.ae/7Z_wu-qTM/button" target="_blank" title="Pagar com PagSeguro"><img src="//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar.gif" alt="Pague com PagSeguro - é rápido, grátis e seguro!" /></a><!-- FIM DO BOTAO PAGSEGURO -->