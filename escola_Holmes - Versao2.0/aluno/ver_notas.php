<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina(); // Protege a página contra acessos não autorizados

// Verifica se o usuário é aluno
if ($_SESSION['tipo'] != 'aluno') {
    header("Location: ../login/login.php");
    exit();
}

// Pega o email do aluno a partir da sessão
$email_aluno = $_SESSION['email'];

// Busca as turmas e notas do aluno logado
$sql_turmas = "
    SELECT t.nome AS nome_turma, t.descricao, t.data_criacao, at.nota, at.nota_corte
    FROM alunos_turmas at
    JOIN turmas t ON at.id_turma = t.id
    JOIN alunos a ON at.id_aluno = a.id
    WHERE a.email = ?";
$stmt = $conexao->prepare($sql_turmas);
$stmt->bind_param("s", $email_aluno);
$stmt->execute();
$result_turmas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Notas</title>
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
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        a {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 1.1rem;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Minhas Notas</h1>
    <a href="index.php">Voltar ao Painel Principal</a>

    <table>
        <thead>
            <tr>
                <th>Nome da Turma</th>
                <th>Descrição</th>
                <th>Data de Criação</th>
                <th>Nota</th>
                <th>Nota de Corte</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_turmas->num_rows > 0): ?>
                <?php while ($turma = $result_turmas->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($turma['nome_turma']); ?></td>
                    <td><?= htmlspecialchars($turma['descricao']); ?></td>
                    <td><?= htmlspecialchars(date("d/m/Y", strtotime($turma['data_criacao']))); ?></td>
                    <td><?= htmlspecialchars($turma['nota']); ?></td>
                    <td><?= htmlspecialchars($turma['nota_corte']); ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Você não está matriculado em nenhuma turma ou não possui notas cadastradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
