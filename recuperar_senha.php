<?php
require "header.php";
?>

<body>

    <div class="container">
        <div class="row index-box">
            <div class="col-md-6 index-esquerda">
                <h2>Informações</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer semper dui diam, eu euismod augue
                    iaculis et. Nullam ante justo, faucibus eget fringilla a, maximus ut orci. Nulla justo lacus,
                    tincidunt sed tempus ac, interdum at purus. Proin accumsan dictum tellus eu rutrum. Pellentesque sed
                    dapibus nisi. Suspendisse tristique sodales ultrices. Donec nec ultrices lorem.</p>
            </div>
            <div class="col-md-6 index-direita">
                <form action="recuperar_senha.php" method="post" id="redefinirSenha">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Nova Senha" name="senha"
                            aria-label="Nova Senha" aria-describedby="basic-addon1" id="senhaInput" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Confirmar Senha" name="confirmarSenha"
                            aria-label="Confirmar Senha" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="row">
                        <div class="col text-end">
                        <button type="submit" name="submit" value="redefinirSenha" class="btn btn-primary">Redefinir Senha</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    require "footer.php";
    ?>