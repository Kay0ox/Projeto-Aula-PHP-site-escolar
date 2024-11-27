<?php
include_once("config.inc.php");

if (isset($_POST['login'])) {
    // Recebe os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se todos os campos foram preenchidos
    if (empty($username) || empty($password)) {
        echo "Preencha todos os campos.";
    } else {
        // Consulta para verificar se o usuário existe e obter os dados
        $sql = "SELECT * FROM alunos WHERE username = '$username' LIMIT 1";
        $result = $conexao->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verifica se a senha fornecida corresponde à senha armazenada
            if (password_verify($password, $user['password_hash'])) {
                // Inicia a sessão e armazena os dados do usuário
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Armazena o tipo de usuário (admin, professor, aluno)

                // Redireciona conforme o papel do usuário
                if ($_SESSION['role'] == 'admin') {
                    header("Location: admin/index.php");  // Redireciona para a página do admin
                } elseif ($_SESSION['role'] == 'professor') {
                    header("Location: professor/index.php");  // Redireciona para a página do professor
                } else {
                    header("Location: aluno/index.php");  // Redireciona para a página do aluno
                }
                exit();
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Usuário não encontrado!";
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
