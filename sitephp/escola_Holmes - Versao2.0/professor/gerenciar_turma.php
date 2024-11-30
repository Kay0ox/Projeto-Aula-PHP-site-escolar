<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina();

// Verifica se o usuário é professor
if ($_SESSION['tipo'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

$id_turma = $_GET['id_turma'] ?? null;
if (!$id_turma) {
    die("Turma não especificada.");
}

// Atualizar nota individual do aluno
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar_nota'])) {
    $id_aluno = $_POST['id_aluno'];
    $nova_nota = $_POST['nova_nota'];

    $stmt = $conexao->prepare("UPDATE alunos_turmas SET nota = ? WHERE id_aluno = ? AND id_turma = ?");
    $stmt->bind_param("sii", $nova_nota, $id_aluno, $id_turma);
    $stmt->execute();

    header("Location: gerenciar_turma.php?id_turma=$id_turma");
    exit();
}

// Atualizar nota de corte individual
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar_nota_corte'])) {
    $id_aluno = $_POST['id_aluno'];
    $nova_nota_corte = $_POST['nova_nota_corte'];

    $stmt = $conexao->prepare("UPDATE alunos_turmas SET nota_corte = ? WHERE id_aluno = ? AND id_turma = ?");
    $stmt->bind_param("sii", $nova_nota_corte, $id_aluno, $id_turma);
    $stmt->execute();

    header("Location: gerenciar_turma.php?id_turma=$id_turma");
    exit();
}

// Remover aluno da turma
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remover_aluno'])) {
    $id_aluno = $_POST['remover_aluno'];

    // Remove o aluno da turma
    $stmt = $conexao->prepare("DELETE FROM alunos_turmas WHERE id_aluno = ? AND id_turma = ?");
    $stmt->bind_param("ii", $id_aluno, $id_turma);
    $stmt->execute();

    header("Location: gerenciar_turma.php?id_turma=$id_turma");
    exit();
}

// Busca os alunos da turma
$sql_alunos_turma = "
    SELECT a.id, a.username, at.nota, at.nota_corte 
    FROM alunos a
    JOIN alunos_turmas at ON a.id = at.id_aluno
    WHERE at.id_turma = ?";
$stmt = $conexao->prepare($sql_alunos_turma);
$stmt->bind_param("i", $id_turma);
$stmt->execute();
$result_alunos_turma = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Turma</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciar Turma</h1>

        <?php if ($result_alunos_turma->num_rows > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Nota</th>
                        <th>Nota de Corte</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($aluno = $result_alunos_turma->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($aluno['username']); ?></td>
                            <td>
                                <!-- Formulário para atualizar nota individual -->
                                <form action="gerenciar_turma.php?id_turma=<?php echo $id_turma; ?>" method="POST" style="display: inline;">
                                    <input type="hidden" name="id_aluno" value="<?php echo $aluno['id']; ?>">
                                    <input type="number" name="nova_nota" value="<?php echo htmlspecialchars($aluno['nota']); ?>" step="0.01" min="0" max="10" required>
                                    <button type="submit" name="atualizar_nota">Salvar Nota</button>
                                </form>
                            </td>
                            <td>
                                <!-- Formulário para atualizar nota de corte -->
                                <form action="gerenciar_turma.php?id_turma=<?php echo $id_turma; ?>" method="POST" style="display: inline;">
                                    <input type="hidden" name="id_aluno" value="<?php echo $aluno['id']; ?>">
                                    <input type="number" name="nova_nota_corte" value="<?php echo htmlspecialchars($aluno['nota_corte']); ?>" step="0.01" min="0" max="10" required>
                                    <button type="submit" name="atualizar_nota_corte">Salvar Nota de Corte</button>
                                </form>
                            </td>
                            <td>
                                <!-- Formulário para remover aluno -->
                                <form action="gerenciar_turma.php?id_turma=<?php echo $id_turma; ?>" method="POST" style="display: inline;">
                                    <input type="hidden" name="remover_aluno" value="<?php echo $aluno['id']; ?>">
                                    <button type="submit" onclick="return confirm('Tem certeza que deseja remover este aluno?')">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Não há alunos cadastrados nesta turma.</p>
        <?php endif; ?>

        <a href="lista_turmas.php">Voltar para as turmas</a>
    </div>
</body>
</html>
