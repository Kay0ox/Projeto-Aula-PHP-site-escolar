<?php
include_once("../includes/config.inc.php");

if ($_SERVER['REQUEST_METHOD']== 'POST') {
    $turma = $_POST['turma'];
    $descricao = $_POST['descricao'];
    $ano_periodo = $_POST['ano_periodo'];

    if (empty($turma)|| empty($descricao)|| empty($ano_periodo)){
        echo "Por favor, preencha todos os campos.";
        exit();
    }
$sql = "INSERT INTO turmas (turma, descricao, ano_periodo) VALUES (?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sss", $turma, $descricao, $ano_periodo);
    
if ($stmt->execute()){
    echo "turma cadastrada com sucesso";
} else {
    echo "não foi possivel cadastrar uma turma: " . $conexao->error;
}

$stmt->close();
$conexao->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
    <link rel="stylesheet" href="../../assets/css/estilo.css"> <!-- Ajuste o caminho se necessário -->
</head>
<body>
    <h1>Cadastrar Aluno</h1>
    <form action="adicionar_aluno_processa.php" method="post">
        <label for="nome">Nome do Aluno:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="username">Nome de Usuário:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Senha:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
