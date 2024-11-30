<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina();

// Verifica se o usuário é professor
if ($_SESSION['tipo'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Professor</title>
    <style>
        /* Estilo para o container principal */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }
        .main-content {
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .welcome h2 {
            font-size: 28px;
            color: #4CAF50;
            margin-bottom: 10px;
            animation: fadeIn 0.8s ease;
        }
        .welcome p {
            font-size: 18px;
            color: #555;
            animation: fadeIn 1s ease;
        }
        .actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 20px;
            width: 250px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
        .card a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 18px;
            font-weight: bold;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <?php include("templates/topo.php"); ?>
    <?php include("templates/menu.php"); ?>

    <main class="main-content">
        <div class="container">
            <section class="welcome">
                <h2>Bem-vindo ao Painel do Professor</h2>
                <p>Gerencie suas turmas, alunos e notas com facilidade!</p>
            </section>
            <section class="actions">
                <div class="card">
                    <a href="criar_turma.php">Criar Turma</a>
                </div>
                <div class="card">
                    <a href="lista_turmas.php">Gerenciar Turmas</a>
                </div>
                <div class="card">
                    <a href="lista_alunos.php">Visualizar Alunos</a>
                </div>
            </section>
        </div>
    </main>

    <?php include("templates/rodape.php"); ?>
</body>
</html>
