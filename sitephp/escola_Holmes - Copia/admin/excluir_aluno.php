<?php
session_start();
include_once("../includes/config.inc.php");


if (!isset($_SESSION['role'])|| $_SESSION['role'] != 'admin'){
    header("local: ../login/login.php");
    exit();
}
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($conexao->query($sql) === TRUE) {
        echo "Usuario excluido";
        header("local: lista_alunos.php");
        exit();
    }else {
        echo "Erro ao excluir o aluno: " . $conexao->error;
    }
} else {
    echo "ID invalido";
}
?>