<?php

include_once("config.inc.php");

if (isset($_POST['register'])) {
    // Receber dados do formulário
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $idade = $_POST['idade'];
    $curso = $_POST['curso'];
    $localidade = $_POST['localidade'];

    // Validar se os campos não estão vazios
    if (empty($username) || empty($email) || empty($password) || empty($idade) || empty($curso) || empty($localidade)) {
        echo "Todos os espaços devem ser preenchidos. ";
        echo "Tente Novamente.";
    } else {
        // Validar o email (opcional, mas é uma boa prática)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "E-mail inválido. ";
        } else {
            // Hash da senha para segurança
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Inserir os dados na tabela alunos
            $sql = "INSERT INTO alunos (username, email, password_hash, idade, curso, localidade)
                    VALUES ('$username', '$email', '$passwordHash', '$idade', '$curso', '$localidade')";

            // Executar a consulta SQL
            if ($conexao->query($sql) === TRUE) {
                echo "Cadastro realizado com sucesso!";
            } else {
                echo "Erro ao realizar o cadastro do aluno: " . $conexao->error;
            }
        }
    }
}
?>

<!-- Formulário de Cadastro -->
<h2>Cadastro</h2>
<form method="post" action="cadastro.php">
    <label for="username">Usuário:</label>
    <input type="text" name="username" id="username" required><br>

    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" required><br>
    
    <label for="password">Senha:</label>
    <input type="password" name="password" id="password" required><br>
    
    <label for="idade">Idade:</label>
    <input type="number" name="idade" id="idade" required><br>

    <label for="curso">Curso:</label>
    <input type="text" name="curso" id="curso" required><br>

    <label for="localidade">Local:</label>
    <input type="text" name="localidade" id="localidade" required><br>

    <button type="submit" name="register">Cadastrar</button>
</form>
