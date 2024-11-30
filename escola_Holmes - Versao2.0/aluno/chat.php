<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina(); // Protege a página contra acessos não autorizados

// Verifica o tipo de usuário
if ($_SESSION['tipo'] != 'aluno') {
    header("Location: ../login/login.php");
    exit();
}

$usuario_id = $_SESSION['id'];
$tipo_usuario = $_SESSION['tipo'];
$limite_mensagens = 5; // Limite de mensagens por hora

// Envio de mensagens
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mensagem'])) {
    $mensagem = trim($_POST['mensagem']);
    
    if (!empty($mensagem)) {
        // Verifica se o aluno atingiu o limite de mensagens
        $query_limite = "
            SELECT COUNT(*) AS total
            FROM chat_mensagens
            WHERE usuario_id = ? AND data_envio >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
        $stmt_limite = $conexao->prepare($query_limite);
        $stmt_limite->bind_param("i", $usuario_id);
        $stmt_limite->execute();
        $result_limite = $stmt_limite->get_result()->fetch_assoc();

        if ($result_limite['total'] < $limite_mensagens) {
            // Insere a mensagem no banco de dados
            $query_inserir = "INSERT INTO chat_mensagens (usuario_id, mensagem, tipo_usuario) VALUES (?, ?, ?)";
            $stmt_inserir = $conexao->prepare($query_inserir);
            $stmt_inserir->bind_param("iss", $usuario_id, $mensagem, $tipo_usuario);
            $stmt_inserir->execute();
        } else {
            $erro = "Você atingiu o limite de mensagens por hora.";
        }
    } else {
        $erro = "A mensagem não pode estar vazia.";
    }
}

// Busca as mensagens do chat
$query_mensagens = "
    SELECT cm.mensagem, cm.data_envio, u.username, cm.tipo_usuario
    FROM chat_mensagens cm
    JOIN alunos u ON cm.usuario_id = u.id
    ORDER BY cm.data_envio DESC
    LIMIT 50"; // Exibe as últimas 50 mensagens
$result_mensagens = $conexao->query($query_mensagens);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 30px auto;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .chat-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            padding: 15px;
            height: 400px;
            overflow-y: scroll;
            margin-bottom: 20px;
        }

        .chat-message {
            margin-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .chat-message .username {
            font-weight: bold;
        }

        .chat-message .timestamp {
            color: #999;
            font-size: 0.9rem;
        }

        .chat-message.admin {
            color: #dc3545;
        }

        .chat-message.professor {
            color: #007bff;
        }

        .chat-message.aluno {
            color: #28a745;
        }

        form {
            display: flex;
            gap: 10px;
        }

        textarea {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            resize: none;
            height: 50px;
            font-size: 1rem;
        }

        button {
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Chat Geral</h1>

    <?php if (isset($erro)): ?>
        <div class="error"><?= htmlspecialchars($erro); ?></div>
    <?php endif; ?>

    <div class="chat-box">
        <?php while ($mensagem = $result_mensagens->fetch_assoc()): ?>
            <div class="chat-message <?= htmlspecialchars($mensagem['tipo_usuario']); ?>">
                <span class="username"><?= htmlspecialchars($mensagem['username']); ?>:</span>
                <span class="timestamp">(<?= date("d/m/Y H:i", strtotime($mensagem['data_envio'])); ?>)</span>
                <p><?= htmlspecialchars($mensagem['mensagem']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <form method="POST">
        <textarea name="mensagem" placeholder="Digite sua mensagem..." required></textarea>
        <button type="submit">Enviar</button>
    </form>
</div>

</body>
</html>
