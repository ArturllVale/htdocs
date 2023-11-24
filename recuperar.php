<?php
require "header.php";
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
            <div class="col-md-6 index-direita">
            <h2>Recuperar Senha</h2>
                <form action="recuperar.php" method="post" id="recuperarSenha">
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" class="form-control" placeholder="E-mail" name="email" aria-label="E-mail"
                            aria-describedby="basic-addon1" id="emailInput" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" class="form-control" placeholder="Confirmar E-mail" name="confirmarEmail"
                            aria-label="Confirmar E-mail" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="row">
                        <div class="col text-end">
                            <button type="submit" name="submit" value="recuperarSenha" class="btn btn-primary">Recuperar
                                Senha</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <?php
    require "footer.php";
    ?>