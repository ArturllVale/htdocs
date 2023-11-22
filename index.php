<?php
session_start();
include_once("config/includes.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $salvarUsuario = isset($_POST["salvarUsuario"]);

    if (verificar_login($usuario, $senha, $salvarUsuario)) {
        $_SESSION["sex"] = obterGeneroDoUsuario($usuario);
        $_SESSION["logado"] = true;
        header("Location: index.php");
        exit();
    } else {
        $_SESSION["erro_login"] = 'Falha no login. Tente novamente.';
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="author" content="Lumen">
  <meta name="description" content="Flex Control Panel">
  <meta name="keywords" content="Flex CP, Flux CP, Ragnarok Online, Ragnarok Control Panel, Ragnarok CP">
  <meta name="robots" content="index, follow">
  <meta name="version" content="1.0">
  <link rel="shortcut icon" href="Favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo SITE_TITLE; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
  <br>
  <br>
  <?php 
    if (isset($_SESSION["logado"]) && $_SESSION["logado"]) {
        include "module/main.php";
    } else {
        include "module/login.php";
    }
  ?>

<div id="cookieConsentPopup" class="fixed-bottom p-3 bg-light" style="display: none;">
    <div class="container text-center">
        <p class="mb-0">Este site usa cookies para garantir que você obtenha a melhor experiência em nosso site. <button id="acceptCookiesButton" class="btn btn-primary btn-sm">Aceitar</button></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  
</body>

</html>