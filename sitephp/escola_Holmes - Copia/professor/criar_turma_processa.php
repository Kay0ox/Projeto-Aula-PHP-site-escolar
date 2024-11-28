<?php
include_once('../includes/config.inc.php'); // Ajuste o caminho
include_once('../includes/sessao.php'); // Verificação de sessão, se necessário

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $ano_periodo = $_POST['ano_periodo'];

    $sql = "INSERT INTO turmas (nome, descricao, ano_periodo) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('sss', $nome, $descricao, $ano_periodo);

    if ($stmt->execute()) {
        echo "Turma criada com sucesso!";
    } else {
        echo "Erro ao criar turma: " . $conexao->error;
    }

    $stmt->close();
    $conexao->close();
}
?>
