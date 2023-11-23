<?php
  include "header.php";
?>

<body>
    <div class="container">
        <div class="row index-box">
            <?php include('module/menu.php'); ?>
            <div class="col-md-12 index-direita-main">
                <?php
                // Verifica se o usuário está logado
                if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
                    // Se não estiver logado, redireciona para a página de login
                    header("Location: index.php");
                    exit();
                }

                // Verifica qual item do menu está ativo
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    // Inclui dinamicamente o conteúdo correspondente à seção do menu
                    include('pages/' . $page . '.php');
                } else {
                    // Se nenhum item do menu estiver ativo, exibe um conteúdo padrão
                    echo '<h2>Bem-vindo <span class="orange-user">' . $_SESSION["usuario"] . '</span>!</h2>';
                    echo '<widgetbot class="discord-bot" server="1067843290197667940" channel="1080887289321885737" width="860" height="500"></widgetbot>';
                    echo '<script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>