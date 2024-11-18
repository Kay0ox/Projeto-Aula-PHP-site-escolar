<?php
include_once("../includes/config.inc.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // recebe os dados do bd
    $username = $_POST['username'];
    $password = $_POST['password']; // senha normal sem criptografar
}
    // aqui ele consulta para ver se o usuario existe tá meio feio mas vai assim msm
    $query = "SELECT * FROM alunos WHERE username = ?";
$stmt = $conexao->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    //mds funciona eu sou o cara mais inteligente do planeta
    $user = $result->fetch_assoc(); 
    $hashedPassword = $user['password_hash']; 

    // eu esqueci do ; hahahahahahaah
    if (password_verify($password, $hashedPassword)) {
        // aqui eu nem sei oq é o chat que ajudou
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['tipo'] = $user['tipo'];

        //eu esquci de fazer isso daqui ontem, agora ele direciona o usuario para suas respectivas pg 
        switch ($user['tipo']) {
            case 'aluno':
                header("Location: ../aluno/index.php");
                break;
            case 'professor':
                header("Location: ../professor/index.php");
                break;
            case 'admin':
                header("Location: ../admin/index.php");
                break;
            default:
                echo "Tipo de usuário inválido!";
        }
    } else {
        echo "Credenciais inválidas!";
    }
} else {
    echo "Credenciais inválidas!";
}
?>

<h2>Login</h2>
<form method="post" action="login.php">
    <label for="username">Nome de Usuário:</label>
    <input type="text" name="username" id="username" required><br>

    <label for="password">Senha:</label>
    <input type="password" name="password" id="password" required><br>

    <button type="submit">Entrar</button>
</form>

<p>Ainda não tem uma conta? <a href="../cadastro/cadastro.php">Clique aqui para se cadastrar</a></p>
