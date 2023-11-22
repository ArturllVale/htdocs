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
        <div class="col-md-6 index-direita">
            <form action="index.php" method="post">
                <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="Usuário" name="usuario" aria-label="Username" aria-describedby="basic-addon1" id="usuarioInput">
                </div>
                <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Senha" name="senha" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <input class="form-check-input index-check" type="checkbox" value="" name="salvarUsuario" aria-label="Salvar Usuário?" id="salvarUsuarioCheckbox">
                                <p class="index-checkbox">Salvar Usuário?</p>
                            </div>
                        </div>
                    </div>
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                    <p class="index-novaconta">Não possui uma conta? <span class="color-conta"><a href="cadastro">Criar uma Agora!</a></span></p>
                    <?php if (isset($_SESSION["erro_login"])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION["erro_login"];
                        unset($_SESSION["erro_login"]); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>