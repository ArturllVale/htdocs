<?php
// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}
?>
<h2>Administração do Servidor</h2>
<button class="btn btn-danger" type="button" onclick="toggleCollapse(1)">Personagens Online</button>
<button class="btn btn-danger" type="button" onclick="toggleCollapse(2)">Consultar Contas</button>
<button class="btn btn-danger" type="button" onclick="toggleCollapse(3)">Consultar Item</button>
<button class="btn btn-danger" type="button" onclick="toggleCollapse(4)">Resetar Ranks</button>
<button class="btn btn-danger" type="button" onclick="toggleCollapse(5)">Ban por IP</button>


<div class="content" id="content1">
    <div class="card card-body">
        Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user
        activates the relevant trigger.
    </div>
</div>

<div class="content" id="content2">
    <div class="card card-body">
        Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user
        activates the relevant trigger.
    </div>
</div>

<div class="content" id="content3">
    <div class="card card-body">
        Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user
        activates the relevant trigger.
    </div>
</div>

<div class="content" id="content4">
    <div class="card card-body">
        Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user
        activates the relevant trigger.
    </div>
</div>

<div class="content" id="content5">
    <div class="card card-body">
        Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user
        activates the relevant trigger.
    </div>
</div>