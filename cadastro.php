<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "config/config.php";
    cadastrar($_POST["usuario"], $_POST["senha"], $_POST["confirmarSenha"], $_POST["email"], $_POST["genero"]);
}
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Criar Conta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
  <br>
  <br>
  <br>
  <div class="container">
    <div class="row index-box">
      <div class="col-md-6 index-esquerda">
        <h2>Informações</h2>
        <ul>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Integer semper dui diam, eu euismod augue iaculis et.
            Nullam ante justo, faucibus eget fringilla a, maximus ut orci.
            Nulla justo lacus, tincidunt sed tempus ac, interdum at purus.
            Proin accumsan dictum tellus eu rutrum. Pellentesque sed dapibus nisi.
            Suspendisse tristique sodales ultrices. Donec nec ultrices lorem.</p>
        </ul>
      </div>
      <div class="col-md-6 cadastro-direita">
        <h3 class="cadstroh3">Criar uma nova conta!</h3>
        <form method="post" action="cadastro.php">
          <!-- Usuário -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
              <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Crie um usuário" required>
            </div>
          </div>
          <!-- Senha -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
              <input type="password" class="form-control" id="senha" name="senha" placeholder="Crie uma senha" required>
            </div>
          </div>
          <!-- Confirmar Senha -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
              <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme sua senha" required>
            </div>
          </div>
          <!-- Email -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
              <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
            </div>
          </div>
          <!-- Radio para Homem ou Mulher -->
          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="genero" value="homem" id="generoHomem" required>
              <label class="form-check-label" for="generoHomem">Masculino</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="genero" value="mulher" id="generoMulher" required>
              <label class="form-check-label" for="generoMulher">Feminino</label>
            </div>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>