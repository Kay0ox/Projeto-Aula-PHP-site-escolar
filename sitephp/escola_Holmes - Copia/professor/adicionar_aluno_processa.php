<?php
include_once('../includes/config.inc.php'); // Ajuste o caminho
include_once('../includes/sessao.php'); // Verificação de sessão, se necessário

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO alunos (id, email, username, password_hash, tipo) VALUES (?, ?, ?, ?, 'aluno')";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ssss', $nome, $email, $username, $password);

    if ($stmt->execute()) {
        echo "Aluno cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar aluno: " . $conexao->error;
    }

    $stmt->close();
    $conexao->close();
}
?>
S