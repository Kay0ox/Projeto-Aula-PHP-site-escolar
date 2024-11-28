<?php
include_once("../includes/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do usuario
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $curso = $_POST['curso']; 
    $senha = $_POST['senha'];

    // Verificar se todas as areas estão preenchidas
    if (empty($nome) || empty($email) || empty($curso) || empty($senha)) {
        echo "Todos os campos são obrigatórios!";
        exit;
    }

    // Verificar se o gmail já está cadastrado
    $sql_check_email = "SELECT * FROM alunos WHERE email = ?";
    $stmt = $conexao->prepare($sql_check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "O e-mail já está cadastrado!";
    } else {
        // Criptografa a senha para neguin n roubar
        $password_hash = password_hash($senha, PASSWORD_DEFAULT);

        // adiciona os dados ao bd
        $sql = "INSERT INTO alunos (username, email, password_hash, curso, tipo) VALUES (?, ?, ?, ?, 'aluno')";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $password_hash, $curso);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
            header("Location: ../login/login.php"); 
            echo "Erro ao cadastrar: " . $conexao->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Faculdade Holmes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Faculdade Holmes</h1>
            <a href="../login/login.php" class="login-link">Login</a>
        </div>
    </header>

    <main>
        <h2>Inscreva-se Agora</h2>
        <form action="processar_cadastro.php" method="POST">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" placeholder="Seu Nome" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="seuemail@email.com" required>
            
            <label for="curso">Selecione o Curso:</label>
            <select id="curso" name="curso" required>
                <option value="">Escolha um curso</option>
                <option value="Administração">Administração</option>
                <option value="Sistemas de Informação">Sistemas de Informação</option>
                <option value="Direito">Direito</option>
            </select>
            
            <label for="senha">Crie uma Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite uma senha" required>
            
            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Faculdade Holmes. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

