<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina();

if ($_SESSION['tipo'] != 'aluno') {
    header("Location: ../login/login.php");
    exit();
}

$username = $_SESSION['username'];
$queryAluno = "SELECT * FROM alunos WHERE username = ?";
$stmtAluno = $conexao->prepare($queryAluno);
$stmtAluno->bind_param("s", $username);
$stmtAluno->execute();
$resultAluno = $stmtAluno->get_result();

if ($resultAluno->num_rows > 0) {
    $aluno = $resultAluno->fetch_assoc();
} else {
    echo "Erro ao carregar os dados do aluno.";
    exit();
}

$queryCursos = "SELECT * FROM cursos WHERE aluno_id = ?";
$stmtCursos = $conexao->prepare($queryCursos);
$stmtCursos->bind_param("i", $aluno['id']);
$stmtCursos->execute();
$resultCursos = $stmtCursos->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas e Notas</title>
</head>
<body>
    <?php include 'templates/menu.php'; ?>
    <div class="content">
        <h1>Turmas e Notas</h1>
        <?php if ($resultCursos->num_rows > 0): ?>
            <ul>
                <?php while ($curso = $resultCursos->fetch_assoc()): ?>
                    <li>
                        <?= $curso['nome']; ?> - <a href="detalhes_curso.php?id=<?= $curso['id']; ?>">Ver detalhes</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Você ainda não está matriculado em nenhum curso.</p>
        <?php endif; ?>
    </div>
</body>
</html>
