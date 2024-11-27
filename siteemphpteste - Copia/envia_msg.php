<?php

    include_once("config.inc.php");

    $nome = $_REQUEST['nome'];
    $email = $_REQUEST['email'];
    $assunto = $_REQUEST['assunto'];
    $mensagem = $_REQUEST['mensagem'];

    $sql = "INSERT INTO contato 
            (nome,email,assunto,mensagem) VALUES
            ('$nome','$email','$assunto','$mensagem')
            ";

    $query = mysqli_query($conexao,$sql);

    if($query){
        echo "<h3> Mensagem enviada com sucesso.</h3>";
    }else{
        echo "<h3>Erro ao enviar mensagem.</h3>";
    }

    mysqli_close($conexao);