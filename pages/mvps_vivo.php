<?php
// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}
?>
<h2>MVPs Vivos</h2>
<div class="row">
    <?php
    $dados = buscarDadosMvpStatus();
    for ($i = 0; $i < count($dados); $i += 4) {
        echo '<div class="row">';
        for ($j = $i; $j < $i + 4; $j++) {
            echo '<div class="col">';
            echo '<div class="card" style="width: 10rem;margin-bottom: 1em;">';
            echo '<img src="data/' . strtolower($dados[$j]['mvpName']) . '.png" class="card-img-top ' . ($dados[$j]['status'] === 'MORTO' ? 'grayscale' : '') . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $dados[$j]['mvpName'] . '</h5>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
</div>
<script>
//    setTimeout(function () {
//    location.reload();
//    }, 30000);
</script>