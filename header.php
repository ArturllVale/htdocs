<?php
session_start();
include_once("config/includes.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usuario = $_POST["usuario"];
  $senha = $_POST["senha"];
  $salvarUsuario = isset($_POST["salvarUsuario"]);

  // Verificar hCaptcha
  $hCaptchaResponse = $_POST['h-captcha-response'];
  $hCaptchaSecretKey = 'ES_35106de31fe04cd59b71adec1ddfc139';
  $hCaptchaVerifyUrl = "https://hcaptcha.com/siteverify?secret=$hCaptchaSecretKey&response=$hCaptchaResponse";
  $hCaptchaVerification = json_decode(file_get_contents($hCaptchaVerifyUrl));

  if (!$hCaptchaVerification->success) {
    // Tratar erro de hCaptcha não verificado
    $_SESSION["erro_login"] = 'Falha no login devido ao hCaptcha. Tente novamente.';
    header("Location: index.php");
    exit();
  }

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
  <title>
    <?php echo SITE_TITLE; ?>
  </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilo.css">
  <script src='https://js.hcaptcha.com/1/api.js' async defer></script>
</head>