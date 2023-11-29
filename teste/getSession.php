<?php
// URL do PagSeguro
$url = "https://ws.pagseguro.uol.com.br/v2/sessions";

// Dados para a requisição
$data = array(
    "email" => "artursantosvale2@gmail.com",
    "token" => "82EF6D5705424AAFBF81418F180EC785"
);

// Inicia o cURL
$ch = curl_init($url);

// Configura a requisição
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição
$result = curl_exec($ch);

// Fecha a conexão
curl_close($ch);

// Exibe o resultado
echo $result;
?>