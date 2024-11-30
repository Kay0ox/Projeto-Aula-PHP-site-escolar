<<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina(); // Protege a página para impedir que malandro não invada (ou aomenos ele tenta impedir)

// Verifica se o tipo do usuário na sessão é "admin", caso contrário ele chuta a bunda do usuario para fora
if ($_SESSION['tipo'] != 'admin') {
    header("Location: ../login/login.php");
    exit();
}

// Processa o formulário de alteração
if (isset($_POST['alterar_tipo'])) {
    $novo_tipo = $_POST['novo_tipo'];
    $usuario_id = $_POST['usuario_id'];
    $novo_email = $_POST['novo_email'];
    $nova_senha = $_POST['nova_senha'];

    // Se a senha foi alterada, criptografa a nova senha
    if (!empty($nova_senha)) {
        $hashed_password = password_hash($nova_senha, PASSWORD_DEFAULT);
    } else {
        $hashed_password = null; // Se a senha não foi alterada, mantemos o valor nulo
    }

    // Atualiza o e-mail, tipo e senha (se fornecida) no banco de dados
    $query = "UPDATE alunos SET tipo = ?, email = ?, password_hash = ? WHERE id = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("sssi", $novo_tipo, $novo_email, $hashed_password, $usuario_id);

    if ($stmt->execute()) {
        $sucesso = "Dados do usuário alterados com sucesso.";
    } else {
        $erro = "Erro ao alterar os dados do usuário.";
    }
}

// Consulta para pegar todos os usuários cadastrados
$query = "SELECT id, username, email, tipo FROM alunos";
$result = $conexao->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Painel do Administrador</h1>
            <a href="../index.php">Sair</a>
        </div>
    </header>

    <main>
        <h2>Usuários Cadastrados</h2>
        <a href="cadastrar_aluno.php" style="display: inline-block; margin-bottom: 20px; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Cadastrar Novo Aluno</a>

        <?php if (isset($sucesso)): ?>
            <p style="color: green;"><?= $sucesso; ?></p>
        <?php elseif (isset($erro)): ?>
            <p style="color: red;"><?= $erro; ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome de Usuário</th>
                    <th>E-mail</th>
                    <th>Tipo</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['tipo']; ?></td>
                        <td>
                            <form action="index.php" method="POST">
                                <input type="hidden" name="usuario_id" value="<?= $user['id']; ?>">

                                <!-- Alterar Tipo de Usuário -->
                                <select name="novo_tipo">
                                    <option value="aluno" <?= ($user['tipo'] == 'aluno') ? 'selected' : ''; ?>>Aluno</option>
                                    <option value="professor" <?= ($user['tipo'] == 'professor') ? 'selected' : ''; ?>>Professor</option>
                                </select>

                                <!-- Alterar E-mail -->
                                <input type="email" name="novo_email" value="<?= $user['email']; ?>" required>

                                <!-- Alterar Senha -->
                                <input type="password" name="nova_senha" placeholder="Nova senha (deixe em branco para manter a atual)">

                                <button type="submit" name="alterar_tipo">Alterar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Faculdade Holmes. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
