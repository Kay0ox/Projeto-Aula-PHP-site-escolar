<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina();

// Verifica se o usuário é professor
if ($_SESSION['tipo'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Corrigir consulta SQL, substituindo 'role' por 'tipo'
$sql = "SELECT id, username, email, idade, curso, localidade, tipo FROM alunos";
$result = $conexao->query($sql);

if (!$result) {
    die("Erro na consulta ao banco de dados: " . $conexao->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include("templates/topo.php"); ?>
<?php include("templates/menu.php"); ?>
<h1>Lista de Alunos</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Usuário</th>
        <th>Email</th>
        <th>Idade</th>
        <th>Curso</th>
        <th>Localidade</th>
        <th>Tipo</th>
        <th>Ações</th>
    </tr>
    <?php while ($user = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['username']; ?></td>
        <td><?php echo $user['email']; ?></td>
        <td><?php echo $user['idade']; ?></td>
        <td><?php echo $user['curso']; ?></td>
        <td><?php echo $user['localidade']; ?></td>
        <td><?php echo $user['tipo']; ?></td>
        <td>
            <a href="mudar_alunos.php?id=<?php echo $user['id']; ?>">Editar</a> |
            <a href="excluir_alunos.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Realmente deseja excluir?');">Excluir</a>
        </td>
    </tr>
    <?php } ?>
</table>
<?php include("templates/rodape.php"); ?>
</body>
</html>
