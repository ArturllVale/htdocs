<?php
// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}
?>
<h2>Administração do Servidor</h2>
<button class="btn btn-success" type="button" onclick="toggleCollapse(1)">Jogadores Online</button>
<button class="btn btn-success" type="button" onclick="toggleCollapse(2)">Consultar Contas</button>
<button class="btn btn-success" type="button" onclick="toggleCollapse(3)">Consultar Item</button>
<button class="btn btn-success" type="button" onclick="toggleCollapse(4)">Resetar Ranks</button>
<button class="btn btn-primary" type="button" onclick="toggleCollapse(5)">Gerênciar Notícias</button>
<button class="btn btn-danger" type="button" onclick="toggleCollapse(6)">Ban por IP</button>


<div class="content" id="content1">
    <div class="card card-body">
        <h3>Exibe uma lista de personagens online no servidor</h3>
    </div>
</div>

<div class="content" id="content2">
    <div class="card card-body">
        <h3>Consulta informações Básicas de um jogador</h3>
    </div>
</div>

<div class="content" id="content3">
    <div class="card card-body">
        <h3>Consulta informações sobre a posse de itens</h3>
    </div>
</div>

<div class="content" id="content4">
    <div class="card card-body">
        <h3>Reseta os Ranks com 1 click</h3>
    </div>
</div>

<div class="content" id="content5">
    <div class="card card-body">
        <h3>Bane um jogador por IP</h3>
    </div>
</div>