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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Painel do Aluno</h1>
            <a href="../index.php">Sair</a>
        </div>
    </header>  

    <main>
        <h2>Bem-vindo, <?= $aluno['username']; ?>!</h2>

        <!-- Informações do Aluno -->
        <section>
            <h3>Informações do Aluno</h3>
            <p><strong>Nome de Usuário:</strong> <?= $aluno['username']; ?></p>
            <p><strong>Email:</strong> <?= $aluno['email']; ?></p>
            <p><strong>Senha Hash:</strong> <?= $aluno['password_hash']; ?></p>
        </section>

        <!-- Informações do Curso -->
        <section>
            <h3>Informações do Curso</h3>
            <?php if (!empty($aluno['curso'])): ?>
                <p><strong>Curso:</strong> <?= $aluno['curso']; ?></p>
            <?php else: ?>
                <p>Você ainda não está matriculado em nenhum curso.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Faculdade Holmes. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
