<?php
session_start();
include_once("../includes/config.inc.php");

// ve se ele é professor
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Busca turmas do professor que logou
$professor_id = $_SESSION['user_id'];
$sql_turmas = "SELECT * FROM turmas WHERE professor_id = $professor_id";
$result_turmas = $conexao->query($sql_turmas);

// Mostra os alunos de uma turma selecionada
if (isset($_GET['turma_id'])) {
    $turma_id = $_GET['turma_id'];
    $sql_alunos = "
        SELECT at.id AS relacao_id, a.username, a.email, at.nota
        FROM alunos_turmas at
        JOIN alunos a ON at.aluno_id = a.id
        WHERE at.turma_id = $turma_id
    ";
    $result_alunos = $conexao->query($sql_alunos);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Turma</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include("templates/topo.php"); ?>
    <?php include("templates/menu.php"); ?>

    <h1>Visualizar Turmas</h1>
    <ul>
        <?php while ($turma = $result_turmas->fetch_assoc()) { ?>
            <li>
                <a href="?turma_id=<?php echo $turma['id']; ?>"><?php echo $turma['nome']; ?></a>
            </li>
        <?php } ?>
    </ul>

    <?php if (isset($result_alunos)) { ?>
        <h2>Alunos da Turma</h2>
        <table border="1">
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Nota</th>
            </tr>
            <?php while ($aluno = $result_alunos->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $aluno['username']; ?></td>
                    <td><?php echo $aluno['email']; ?></td>
                    <td><?php echo $aluno['nota']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>

    <?php include("templates/rodape.php"); ?>
</body>
</html>
