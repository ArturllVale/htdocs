<?php
// config.php
function verificar_login($usuario, $senha, $salvarUsuario) {
    // Conecte-se ao seu banco de dados aqui
    $conexao = new mysqli('localhost', 'ragnarok', 'ragnarok', 'ragnarok');

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    $sql = "SELECT * FROM login WHERE userid = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // O usuário existe, agora verifique a senha
        $usuario = $resultado->fetch_assoc();
        if ($senha == $usuario["user_pass"]) {
            // A senha está correta, inicie a sessão
            if(session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION["logado"] = true;
            $_SESSION["usuario"] = $usuario["userid"];

            // Se a caixa "Salvar Usuário?" estiver marcada, defina um cookie para o nome de usuário
            if ($salvarUsuario) {
                setcookie("usuario", $usuario["userid"], time() + (86400 * 30), "/"); // 86400 = 1 dia
            }

            return true;
        } else {
            // A senha está incorreta
            echo "<script>
                    alert('Senha incorreta. Tente novamente.');
                    window.location.href='index.php';
                  </script>";
            return false;
        }
    } else {
        // O usuário não existe
        echo "<script>
                alert('Usuário inexistente. Tente novamente.');
                window.location.href='index.php';
              </script>";
        return false;
    }
}

function cadastrar($usuario, $senha, $confirmarSenha, $email, $genero) {
    // Conecte-se ao seu banco de dados aqui
    $conexao = new mysqli('localhost', 'ragnarok', 'ragnarok', 'ragnarok');

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    // Verifique se o usuário e a senha têm pelo menos 4 dígitos
    if (strlen($usuario) < 4 || strlen($senha) < 4) {
        echo "<script>
                alert('O usuário e a senha devem ter pelo menos 4 dígitos.');
                window.location.href='cadastro.php';
              </script>";
        return;
    }

    // Verifique se o usuário ou o email já existem
    $sql = "SELECT * FROM login WHERE userid = ? OR email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $usuario, $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>
                alert('O usuário ou o email já existem.');
                window.location.href='cadastro.php';
              </script>";
        return;
    }

    // Converta o gênero para o formato esperado pelo banco de dados
    $genero = ($genero == "homem") ? "M" : "S";

    // Insira no banco de dados
    $sql = "INSERT INTO login (userid, user_pass, email, sex, group_id) VALUES (?, ?, ?, ?, 0)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssss", $usuario, $senha, $email, $genero);
    $stmt->execute();

    echo "<script>
            alert('Cadastro realizado com sucesso!');
            window.location.href='index.php';
          </script>";
}

?>
