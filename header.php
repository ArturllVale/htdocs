<?php
session_start();
include_once("config/includes.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Verificar hCaptcha
  $hCaptchaResponse = $_POST['h-captcha-response'];
  $hCaptchaSecretKey = 'ES_35106de31fe04cd59b71adec1ddfc139';
  $hCaptchaVerifyUrl = "https://hcaptcha.com/siteverify?secret=$hCaptchaSecretKey&response=$hCaptchaResponse";
  $hCaptchaVerification = json_decode(file_get_contents($hCaptchaVerifyUrl));

  if (!$hCaptchaVerification->success) {
    // Tratar erro de hCaptcha não verificado
    $_SESSION["erro_login"] = 'Falha no login devido ao Captcha. Tente novamente.';
    header("Location: index.php");
    exit();
  }

  // Verificar se existe um usuário no formulário
  if (isset($_POST["usuario"])) {
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

  // Verificar hCaptcha
  $secretKeyCadastro = 'ES_35106de31fe04cd59b71adec1ddfc139';
  $responseCadastro = $_POST['h-captcha-response'];
  $verifyURLCadastro = "https://hcaptcha.com/siteverify?secret=$secretKeyCadastro&response=$responseCadastro";
  $verificationCadastro = json_decode(file_get_contents($verifyURLCadastro));

  if (!$verificationCadastro->success) {
    // Tratar erro de hCaptcha não verificado no cadastro
    $_SESSION["erro_cadastro"] = "Erro de verificação do hCaptcha. Tente novamente.";
    header("Location: cadastro.php");
    exit();
  }

  // Obtenha os dados do formulário de cadastro
  $usuarioCadastro = isset($_POST["usuarioc"]) ? $_POST["usuarioc"] : "";
  $senhaCadastro = isset($_POST["senhac"]) ? $_POST["senhac"] : "";
  $confirmarSenhaCadastro = isset($_POST["confirmarSenha"]) ? $_POST["confirmarSenha"] : "";
  $emailCadastro = isset($_POST["email"]) ? $_POST["email"] : "";
  $generoCadastro = isset($_POST["genero"]) ? $_POST["genero"] : "";

  // Validar os dados de cadastro
  if (empty($usuarioCadastro) || empty($senhaCadastro) || empty($confirmarSenhaCadastro) || empty($emailCadastro) || empty($generoCadastro)) {
    // Tratar erro de dados incompletos no cadastro
    $_SESSION["erro_cadastro"] = "Preencha todos os campos do formulário de cadastro.";
    header("Location: cadastro.php");
    exit();
  }

  // Verificar se as senhas coincidem no cadastro
  if ($senhaCadastro !== $confirmarSenhaCadastro) {
    // Tratar erro de senhas não coincidentes no cadastro
    $_SESSION["erro_cadastro"] = "As senhas não coincidem. Tente novamente.";
    header("Location: cadastro.php");
    exit();
  }

  // Chamar a função cadastrar
  cadastrar($usuarioCadastro, $senhaCadastro, $confirmarSenhaCadastro, $emailCadastro, $generoCadastro);
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