<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'ragnarok');
define('DB_PASSWORD', 'ragnarok');
define('DB_NAME', 'ragnarok');

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

            if ($salvarUsuario) {
                setcookie("usuario", $usuario["userid"], time() + (86400 * 30), "/");
            }

            return true;
        } else {
            exibirAlerta('Usuário ou Senha incorretos. Tente novamente!');
            return false;
        }
    } else {
        exibirAlerta('Usuário ou Senha incorretos. Tente novamente!');
        return false;
    }
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

    exibirAlerta('Cadastro realizado com sucesso!');
}

?>