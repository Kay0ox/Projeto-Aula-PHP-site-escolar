<?php

    include_once("../config.inc.php");

    $id = $_REQUEST['id'];
    $nome = $_REQUEST['nome'];
    $email = $_REQUEST['email'];
    $telefone = $_REQUEST['telefone'];
    $cidade = $_REQUEST['cidade'];
    $estado = $_REQUEST['estado'];

    $sql = "UPDATE cliente SET
    nome = '$nome',email = '$email',telefone = '$telefone',
    cidade = '$cidade',estado = '$estado' WHERE id = $id";

    $query = mysqli_query($conexao,$sql);

    if($query){
        echo "<h2>Cliente alterado com sucesso.";
    }

    mysqli_close($conexao);