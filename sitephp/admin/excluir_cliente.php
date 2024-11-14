<?php

    include_once("../config.inc.php");

    $id = $_REQUEST['id'];

    $sql = mysqli_query($conexao,"DELETE FROM cliente WHERE id = $id");

    mysqli_close($conexao);

    echo "<h2>Cliente excluído.</h2>";