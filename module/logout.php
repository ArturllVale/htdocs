<?php
session_start();

// Verificar se o usuário está logado antes de destruir a sessão
if (isset($_SESSION["logado"]) && $_SESSION["logado"]) {
    // Destruir a sessão
    session_destroy();
}

// Redirecionar para a página de login
header("Location: ../index.php");
exit();
?>
