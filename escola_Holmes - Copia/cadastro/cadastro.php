<?php
include_once("../includes/config.inc.php");

if (isset($_POST['register'])) {
    // Recebe os dados do formulário
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tipo = $_POST['tipo']; 

   //aqui ele ve se os campos estão preenchidos
    if (empty($username) || empty($email) || empty($password)) {
        echo "Todos os campos são obrigatórios!";
    } else {
        // ve se o gmail tá cadastrado no bd
        $sql_check_email = "SELECT * FROM alunos WHERE email = '$email'";
        $result = $conexao->query($sql_check_email);

        if ($result->num_rows > 0) {
            echo "O e-mail já está cadastrado!";
        } else {
            // Criptografa a senha e ninguem consegue ver qual é (passsei mt tempo nisso )
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
//NÃO MEXER EM NADA DISSO O CHAT GPT N AJUDOU EM ND E EU NÃO SEI COMO EU FIZ FUNCIONAR (NÃO MEXERRRRRRRR TÁ FUNCIONADO NA FÉ DE DEUS, AMEM.)
            // manda os dados para o banco de dados (com a senha criptografada (o codigo da senha criptografada é o password_hash obg indiano do youtube))
            $sql = "INSERT INTO alunos (username, email, password_hash, tipo) VALUES ('$username', '$email', '$password_hash', '$tipo')";
            if ($conexao->query($sql) === TRUE) {
                echo "Cadastro realizado com sucesso!";
            } else {
                echo "Erro ao cadastrar: " . $conexao->error;
            }
        }
    }
}
?>

<h2>Cadastro</h2>
<form method="post" action="cadastro.php">
    <label for="username">Nome de Usuário:</label>
    <input type="text" name="username" id="username" required><br>

    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" required><br>

    <label for="password">Senha:</label>
    <input type="password" name="password" id="password" required><br>

    <label for="tipo">Tipo de Usuário:</label>
    <select name="tipo" id="tipo" required>
        <option value="aluno">Aluno</option>
        <option value="professor">Professor</option>
        <option value="admin">Admin</option>
    </select><br>

    <button type="submit" name="register">Cadastrar</button>
</form>

<p>Já tem uma conta? <a href="../login/login.php">Clique aqui para fazer login</a></p>
