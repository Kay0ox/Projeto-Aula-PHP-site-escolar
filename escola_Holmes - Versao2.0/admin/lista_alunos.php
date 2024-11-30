<?php
session_start();
include_once("../includes/config.inc.php");
//aqui é o copia e cola dos outros na parte da segurança, ainda n fiz essa pagina e nem o link mas jaja eu chego lá
if (!isset($_SESSION['role'])|| $_SESSION['role'] != 'admin'){
    header("local: ../login/login.php");
    exit();
}
$sql = "SELECT id, username, email, idade, curso, localidade, role FROM alunos";
$result = $conexao->query($sql);
// eu esqueci o comando de falar no html oh
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <linl rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include("templates/topo.php"); ?>
<?php include("templates/menu.php"); ?>
<h1>Lista de Alunos</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>email</th>
        <th>Idade</th>
        <th>curso</th>
        <th>Localidade</th>
        <th>Tipo</th>
        <th>Açoes</th>
</tr>
<?php while ($user = $result ->fetch_assoc()){ ?>
<tr>
    <td><?php echo $user['id']; ?></td>
    <td><?php echo $user['username']; ?></td>
    <td><?php echo $user['email']; ?></td>
    <td><?php echo $user['email']; ?></td>
    <td><?php echo $user['idade']; ?></td>
    <td><?php echo $user['curso']; ?></td>
    <td><?php echo $user['localidade']; ?></td>
    <td><?php echo $user['role']; ?></td>
    <td>
        <a href="mudar_alunos.php?id=<?php echo $user['id']; ?>">Editar</a>|
        <a href="excluir_alunos.php?id=<?php echo $user['id']; ?> onclick="return confirm('Realmente deseja excluir?');">Excluir</a>

    </td>
</tr>
<?php } ?> 
</table>
<?php include("templates/rodape.php"); ?>
</body>
</html>