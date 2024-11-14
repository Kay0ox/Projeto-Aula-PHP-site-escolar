<?php

    include_once("../config.inc.php");

    $nome = $_REQUEST['nome'];
    $email = $_REQUEST['email'];
    $telefone = $_REQUEST['telefone'];
    $cidade = $_REQUEST['cidade'];
    $estado = $_REQUEST['estado'];

    $sql = "INSERT INTO cliente 
    (nome,email,telefone,cidade,estado) VALUES
    ('$nome','$email','$telefone','$cidade','$estado')";

    $query = mysqli_query($conexao,$sql);

    if($query){
        echo "<h2>Cliente cadastrado com sucesso.";
    }

    mysqli_close($conexao);