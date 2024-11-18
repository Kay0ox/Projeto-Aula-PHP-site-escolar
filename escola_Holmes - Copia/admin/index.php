<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina(); // Protege a pagina para malandro n invadir(ou tenta)

// essa funçao serve para saber se o tipo lá do bd é o msm do login assim sabendo se é admin ou n (aqui eu fui inteligente viu)
if ($_SESSION['tipo'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include("../templates/topo.php"); ?>
    <?php include("../templates/menu.php"); ?>

    <h1>Bem-vindo ao Painel de Administração</h1>
    <p>Aqui você pode gerenciar usuários, ver relatórios e configurar o sistema.</p>

    <p><a href="gerenciar_usuarios.php">Gerenciar Usuários</a></p>
    <p><a href="relatorios.php">Visualizar Relatórios de notas</a></p>

    <?php include("../templates/rodape.php"); ?>
</body>
</html>
