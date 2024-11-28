<?php
include_once("../includes/config.inc.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe o e-mail e a senha do formulário
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password'])); // Senha sem criptografia

    if (empty($email) || empty($password)) {
        $error = "Por favor, preencha todos os campos!";
    } else {
        // Consulta o banco de dados para verificar se o e-mail existe
        $query = "SELECT * FROM alunos WHERE email = ?";
        $stmt = $conexao->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtém os dados do usuário
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password_hash'];

            // Verifica se a senha está correta
            if (password_verify($password, $hashedPassword)) {
                // Armazena informações na sessão
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $email;
                $_SESSION['tipo'] = $user['tipo'];

                // Redireciona para a página correspondente
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
                }
            } else {
                $error = "Senha incorreta!";
            }
        } else {
            $error = "E-mail não encontrado ou usuário não existe!";
        }
    }
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

        <!-- Exibe a mensagem de erro, caso haja -->
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

        <form action="login.php" method="POST">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" placeholder="seuemail@email.com" required><br>

            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" placeholder="Digite sua senha" required><br>

            <button type="submit">Entrar</button>
        </form>

        <p>Ainda não tem uma conta? <a href="../cadastro/cadastro.php">Clique aqui para se cadastrar</a></p>
    </main>

    <footer>
        <p>&copy; 2024 Faculdade Holmes. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
