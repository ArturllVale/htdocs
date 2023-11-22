<?php
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] == true) {
    $sexo = $_SESSION["sex"];
    $caminhoImagem = ($sexo == "M") ? '../data/male.png' : '../data/female.jpg';
    $saudacao = ($_SESSION["sex"] == "M") ? "Bem-vindo" : "Bem-vinda";
    
    echo '<div class="img-container">';
    echo '<img src="' . $caminhoImagem . '" alt="Imagem de usuário" class="img-rounded">';
    echo '<br>';
    echo '<p>' . $saudacao . ', <span class="orange-user">' . $_SESSION["usuario"] . '</span>!</p>';
    echo '</div>';
}
?>
<span class="crumb-main">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Início</a></li>
            <li class="breadcrumb-item"><a href="?page=meus_personagens">Meus Personagens</a></li>
            <li class="breadcrumb-item"><a href="?page=rank_pvp">Rank PVP</a></li>
            <li class="breadcrumb-item"><a href="?page=rank_mvp">Rank MVP</a></li>
            <li class="breadcrumb-item"><a href="?page=mvps_vivo">MVPs Vivo</a></li>
            <li class="breadcrumb-item dropdown"><a type="button" data-bs-toggle="dropdown" aria-expanded="false">Administração</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
            </li>
            <li class="breadcrumb-item"><a href="module/logout.php">Sair</a></li>
        </ol>
    </nav>
</span>