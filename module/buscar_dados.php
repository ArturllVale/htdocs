<?php
require 'functions.php'; // Certifique-se de que este caminho esteja correto

$dados = buscarDadosMvpStatus();

header('Content-Type: application/json');
echo json_encode($dados);
?>