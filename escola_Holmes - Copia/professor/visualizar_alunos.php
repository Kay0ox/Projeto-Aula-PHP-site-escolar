<?php
session_start();
include_once("../includes/config.inc.php");

// Verifica se o usuário é professor
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Consulta para buscar todos os alunos
$sql = "SELECT id, username, email, idade, curso, localidade FROM alunos WHERE role = 'aluno'";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Alunos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include("templates/topo.php"); ?>
    <?php include("templates/menu.php"); ?>

    <h1>Lista de Alunos</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Idade</th>
            <th>Curso</th>
            <th>Localidade</th>
        </tr>
        <?php while ($aluno = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $aluno['id']; ?></td>
            <td><?php echo $aluno['username']; ?></td>
            <td><?php echo $aluno['email']; ?></td>
            <td><?php echo $aluno['idade']; ?></td>
            <td><?php echo $aluno['curso']; ?></td>
            <td><?php echo $aluno['localidade']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <?php include("templates/rodape.php"); ?>
</body>
</html>
