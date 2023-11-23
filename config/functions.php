<?php 
function conectarBanco() {
    // Estabelece uma conexão com o banco de dados
    $conexao = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verifica se houve falha na conexão
    if ($conexao->connect_error) {
        // Encerra a execução do script e exibe uma mensagem de falha
        die("Falha na conexão. Por favor, tente novamente mais tarde.");
    }

    // Retorna a conexão estabelecida
    return $conexao;
}

function iniciarSessao() {
    // Inicia a sessão se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function exibirAlerta($mensagem) {
    // Exibe um alerta com a mensagem fornecida e redireciona para a página inicial
    echo "<script>
            alert('$mensagem');
            window.location.href='index.php';
          </script>";
}

function getLastLoginAttemptTime($usuario, $conexao) {
    $sql = "SELECT timestamp FROM security_log WHERE username = ? ORDER BY timestamp DESC LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['timestamp'];
    } else {
        return null;
    }
}

function resetLoginAttempts($usuario, $conexao) {
    $sql = "UPDATE security_log SET attempts = 0 WHERE username = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
}

function increaseLoginAttempts($usuario, $conexao) {
    $sql = "UPDATE security_log SET attempts = attempts + 1 WHERE username = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
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

    // Preparação e execução de uma consulta SQL para verificar se o usuário existe no banco de dados
    // Utiliza um comando preparado para evitar injeção de SQL
    // O parâmetro 's' indica que é uma string (userid)
    // O resultado é armazenado em $resultado para posterior verificação
    $sql = "SELECT * FROM login WHERE userid = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verifica se a consulta retornou algum resultado (usuário encontrado)
    if ($resultado->num_rows > 0) {
        // Obtém os dados do usuário encontrado
        $usuario = $resultado->fetch_assoc();
        // Verifica se a senha fornecida corresponde à senha armazenada no banco de dados
        if ($senha == $usuario["user_pass"]) {
            // A senha está correta, inicie a sessão
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

    // Configuração da requisição cURL para enviar mensagem para o webhook do Discord
    // Utiliza o método POST, envia os dados em formato JSON, recebe a resposta e define 
    // o cabeçalho como 'Content-Type: application/json'
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

    // Inserção de registro no log de segurança
    // Insere informações como nome de usuário, endereço IP, timestamp e ação realizada
    $sql = "INSERT INTO security_log (username, ip_address, timestamp, action) VALUES (?, ?, NOW(), ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sss", $username, $ipAddress, $action);
    $stmt->execute();

    $stmt->close();
    $conexao->close();
}

function obterTotalContas() {
    $conexao = conectarBanco();

    $sql = "SELECT COUNT(*) as total FROM login";
    $resultado = $conexao->query($sql);
    
    if ($resultado) {
        $total = $resultado->fetch_assoc()['total'];
        return $total;
    } else {
        return 0;
    }
}

function cadastrar($usuario_c, $senha_c, $confirmarSenha_c, $email, $genero) {
    iniciarSessao();

    $conexao = conectarBanco();

    // Verificação do comprimento mínimo do usuário e da senha
    // Se o usuário ou a senha tiver menos de 4 caracteres, exibe um alerta e interrompe o processo de cadastro
    if (strlen($usuario_c) < 4 || strlen($senha_c) < 4) {
        exibirAlerta('O usuário e a senha devem ter pelo menos 4 dígitos.');
        return;
    }

    // Consulta ao banco de dados para verificar se o usuário ou o email já existem
    $sql = "SELECT * FROM login WHERE userid = ? OR email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $usuario_c, $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        exibirAlerta('O usuário ou o email já existem.');
        return;
    }

    // Converte o gênero para o formato esperado pelo banco de dados (M para homem, S para mulher)
    $genero = ($genero == "homem") ? "M" : "S";

    // Executa a instrução SQL para inserir um novo usuário na tabela 'login'
    $sql = "INSERT INTO login (userid, user_pass, email, sex, group_id) VALUES (?, ?, ?, ?, 0)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssss", $usuario_c, $senha_c, $email, $genero);
    $stmt->execute();

    if (defined('ENVIO_DISCORD_ATIVADO') && ENVIO_DISCORD_ATIVADO) {
    // Enviar mensagem para o servidor do Discord
    $mensagemDiscord = "Oba, agora temos uma nova conta criada! Total de contas: " . obterTotalContas();
    enviarMensagemDiscord($mensagemDiscord);
    }

    exibirAlerta('Cadastro realizado com sucesso!');
}

// Função para obter o gênero do usuário com base no nome de usuário
function obterGeneroDoUsuario($usuario) {
    $conexao = conectarBanco();

    // Consulta ao banco de dados para obter o gênero do usuário
    $sql = "SELECT sex FROM login WHERE userid = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row["sex"];
    }

    // Se não encontrar o usuário, você pode retornar um valor padrão ou lançar um erro, dependendo dos requisitos do seu aplicativo.
    return "M"; // Neste exemplo, retorna "M" se o usuário não for encontrado.
}

function obterGroupIdDoBancoDeDados($usuario) {
    $conexao = conectarBanco();

    // Consulta o banco de dados para obter o group_id do usuário
    $sql = "SELECT group_id FROM login WHERE userid = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($groupId);
    $stmt->fetch();
    $stmt->close();

    $conexao->close();

    return $groupId;
}

?>