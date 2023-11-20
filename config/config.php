<?php
define('DB_HOST', 'localhost');         // IP do Host ou localhost
define('DB_USER', 'ragnarok');          // Usuário do Banco de dados
define('DB_PASSWORD', 'ragnarok');      // Senha do Banco de dados
define('DB_NAME', 'ragnarok');          // Nome do Banco de dados

define('SITE_TITLE', 'Lumen Flux');     // Título do Site
define('ENVIO_DISCORD_ATIVADO', true);  // Defina como true para ativar ou false para desativar
                                        // o envio de Mensagem de nova conta no Servidor do Discord.
define('DISCORD_WEBHOOK_URL', 'https://discord.com/api/webhooks/SEU_WEBHOOK_ID/SEU_TOKEN');

function conectarBanco() {
    $conexao = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($conexao->connect_error) {
        die("Falha na conexão. Por favor, tente novamente mais tarde.");
    }

    return $conexao;
}

function iniciarSessao() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function exibirAlerta($mensagem) {
    echo "<script>
            alert('$mensagem');
            window.location.href='index.php';
          </script>";
}

function verificar_login($usuario, $senha, $salvarUsuario) {
    iniciarSessao();

    $conexao = conectarBanco();

    // Verifique se houve mais de 3 tentativas de login nas últimas 20 minutos
    $limiteTentativas = 3;
    $tempoLimite = 20 * 60; // 20 minutos em segundos
    $ultimoLogin = getLastLoginAttemptTime($usuario, $conexao);

    if ($ultimoLogin !== null && time() - strtotime($ultimoLogin) < $tempoLimite) {
        // Limite de tentativas atingido
        echo "<script>
                alert('Limite de tentativas excedido. Tente novamente mais tarde.');
                window.location.href='index.php';
              </script>";
        // Adicione um log de tentativa malsucedida
        logSecurityEvent($usuario, $_SERVER['REMOTE_ADDR'], 'Failed Login Attempt');
        return false;
    }

    $sql = "SELECT * FROM login WHERE userid = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($senha, $usuario["user_pass"])) {
            $_SESSION["logado"] = true;
            $_SESSION["usuario"] = $usuario["userid"];

            // Se a caixa "Salvar Usuário?" estiver marcada, defina um cookie para o nome de usuário
            if ($salvarUsuario) {
                setcookie("usuario", $usuario["userid"], time() + (86400 * 30), "/");
            }

            // Resetar as tentativas de login após um login bem-sucedido
            resetLoginAttempts($usuario["userid"], $conexao);

            // Adicione um log de sucesso
            logSecurityEvent($usuario["userid"], $_SERVER['REMOTE_ADDR'], 'Successful Login');

            return true;
        } else {
            // A senha está incorreta
            exibirAlerta('Usuário ou Senha incorretos. Tente novamente!');
            // Adicione um log de tentativa malsucedida
            logSecurityEvent($usuario, $_SERVER['REMOTE_ADDR'], 'Failed Login Attempt');
            // Aumente o número de tentativas de login
            increaseLoginAttempts($usuario, $conexao);
            return false;
        }
    } else {
        // O usuário não existe
        exibirAlerta('Usuário ou Senha incorretos. Tente novamente!');
        return false;
    }
}

function enviarMensagemDiscord($mensagem) {
    if (defined('ENVIO_DISCORD_ATIVADO') && ENVIO_DISCORD_ATIVADO) {
    $webhookURL = DISCORD_WEBHOOK_URL;

    $data = array(
        "content" => $mensagem
    );

    $ch = curl_init($webhookURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
}

function logSecurityEvent($username, $ipAddress, $action) {
    $conexao = conectarBanco();

    $sql = "INSERT INTO security_log (username, ip_address, timestamp, action) VALUES (?, ?, NOW(), ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sss", $username, $ipAddress, $action);
    $stmt->execute();

    $stmt->close();
    $conexao->close();
}

function cadastrar($usuario, $senha, $confirmarSenha, $email, $genero) {
    iniciarSessao();

    $conexao = conectarBanco();

    if (strlen($usuario) < 4 || strlen($senha) < 4) {
        exibirAlerta('O usuário e a senha devem ter pelo menos 4 dígitos.');
        return;
    }

    $sql = "SELECT * FROM login WHERE userid = ? OR email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $usuario, $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        exibirAlerta('O usuário ou o email já existem.');
        return;
    }

    $genero = ($genero == "homem") ? "M" : "S";

    $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO login (userid, user_pass, email, sex, group_id) VALUES (?, ?, ?, ?, 0)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssss", $usuario, $hashedPassword, $email, $genero);
    $stmt->execute();

    // Enviar mensagem para o servidor do Discord
    $mensagemDiscord = "Oba, agora temos uma nova conta criada! Total de contas: " . obterTotalContas();
    enviarMensagemDiscord($mensagemDiscord);

    exibirAlerta('Cadastro realizado com sucesso!');
}

?>