<?php
include "header.php";

$dados = buscarDadosMvpStatus();

header('Content-Type: application/json');
echo json_encode($dados);
?>