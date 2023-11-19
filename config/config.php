<?php
// config.php
function verificar_login($usuario, $senha, $salvarUsuario) {
    // Conecte-se ao seu banco de dados aqui
    $conexao = new mysqli('localhost', 'ragnarok', 'ragnarok', 'ragnarok');

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    $sql = "SELECT * FROM login WHERE userid = ? AND user_pass = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $usuario, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Inicie a sessão e defina as variáveis de sessão
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION["logado"] = true;
        $_SESSION["usuario"] = $usuario;

        // Se a caixa "Salvar Usuário?" estiver marcada, defina um cookie para o nome de usuário
        if ($salvarUsuario) {
            setcookie("usuario", $usuario, time() + (86400 * 30), "/"); // 86400 = 1 dia
        }

        return true;
    } else {
        return false;
    }
}
?>
