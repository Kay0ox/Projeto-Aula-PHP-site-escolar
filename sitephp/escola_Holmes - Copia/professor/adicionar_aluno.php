<?php
session_start();
include_once("../includes/config.inc.php");

// ve se o usuario é professor
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Lista de turmas do professor 
$professor_id = $_SESSION['user_id'];
$sql_turmas = "SELECT * FROM turmas WHERE professor_id = $professor_id";
$result_turmas = $conexao->query($sql_turmas);

// alunos
$sql_alunos = "SELECT * FROM alunos WHERE role = 'aluno'";
$result_alunos = $conexao->query($sql_alunos);

// Adiciona aluno à turma
if (isset($_POST['adicionar'])) {
    $turma_id = $_POST['turma_id'];
    $aluno_id = $_POST['aluno_id'];

    $sql = "INSERT INTO alunos_turmas (turma_id, aluno_id) VALUES ($turma_id, $aluno_id)";
    if ($conexao->query($sql) === TRUE) {
        echo "Aluno adicionado à turma com sucesso!";
    } else {
        echo "Erro ao adicionar aluno: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Aluno</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include("templates/topo.php"); ?>
    <?php include("templates/menu.php"); ?>

    <h1>Adicionar Aluno a uma Turma</h1>
    <form method="post">
        <label>Selecione a Turma:</label>
        <select name="turma_id" required>
            <?php while ($turma = $result_turmas->fetch_assoc()) { ?>
                <option value="<?php echo $turma['id']; ?>"><?php echo $turma['nome']; ?></option>
            <?php } ?>
        </select><br>

        <label>Selecione o Aluno:</label>
        <select name="aluno_id" required>
            <?php while ($aluno = $result_alunos->fetch_assoc()) { ?>
                <option value="<?php echo $aluno['id']; ?>"><?php echo $aluno['username']; ?></option>
            <?php } ?>
        </select><br>

        <button type="submit" name="adicionar">Adicionar Aluno</button>
    </form>

    <?php include("templates/rodape.php"); ?>
</body>
</html>
