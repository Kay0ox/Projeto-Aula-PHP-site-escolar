<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina();

// Verifica se o usuário é professor
if ($_SESSION['tipo'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Excluir a turma
if (isset($_POST['excluir_turma'])) {
    $id_turma = $_POST['excluir_turma'];

    // Excluir alunos associados à turma
    $sql_alunos_turma = "DELETE FROM alunos_turmas WHERE id_turma = ?";
    $stmt = $conexao->prepare($sql_alunos_turma);
    $stmt->bind_param("i", $id_turma);
    $stmt->execute();

    // Excluir a turma
    $sql_turma = "DELETE FROM turmas WHERE id = ?";
    $stmt_turma = $conexao->prepare($sql_turma);
    $stmt_turma->bind_param("i", $id_turma);
    $stmt_turma->execute();

    header("Location: lista_turmas.php");
    exit();
}

// Buscar todas as turmas
$sql = "SELECT id, nome, descricao, data_criacao FROM turmas";
$result = $conexao->query($sql);
?>
<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina();

// Verifica se o usuário é professor
if ($_SESSION['tipo'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Excluir a turma
if (isset($_POST['excluir_turma'])) {
    $id_turma = $_POST['excluir_turma'];

    // Excluir alunos associados à turma
    $sql_alunos_turma = "DELETE FROM alunos_turmas WHERE id_turma = ?";
    $stmt = $conexao->prepare($sql_alunos_turma);
    $stmt->bind_param("i", $id_turma);
    $stmt->execute();

    // Excluir a turma
    $sql_turma = "DELETE FROM turmas WHERE id = ?";
    $stmt_turma = $conexao->prepare($sql_turma);
    $stmt_turma->bind_param("i", $id_turma);
    $stmt_turma->execute();

    header("Location: lista_turmas.php");
    exit();
}

// Buscar todas as turmas
$sql = "SELECT id, nome, descricao, data_criacao FROM turmas";
$result = $conexao->query($sql);
?>
<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina();

// Verifica se o usuário é professor
if ($_SESSION['tipo'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Excluir a turma
if (isset($_POST['excluir_turma'])) {
    $id_turma = $_POST['excluir_turma'];

    // Excluir alunos associados à turma
    $sql_alunos_turma = "DELETE FROM alunos_turmas WHERE id_turma = ?";
    $stmt = $conexao->prepare($sql_alunos_turma);
    $stmt->bind_param("i", $id_turma);
    $stmt->execute();

    // Excluir a turma
    $sql_turma = "DELETE FROM turmas WHERE id = ?";
    $stmt_turma = $conexao->prepare($sql_turma);
    $stmt_turma->bind_param("i", $id_turma);
    $stmt_turma->execute();

    header("Location: lista_turmas.php");
    exit();
}

// Buscar todas as turmas
$sql = "SELECT id, nome, descricao, data_criacao FROM turmas";
$result = $conexao->query($sql);
?>
<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina();

// Verifica se o usuário é professor
if ($_SESSION['tipo'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Excluir a turma
if (isset($_POST['excluir_turma'])) {
    $id_turma = $_POST['excluir_turma'];

    // Excluir alunos associados à turma
    $sql_alunos_turma = "DELETE FROM alunos_turmas WHERE id_turma = ?";
    $stmt = $conexao->prepare($sql_alunos_turma);
    $stmt->bind_param("i", $id_turma);
    $stmt->execute();

    // Excluir a turma
    $sql_turma = "DELETE FROM turmas WHERE id = ?";
    $stmt_turma = $conexao->prepare($sql_turma);
    $stmt_turma->bind_param("i", $id_turma);
    $stmt_turma->execute();

    header("Location: lista_turmas.php");
    exit();
}

// Buscar todas as turmas
$sql = "SELECT id, nome, descricao, data_criacao FROM turmas";
$result = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Turmas</title>
    <style>
        /* Estilos Gerais */
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
            margin-bottom: 30px;
            color: #333;
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

        .btn {
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-manage {
            background-color: #28a745;
        }

        .btn-delete {
            background-color: #dc3545;
            border: none;
        }

        .btn-manage:hover {
            background-color: #218838;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Responsividade */
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

<?php 
include("templates/topo.php"); 
include("templates/menu.php"); 
?>

<div class="container">
    <h1>Lista de Turmas</h1>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($turma = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($turma['nome']); ?></td>
                    <td><?php echo htmlspecialchars($turma['descricao']); ?></td>
                    <td><?php echo htmlspecialchars(date("d/m/Y", strtotime($turma['data_criacao']))); ?></td>
                    <td class="actions">
                        <a href="gerenciar_turma.php?id_turma=<?php echo $turma['id']; ?>" class="btn btn-manage">Gerenciar</a>
                        <form method="POST" style="display:inline;">
                            <button type="submit" name="excluir_turma" value="<?php echo $turma['id']; ?>" class="btn btn-delete" onclick="return confirm('Deseja realmente excluir esta turma?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <h3>Alunos e Notas</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Aluno</th>
                                    <th>Nota</th>
                                    <th>Nota de Corte</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_alunos = "SELECT a.username, at.nota, at.nota_corte 
                                               FROM alunos_turmas at 
                                               JOIN alunos a ON at.id_aluno = a.id 
                                               WHERE at.id_turma = ?";
                                $stmt_alunos = $conexao->prepare($sql_alunos);
                                $stmt_alunos->bind_param("i", $turma['id']);
                                $stmt_alunos->execute();
                                $result_alunos = $stmt_alunos->get_result();

                                while ($aluno = $result_alunos->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($aluno['username']) . "</td>";
                                    echo "<td>" . htmlspecialchars($aluno['nota']) . "</td>";
                                    echo "<td>" . htmlspecialchars($aluno['nota_corte']) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("templates/rodape.php"); ?>

</body>
</html>
