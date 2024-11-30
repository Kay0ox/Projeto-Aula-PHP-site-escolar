<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd2";

// Cria conexão
$conexao = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
?>
