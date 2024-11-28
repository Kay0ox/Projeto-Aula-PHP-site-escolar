<?php
session_start();
include_once("../includes/config.inc.php");

// dnv as msm informaçoes de segurança e aqui ele atualiza as informaçoes do aluno 
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}
if (isset($_GET['id'])){
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM alunos WHERE id = $id";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Aluno não encontrado!";
        exit();
    }
}

if (isset($_post['update'])) {
    $username = $_post['username'];
    $email = $_post['email'];
    $idade = $_post['idade'];
    $curso = $_post['curso'];
    $localidade = $_post['localidade'];

    $sql = "UPDATE alunos  SET username='$username',email='$email', idade='$idade', curso='$curso', localidade='$localidade' HHERE id=$id";

    if ($conexao->query($sql) === TRUE){
        echo "Aluno atualizado com sucesso!";
        header("local: lista_alunos.php");
        exit();
    }else {
        echo "Erro ao atualizar o Aluno: " . $conexao->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alunos</title>
</head>
<body>
<?php include("templates/topo.php"); ?>
<?php include("templates/menu.php"); ?>
<h1>Editar alunos</h1>
<form method="post">
    <label >Aluno:</label>
    <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>

    <label >E-mail:</label>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
    
    <label >Idade:</label>
    <input type="number" name="idade" value="<?php echo $user['idade']; ?>" required><br>

    <label >Curso:</label>
    <input type="text" name="curso" value="<?php echo $user['curso']; ?>" required><br>

    <label >Local:</label>
    <input type="text" name="localidade" value="<?php echo $user['localidade']; ?>" required><br>

    <button type="submit" name="update">atualizar</button>
</form>
<?php include("templates/rodape.php"); ?>
</body>
</html>