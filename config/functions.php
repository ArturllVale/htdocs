<?php
function conectarBanco()
{
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

function iniciarSessao()
{
    // Inicia a sessão se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function exibirAlerta($mensagem)
{
    // Exibe um alerta com a mensagem fornecida e redireciona para a página inicial
    echo "<script>
            alert('$mensagem');
            window.location.href='index.php';
          </script>";
}

function getLastLoginAttemptTime($usuario, $conexao)
{
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

function resetLoginAttempts($usuario, $conexao)
{
    $sql = "UPDATE security_log SET attempts = 0 WHERE username = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
}

function increaseLoginAttempts($usuario, $conexao)
{
    $sql = "UPDATE security_log SET attempts = attempts + 1 WHERE username = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
}

function verificar_login($usuario, $senha, $salvarUsuario)
{
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

function enviarMensagemDiscord($mensagem)
{
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
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
            )
        );

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

function logSecurityEvent($username, $ipAddress, $action)
{
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

function obterTotalContas()
{
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

function obterEnderecoIP()
{
    // Verifica se o usuário está por trás de um proxy
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function cadastrar($usuario_c, $senha_c, $confirmarSenha_c, $email, $genero)
{
    iniciarSessao();

    $conexao = conectarBanco();

    // Verificação do comprimento mínimo do usuário e da senha
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

    $genero = ($genero == "homem") ? "M" : "S";

    // Executa a instrução SQL para inserir um novo usuário na tabela 'login'
    $sql = "INSERT INTO login (userid, user_pass, email, sex, group_id) VALUES (?, ?, ?, ?, 0)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssss", $usuario_c, $senha_c, $email, $genero);
    $stmt->execute();

    // Registro na tabela security_log
    $enderecoIP = obterEnderecoIP();
    $logSql = "INSERT INTO security_log (username, ip_address, timestamp, action, attempts) VALUES (?, ?, NOW(), 'Conta Criada', 0)";
    $logStmt = $conexao->prepare($logSql);
    $logStmt->bind_param("ss", $usuario_c, $enderecoIP);
    $logStmt->execute();

    if (defined('ENVIO_DISCORD_ATIVADO') && ENVIO_DISCORD_ATIVADO) {
        $mensagemDiscord = "Oba, agora temos uma nova conta criada! Total de contas: " . obterTotalContas();
        enviarMensagemDiscord($mensagemDiscord);
    }

    exibirAlerta('Cadastro realizado com sucesso!');
}

// Função para obter o gênero do usuário com base no nome de usuário
function obterGeneroDoUsuario($usuario)
{
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

function obterGroupIdDoBancoDeDados($usuario)
{
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

use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function enviarLinkRecuperacao($email, $linkRecuperacao)
{
    // Instancie o objeto PHPMailer
    $mail = new PHPMailer(true);


    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Port = SMTP_PORT;

    // Configurações do e-mail
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64'; // ou 'quoted-printable'
    $mail->setFrom(EMAIL_FROM, SENDER_NAME);
    $mail->addAddress($email);
    $mail->Subject = 'Recuperar Senha MeuRO';
    $mail->Body = 'Olá,';
    $mail->Body .= '<p>Clique no link a seguir para recuperar sua senha:</p>';
    $mail->Body .= '<p><a href="' . $linkRecuperacao . '">Clique Aqui</a> para recuperar sua senha</p>';
    $mail->Body .= '<p>Atenciosamente,</p>';
    $mail->Body .= '<p>Meu RO Online</p>';


    // Envia o e-mail
    $mail->send();

}

function recuperarSenha($email, $confirmarEmail)
{
    $conexao = conectarBanco();

    // Verifica se a conexão com o banco de dados foi estabelecida
    if ($conexao === null) {
        die("Erro na conexão com o banco de dados.");
    }

    // Verifica se os campos de e-mail coincidem
    if ($email !== $confirmarEmail) {
        $_SESSION["erro_recuperar_senha"] = 'Os campos de e-mail não coincidem.';
        header("Location: recuperar.php");
        exit();
    }

    // Consulta ao banco de dados para verificar se o e-mail existe
    $sql = "SELECT * FROM login WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        $_SESSION["erro_recuperar_senha"] = 'O e-mail fornecido não está registrado.';
        header("Location: recuperar.php");
        exit();
    }

    // Gera um token único para a recuperação de senha
    $token = gerarToken();

    // Atualiza a tabela login com o token gerado e a flag web_auth_token_enabled para 0
    $sqlUpdateToken = "UPDATE login SET web_auth_token = ?, web_auth_token_enabled = 0 WHERE email = ?";
    $stmtUpdateToken = $conexao->prepare($sqlUpdateToken);
    $stmtUpdateToken->bind_param("ss", $token, $email);
    $stmtUpdateToken->execute();

    // Configurações do link de recuperação
    $linkRecuperacao = SITE_URL . "/recuperar_senha.php?token=$token";

    // Envia o e-mail com o link de recuperação
    enviarLinkRecuperacao($email, $linkRecuperacao);

    // Mensagem de sucesso
    $_SESSION["sucesso_recuperar_senha"] = 'Um e-mail de recuperação foi enviado. Verifique sua caixa de entrada.';

    // Exibe a mensagem de sucesso como um pop-up e redireciona para a página index
    echo '<script>alert("' . $_SESSION["sucesso_recuperar_senha"] . '"); window.location.href = "index.php";</script>';


    // Verifica se a mensagem de sucesso está presente na sessão
    if (isset($_SESSION["sucesso_recuperar_senha"])) {
        // Exibe a mensagem usando JavaScript para mostrar um popup
        echo '<script>alert("' . $_SESSION["sucesso_recuperar_senha"] . '");</script>';
        // Limpa a variável de sessão
        unset($_SESSION["sucesso_recuperar_senha"]);
    }

    exit();
}

function gerarToken()
{
    // Obtém uma string única baseada no tempo atual em microssegundos
    $token = uniqid();

    // Gera um token único para a recuperação de senha
    $token = substr(hash('sha256', random_bytes(32)), 0, 17);

    return $token;
}

function verificarToken($token)
{
    iniciarSessao();

    $conexao = conectarBanco();

    // Verifica se a conexão com o banco de dados foi estabelecida
    if ($conexao === null) {
        return false;
    }

    // Busca o email associado ao token na tabela login
    $stmtToken = $conexao->prepare("SELECT web_auth_token_enabled FROM login WHERE web_auth_token = ?");
    $stmtToken->bind_param("s", $token);
    $stmtToken->execute();
    $resultToken = $stmtToken->get_result();

    // Verifica se o token existe
    if ($resultToken->num_rows === 0) {
        // Token não encontrado, trata como erro
        return false;
    }

    // Obtém o valor de web_auth_token_enabled associado ao token
    $rowToken = $resultToken->fetch_assoc();
    $web_auth_token_enabled = $rowToken['web_auth_token_enabled'];

    return $web_auth_token_enabled;
}

function atualizarSenhaComToken($token, $novaSenha)
{
    iniciarSessao();

    $conexao = conectarBanco();

    // Verifica se a conexão com o banco de dados foi estabelecida
    if ($conexao === null) {
        return false;
    }

    // Busca o email associado ao token na tabela login
    $stmtToken = $conexao->prepare("SELECT email FROM login WHERE web_auth_token = ? AND web_auth_token_enabled = 0");
    $stmtToken->bind_param("s", $token);
    $stmtToken->execute();
    $resultToken = $stmtToken->get_result();

    // Verifica se o token existe e não foi utilizado
    if ($resultToken->num_rows === 0) {
        // Token não encontrado ou já utilizado, trata como erro
        return false;
    }

    // Obtém o email associado ao token
    $rowToken = $resultToken->fetch_assoc();
    $email = $rowToken['email'];

    // Atualiza a senha na tabela login com base no email
    $stmtSenha = $conexao->prepare("UPDATE login SET user_pass = ? WHERE email = ?");

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmtSenha === false) {
        return false;
    }

    // Atualiza a senha na tabela login sem gerar a senha hash
    $stmtSenha->bind_param("ss", $novaSenha, $email);
    $resultado = $stmtSenha->execute();

    // Verifica se a execução foi bem-sucedida
    if ($resultado) {
        // Atualiza a flag web_auth_token_enabled para indicar que o token foi utilizado
        $stmtAtualizarToken = $conexao->prepare("UPDATE login SET web_auth_token_enabled = 1 WHERE email = ?");
        $stmtAtualizarToken->bind_param("s", $email);
        $stmtAtualizarToken->execute();

        return true;
    } else {
        return false;
    }
}

function redefinirSenha($senha, $confirmarSenha, $token)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submit']) && $_POST['submit'] == 'redefinirSenha') {
            $senha = $_POST["senha"];
            $confirmarSenha = $_POST["confirmarSenha"];
            $token = $_POST["token"];

            // Adicione lógica para verificar o valor de web_auth_token_enabled
            $web_auth_token_enabled = verificarToken($token);

            if ($web_auth_token_enabled == 1) {
                // Exibe um alerta e redireciona para a página index
                echo '<script>alert("O link de redefinição de senha já foi utilizado."); window.location.href = "index.php";</script>';
                exit();
            }
            // Verifica se a senha tem mais de 4 dígitos
            if (strlen($senha) <= 4) {
                $_SESSION["erro_redefinir_senha"] = 'A senha deve ter mais de 4 dígitos.';
                echo '<script>alert("' . $_SESSION["erro_redefinir_senha"] . '");</script>';
                return;
            }

            // Verifica se as senhas coincidem
            if ($senha !== $confirmarSenha) {
                $_SESSION["erro_redefinir_senha"] = 'As senhas não coincidem.';
            } else {
                // Adicione lógica para atualizar a senha na tabela correta com base no token
                $atualizacaoSucesso = atualizarSenhaComToken($token, $senha);

                if ($atualizacaoSucesso) {
                    // Mensagem de sucesso
                    $_SESSION["sucesso_redefinir_senha"] = 'Senha alterada com sucesso. Faça login com a nova senha.';
                    // Exibe a mensagem de sucesso como um pop-up e redireciona para a página de login
                    echo '<script>alert("' . $_SESSION["sucesso_redefinir_senha"] . '"); window.location.href = "login.php";</script>';
                } else {
                    $_SESSION["erro_redefinir_senha"] = 'Erro ao redefinir a senha. Tente novamente.';
                    // Exibe a mensagem de erro como um pop-up
                    echo '<script>alert("' . $_SESSION["erro_redefinir_senha"] . '");</script>';
                }
            }
        }
    }
}

?>