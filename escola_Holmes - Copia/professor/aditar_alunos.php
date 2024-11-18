<?php
session_start();
include_once("../includes/config.inc.php");

// Verifica se o usuario é professor
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Busca os dados do professor logado
$id = $_SESSION['user_id'];
$sql = "SELECT * FROM alunos WHERE id = $id";
$result = $conexao->query($sql);
$professor = $result->fetch_assoc();

// Atualiza os dados do perfil
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $idade = $_POST['idade'];
    $curso = $_POST['curso'];
    $localidade = $_POST['localidade'];

    $sql = "UPDATE alunos SET username='$username', email='$email', idade='$idade', curso='$curso', localidade='$localidade' WHERE id=$id";

    if ($conexao->query($sql) === TRUE) {
        echo "Perfil atualizado com sucesso!";
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar perfil: " . $conexao->error;
    }
}
//isso tá mt feio bouy
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include("templates/topo.php"); ?>
    <?php include("templates/menu.php"); ?>

    <h1>Editar Perfil</h1>
    <form method="post">
        <label>Usuário:</label>
        <input type="text" name="username" value="<?php echo $professor['username']; ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $professor['email']; ?>" required><br>

        <label>Idade:</label>
        <input type="number" name="idade" value="<?php echo $professor['idade']; ?>" required><br>

        <label>Curso:</label>
        <input type="text" name="curso" value="<?php echo $professor['curso']; ?>" required><br>

        <label>Localidade:</label>
        <input type="text" name="localidade" value="<?php echo $professor['localidade']; ?>" required><br>

        <button type="submit" name="update">Atualizar</button>
    </form>

    <?php include("templates/rodape.php"); ?>
</body>
</html>
