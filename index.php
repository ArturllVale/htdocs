<?php
// index.php
session_start();

include_once("config/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $salvarUsuario = isset($_POST["salvarUsuario"]);

    if (verificar_login($usuario, $senha, $salvarUsuario)) {
        $_SESSION["logado"] = true;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>
                alert('Falha no login. Tente novamente.');
                window.location.href='index.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lumen Flux</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
  <br>
  <br>
  <?php include(isset($_SESSION["logado"]) && $_SESSION["logado"] ? "module/main.php" : "module/login.php"); ?>
  <div id="cookieConsentPopup" style="display: none; position: fixed; bottom: 0; width: 100%; background-color: #f5f5f5; padding: 20px; text-align: center;">
    <p>Este site usa cookies para garantir que você obtenha a melhor experiência em nosso site. <button id="acceptCookiesButton">Aceitar</button></p>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  
</body>

</html>