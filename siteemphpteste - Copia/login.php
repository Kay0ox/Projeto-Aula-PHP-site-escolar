<?php
include_once("config.inc.php");

if (isset($_POST['login'])) { 
    // Recebe os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se os campos foram preenchidos
    if (empty($username) || empty($password)) {
        echo "Preencha todos os campos.";
    } else {
        // Consulta ao banco de dados para verificar o usuário
        $sql = "SELECT * FROM alunos WHERE username = '$username'";
        $result = $conexao->query($sql);

        if ($result->num_rows > 0) {
            // Usuário encontrado
            $user = $result->fetch_assoc();

            // Verifica se a senha está correta
            if (password_verify($password, $user['password_hash'])) {
                echo "Login completo com sucesso!";

                // Inicia a sessão e armazena a variável do usuário
                session_start();
                $_SESSION['user_id'] = $user['id'];

                // Redireciona para o menu
                header("Location: menu.php");
                exit();
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Aluno não encontrado!";
        }
    }
}
?>

<!-- HTML do login -->
<h2>Login</h2>
<form method="post" action="login.php">
    <label for="username">Usuário:</label>
    <input type="text" name="username" id="username" required><br>

    <label for="password">Senha:</label>
    <input type="password" name="password" id="password" required><br>

    <button type="submit" name="login">Entrar</button>
</form>
