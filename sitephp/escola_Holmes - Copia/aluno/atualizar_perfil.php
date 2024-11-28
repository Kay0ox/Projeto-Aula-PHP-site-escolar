<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
</head>
<body>
    <?php include 'templates/menu.php'; ?>
    <div class="content">
        <h1>Editar Perfil</h1>
        <form action="processar_atualizacao.php" method="POST">
            <label for="email">Novo Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="senha">Nova Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <br>
            <button type="submit">Atualizar</button>
        </form>
    </div>
</body>
</html>
