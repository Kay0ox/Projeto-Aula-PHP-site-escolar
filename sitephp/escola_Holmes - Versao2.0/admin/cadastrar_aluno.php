<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina(); // Protege a página

// Verifica se o usuário é admin
if ($_SESSION['tipo'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

// Processa o formulário de cadastro de aluno
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_aluno'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Verifica se todos os campos foram preenchidos
    if (empty($username) || empty($email) || empty($password)) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
        // Verifica se o e-mail já existe no banco de dados
        $query_check_email = "SELECT id FROM alunos WHERE email = ?";
        $stmt_check_email = $conexao->prepare($query_check_email);
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->get_result();

        if ($result_check_email->num_rows > 0) {
            $erro = "Este e-mail já está cadastrado. Tente outro.";
        } else {
            // Criptografa a senha
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insere o novo aluno no banco de dados
            $query = "INSERT INTO alunos (username, email, password_hash, tipo) VALUES (?, ?, ?, 'aluno')";
            $stmt = $conexao->prepare($query);
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $sucesso = "Aluno cadastrado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar aluno.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, button {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 0.9rem;
        }

        .success {
            color: green;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Cadastrar Novo Aluno</h1>
            <a href="index.php">Voltar ao Painel</a>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>Novo Aluno</h2>

            <?php if (isset($erro)): ?>
                <p class="error"><?= $erro; ?></p>
            <?php elseif (isset($sucesso)): ?>
                <p class="success"><?= $sucesso; ?></p>
            <?php endif; ?>

            <form action="cadastrar_aluno.php" method="POST">
                <input type="text" name="username" placeholder="Nome de usuário" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Senha" required>
                <button type="submit" name="cadastrar_aluno">Cadastrar</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Faculdade Holmes. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
