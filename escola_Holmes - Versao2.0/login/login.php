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
    <style>
        /* Estilos Gerais */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        .navbar .home-link {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            margin-top: 5px;
            display: inline-block;
        }

        .navbar .home-link:hover {
            text-decoration: underline;
        }

        main {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 1rem;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            font-size: 0.9rem;
            margin-top: 15px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #f8f9fa;
            margin-top: 20px;
            font-size: 0.9rem;
        }
    </style>
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
            <input type="email" name="email" id="email" placeholder="seuemail@email.com" required>

            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" placeholder="Digite sua senha" required>

            <button type="submit">Entrar</button>
        </form>

        <p>Ainda não tem uma conta? <a href="../cadastro/cadastro.php">Clique aqui para se cadastrar</a></p>
    </main>

    <footer>
        <p>&copy; 2024 Faculdade Holmes. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
