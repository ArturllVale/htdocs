<?php
// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}
?>
<h2>Administração do Servidor</h2>
<button class="btn btn-primary" onclick="toggleCollapse(1)">Botão 1</button>
<div class="content" id="content1">
<div class="card card-body">
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
  </div>
</div>
<br>
<button class="btn btn-primary" onclick="toggleCollapse(2)">Botão 2</button>
<div class="content" id="content2">
<div class="card card-body">
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
  </div>
</div>