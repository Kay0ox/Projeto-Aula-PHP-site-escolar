<?php
include_once("../includes/config.inc.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitiza os dados do formulário
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Verifica se os campos estão preenchidos
    if (empty($email) || empty($password)) {
        $error = "Por favor, preencha todos os campos!";
    } else {
        // Consulta o banco de dados pelo email
        $query = "SELECT * FROM alunos WHERE email = ?";
        $stmt = $conexao->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password_hash'];

            // Verifica a senha
            if (password_verify($password, $hashedPassword)) {
                // Armazena dados na sessão
                $_SESSION['id'] = $user['id']; // Necessário para o sistema
                $_SESSION['username'] = $user['username'];
                $_SESSION['tipo'] = $user['tipo'];

                // Redireciona com base no tipo de usuário
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
                $error = "Credenciais inválidas. Tente novamente.";
            }
        } else {
            $error = "Credenciais inválidas. Tente novamente.";
        }
    }
}

// Exibe erro na página
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
