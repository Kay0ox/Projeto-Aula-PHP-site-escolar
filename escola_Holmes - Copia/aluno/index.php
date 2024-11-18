<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");  // lembrar que a parte da seguraça tá na pasta include/sessao

protegePagina(); // protege a pagina para malandro n invadir 


if ($_SESSION['tipo'] != 'aluno') {
    header("Location: ../login/login.php");
    exit();
}
?>

<h2>Área do Aluno</h2>
<p>Bem-vindo à sua área de aluno!</p>

<!-- fiz nada ainda  -->
