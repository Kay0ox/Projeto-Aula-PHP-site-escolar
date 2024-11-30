<?php 
// Inclui as configurações do sistema e valida a sessão
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina(); // Protege a página contra acessos não autorizados

// Verifica se o usuário logado é realmente um aluno
if ($_SESSION['tipo'] != 'aluno') {
    header("Location: ../login/login.php");
    exit();
}

// Pega o username do aluno logado e busca seus dados no banco
$username = $_SESSION['username'];
$queryAluno = "SELECT * FROM alunos WHERE username = ?";
$stmtAluno = $conexao->prepare($queryAluno);
$stmtAluno->bind_param("s", $username);
$stmtAluno->execute();
$resultAluno = $stmtAluno->get_result();

if ($resultAluno->num_rows > 0) {
    $aluno = $resultAluno->fetch_assoc(); // Dados do aluno
} else {
    echo "Erro ao carregar os dados do aluno.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Aluno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        header {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
        }
        .navbar h1 {
            margin: 0;
            display: inline-block;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            float: right;
            margin-top: 5px;
        }
        main {
            padding: 20px;
        }
        h2, h3 {
            color: #007BFF;
        }
        p {
            margin: 5px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        footer {
            text-align: center;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Painel do Aluno</h1>
            <a href="../index.php">Sair</a>
        </div>
    </header>  

    <main>
        <h2>Bem-vindo, <?= htmlspecialchars($aluno['username']); ?>!</h2>

        <!-- Informações do Aluno -->
        <section>
            <h3>Informações do Aluno</h3>
            <p><strong>Nome de Usuário:</strong> <?= htmlspecialchars($aluno['username']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($aluno['email']); ?></p>
        </section>

        <!-- Informações do Curso -->
        <section>
            <h3>Informações do Curso</h3>
            <?php if (!empty($aluno['curso'])): ?>
                <p><strong>Curso:</strong> <?= htmlspecialchars($aluno['curso']); ?></p>
            <?php else: ?>
                <p>Você ainda não está matriculado em nenhum curso.</p>
            <?php endif; ?>
        </section>

        <!-- Link para Ver Notas -->
        <section>
            <h3>Acessos Rápidos</h3>
            <a href="ver_notas.php" class="btn">Ver Notas</a>
            <a href="chat.php" class="btn">Chat</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Faculdade Holmes. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
