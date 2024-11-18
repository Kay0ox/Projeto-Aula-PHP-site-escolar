<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina(); // barra quem não for professor(ou tenta)

// verifica se ele é um professoer ou não
if ($_SESSION['tipo'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Professor</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include("../templates/topo.php"); ?>
    <?php include("../templates/menu.php"); ?>

    <h1>Bem-vindo a area do Professor</h1>
    <p>Use o menu abaixo para acessar suas funcionalidades:</p>

    <section>
        <h2>Funcionalidades</h2>
        <ul>
            <li><a href="#">Listar de alunos</a></li>
            <li><a href="#"></a></li>
            <li><a href="#">criar turmas</a></li>
            <li><a href="#"></a></li>
        </ul>
    </section>

    <?php include("../templates/rodape.php"); ?>
</body>
</html>
