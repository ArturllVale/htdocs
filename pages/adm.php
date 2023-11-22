<?php
// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}
?>
<h2>Administração do Servidor</h2>
<p class="d-inline-flex gap-1">
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#box01" role="button" aria-expanded="false" aria-controls="collapseExample">
    Link with href
  </a>
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#box02" aria-expanded="false" aria-controls="collapseExample">
    Button with data-bs-target
  </button>
</p>
<div class="collapse" id="box01">
  <div class="card card-body">
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
  </div>
</div>
<div class="collapse" id="box02">
  <div class="card card-body">
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
  </div>
</div>

<button class="collapsible" onclick="toggleCollapse(1)">Botão 1</button>
<div class="content" id="content1">
  <p>Conteúdo do botão 1</p>
</div>

<button class="collapsible" onclick="toggleCollapse(2)">Botão 2</button>
<div class="content" id="content2">
  <p>Conteúdo do botão 2</p>
</div>