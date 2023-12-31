<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include_once("config/includes.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submite']) && $_POST['submite'] == 'login') {
  $usuario = $_POST["usuario"];
  $senha = $_POST["senha"];
  $salvarUsuario = isset($_POST["salvarUsuario"]);
  indexLogin($usuario, $senha, $salvarUsuario);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submite']) && $_POST['submite'] == 'registro') {
  // Lógica pra função de cadastro
  if (HCAPTCHA_ATIVO) {
    // Verifique o hCaptcha
    $secretKey = SECRET_KEY;
    $response = $_POST['h-captcha-response'];
    $verifyURL = "https://hcaptcha.com/siteverify?secret=$secretKey&response=$response";
    $verification = json_decode(file_get_contents($verifyURL));

    if (!$verification->success) {
      // Tratar erro de hCaptcha não verificado
      echo "Erro de verificação do hCaptcha. Tente novamente.";
      header("Location: cadastro.php");
      exit();
    }
  }

  // Obtenha os dados do formulário
  $usuario_c = isset($_POST["usuario_c"]) ? $_POST["usuario_c"] : "";
  $senha_c = isset($_POST["senha_c"]) ? $_POST["senha_c"] : "";
  $confirmarsenha_c = isset($_POST["confirmarsenha_c"]) ? $_POST["confirmarsenha_c"] : "";
  $email = isset($_POST["email"]) ? $_POST["email"] : "";
  $genero = isset($_POST["genero"]) ? $_POST["genero"] : "";

  // Validar os dados
  if (empty($usuario_c) || empty($senha_c) || empty($confirmarsenha_c) || empty($email) || empty($genero)) {
    // Tratar erro de dados incompletos
    echo "Preencha todos os campos do formulário.";
    header("Location: cadastro.php");
    exit();
  }

  // Verificar se as senha_cs coincidem
  if ($senha_c !== $confirmarsenha_c) {
    // Tratar erro de senha_cs não coincidentes
    echo "As senhas não coincidem. Tente novamente.";
    exit();
  }

  // Chamar a função cadastrar
  cadastrar($usuario_c, $senha_c, $confirmarsenha_c, $email, $genero);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['submit']) && $_POST['submit'] == 'recuperarSenha') {
    $email = $_POST["email"];
    $confirmarEmail = $_POST["confirmarEmail"];
    recuperarSenha($email, $confirmarEmail);
  }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['submit']) && $_POST['submit'] == 'redefinirSenha') {
    $senha = $_POST["senha"];
    $confirmarSenha = $_POST["confirmarSenha"];
    $token = $_POST["token"];
    // Chame a função
    redefinirSenha($senha, $confirmarSenha, $token);
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