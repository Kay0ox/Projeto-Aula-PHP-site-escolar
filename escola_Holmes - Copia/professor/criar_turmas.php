<?php
session_start();
include_once("../includes/config.inc.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

if (isset($_POST['criar'])) {
    $nome = $_POST['nome'];
    $periodo = $_POST['periodo'];
    $professor_id = $_SESSION['user_id'];
    
    
    $sql = "INSERT INTO turmas (nome, professor_id, periodo) VALUES ('$nome', '$professor_id', '$periodo')";
    if ($conexao->query($sql) === TRUE) {
        echo "Turma criada com sucesso";
    }else{
        echo "Erro ao criar turmas: " . $conexao->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Turmas</title>
    <link rel="stylesheet" href="../assets/css/styley.css">
</head>
<body>
<?php include("templates/topo.php"); ?>
    <?php include("templates/menu.php"); ?>

    <h1>Criar Nova Turma</h1>
    <form method="post">
        <label>Nome da Turma:</label>
        <input type="text" name="nome" required><br>

        <label>Período:</label>
        <input type="text" name="periodo" required><br>

        <button type="submit" name="criar">Criar Turma</button>
    </form>

    <?php include("templates/rodape.php"); ?>
</body>
</html>