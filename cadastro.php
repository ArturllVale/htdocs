<?php
include "header.php";
?>

<body>
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
        <form method="post" action="cadastro.php" id="registro">
          <!-- Usuário -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
              <input type="text" class="form-control" id="usuario_c" name="usuario_c" placeholder="Crie um usuário"
                required>
            </div>
          </div>
          <!-- senha_c -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
              <input type="password" class="form-control" id="senha_c" name="senha_c" placeholder="Crie uma senha"
                required>
            </div>
          </div>
          <!-- Confirmar senha_c -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
              <input type="password" class="form-control" id="confirmarsenha_c" name="confirmarsenha_c"
                placeholder="Confirme sua senha" required>
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
          <div class="mb-3">
            <div class="h-captcha" data-sitekey="<?php echo DATA_SITEKEY; ?>"></div>
          </div>
          <div class="text-end">
            <button type="submit" name="submite" value="registro" class="btn btn-primary">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
  include "footer.php";
  ?>