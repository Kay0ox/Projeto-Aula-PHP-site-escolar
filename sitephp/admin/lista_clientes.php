<h2>Lista de Clientes</h2>

<p><a href="?pg=form_cliente">Cadastrar Novo Cliente</a></p>

<?php

    include_once("../config.inc.php");

    $sql = mysqli_query($conexao,"SELECT * FROM cliente");

    while($cliente = mysqli_fetch_array($sql)){
        echo "Nome: $cliente[nome] <br>";
        echo "E-mail: $cliente[email] <br>";
        echo "Telefone: $cliente[telefone] <br>";
        echo "Cidade: $cliente[cidade] <br>";
        echo "Estado: $cliente[estado] <br>";
        echo "<a href=?pg=excluir_cliente&id=$cliente[id]><b>[X] Excluir</b></a>";
        echo "<a href=?pg=form_altera_cliente&id=$cliente[id]><b>[v] Alterar</b></a>";
        echo "<hr>";
    }

    if(!$sql){
        echo "Não foi possível ler as mensagens.";
    }

    mysqli_close($conexao);