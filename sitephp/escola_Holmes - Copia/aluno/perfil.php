<?php

include_once("../includes/config.inc.php");
include_once("../includes/config.inc.php");

protegePagina();

if ($_SESSION['tipo'] != 'aluno'){
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu perfil</title>
</head>
<body>
<?php include 'templates/menu.php'; ?>
<div class="content">
    <h1>Meu Perfil</h1>
    <p><strong>Nome de Usuário:</strong> <?= $aluno['username']; ?></p>
    <p><strong>Email:</strong> <?= $aluno['email']; ?></p>
    <form action="atualizar_perfil.php" method="POST">
        <button type="submit" name="editar_perfil">Editar Perfil</button>
    </form>
</div>
</body>
</html>