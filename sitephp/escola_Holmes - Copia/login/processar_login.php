<?php
include_once("../includes/config.inc.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe e sanitiza os dados do formulário
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password'])); // senha sem criptografia

    // Verifica se os campos não estão vazios
    if (empty($username) || empty($password)) {
        $error = "Por favor, preencha todos os campos!";
    } else {
        // Verifica no banco de dados se o usuário existe
        $query = "SELECT * FROM alunos WHERE username = ?";
        $stmt = $conexao->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obter os dados do usuário
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password_hash'];

            // Verifica se a senha está correta
            if (password_verify($password, $hashedPassword)) {
                // Armazena informações na sessão
                $_SESSION['username'] = $user['username'];
                $_SESSION['tipo'] = $user['tipo'];

                // Redireciona para a página correspondente conforme o tipo de usuário
                switch ($user['tipo']) {
                    case 'aluno':
                        header("Location: ../aluno/index.php");
                        exit;
                    case 'professor':
                        header("Location: ../professor/index.php");
                        exit;
                    case 'admin':
                        header("Location: ../admin/index.php");
                        exit;
                    default:
                        $error = "Tipo de usuário inválido!";
                        break;
                }
            } else {
                $error = "Senha incorreta!";
            }
        } else {
            $error = "Usuário não encontrado!";
        }
    }
}

// Exibe erro caso haja algum
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Faculdade Holmes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Faculdade Holmes</h1>
            <a href="../index.php" class="home-link">Página Inicial</a>
        </div>
    </header>

    <main>
        <h2>Login</h2>

        <!-- Exibir erro, caso haja -->
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="processar_login.php" method="POST">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="seuemail@email.com" required>
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="password" placeholder="Digite sua senha" required>
            
            <button type="submit" class="btn">Entrar</button>
        </form>
        <p>Não tem conta? <a href="../cadastro/cadastro.php">Cadastre-se aqui</a>.</p>
    </main>

    <footer>
        <p>&copy; 2024 Faculdade Holmes. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
