<?php
include_once("../includes/config.inc.php");
include_once("../includes/sessao.php");

protegePagina();

// Verifica se o usuário é professor
if ($_SESSION['tipo'] != 'professor') {
    header("Location: ../login/login.php");
    exit();
}

// Obtém a lista de alunos
$sql_alunos = "SELECT id, username FROM alunos";
$result_alunos = $conexao->query($sql_alunos);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['criar_turma'])) {
    $nome_turma = $_POST['nome_turma'];
    $nota_corte = $_POST['nota_corte'];
    $alunos_turma = explode(',', $_POST['alunos_ids']); // Obtém IDs dos alunos como array

    // Insere a nova turma
    $stmt = $conexao->prepare("INSERT INTO turmas (nome, nota_corte) VALUES (?, ?)");
    $stmt->bind_param("sd", $nome_turma, $nota_corte);
    $stmt->execute();
    $id_turma = $stmt->insert_id;

    // Adiciona os alunos à turma com a nota de corte
    if (!empty($alunos_turma)) {
        $stmt_alunos = $conexao->prepare("INSERT INTO alunos_turmas (id_aluno, id_turma, nota_corte) VALUES (?, ?, ?)");
        foreach ($alunos_turma as $id_aluno) {
            $stmt_alunos->bind_param("iis", $id_aluno, $id_turma, $nota_corte);
            $stmt_alunos->execute();
        }
    }

    header("Location: lista_turmas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Turma</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        .alunos-lista {
            margin-top: 20px;
        }
        .aluno-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
        .aluno-item button {
            width: auto;
            background-color: #007bff;
        }
        .aluno-item button:hover {
            background-color: #0056b3;
        }
        .selected-alunos {
            margin-top: 20px;
        }
        .selected-alunos ul {
            list-style-type: none;
            padding: 0;
        }
        .selected-alunos li {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: #e0f7fa;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .selected-alunos li button {
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .selected-alunos li button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <?php include("templates/topo.php"); ?>
    <?php include("templates/menu.php"); ?>

    <div class="container">
        <h1>Criar Nova Turma</h1>
        <form method="POST">
            <label for="nome_turma">Nome da Turma:</label>
            <input type="text" id="nome_turma" name="nome_turma" required>

            <label for="nota_corte">Nota de Corte:</label>
            <input type="number" id="nota_corte" name="nota_corte" min="0" max="10" step="0.01" required>

            <label>Adicionar Alunos:</label>
            <div class="alunos-lista">
                <?php while ($aluno = $result_alunos->fetch_assoc()) { ?>
                    <div class="aluno-item" data-id="<?php echo $aluno['id']; ?>">
                        <span><?php echo htmlspecialchars($aluno['username']); ?></span>
                        <button type="button" onclick="addAluno(<?php echo $aluno['id']; ?>, '<?php echo htmlspecialchars($aluno['username']); ?>')">Adicionar</button>
                    </div>
                <?php } ?>
            </div>

            <div class="selected-alunos">
                <h3>Alunos Selecionados:</h3>
                <ul id="alunos-selecionados"></ul>
            </div>

            <!-- Campo oculto para armazenar os IDs dos alunos -->
            <input type="hidden" name="alunos_ids" id="alunos_ids">

            <button type="submit" name="criar_turma">Criar Turma</button>
        </form>
    </div>

    <?php include("templates/rodape.php"); ?>

    <script>
        const alunosSelecionados = [];

        function addAluno(id, nome) {
            if (!alunosSelecionados.includes(id)) {
                alunosSelecionados.push(id);

                const lista = document.getElementById('alunos-selecionados');
                const li = document.createElement('li');
                li.textContent = nome;
                li.setAttribute('data-id', id);

                // Adicionar botão de remover
                const removeButton = document.createElement('button');
                removeButton.textContent = 'Remover';
                removeButton.onclick = function() {
                    removeAluno(id, li);
                };
                li.appendChild(removeButton);

                lista.appendChild(li);

                // Atualiza o campo oculto com os IDs dos alunos
                document.getElementById('alunos_ids').value = alunosSelecionados.join(',');
            }
        }

        function removeAluno(id, liElement) {
            const index = alunosSelecionados.indexOf(id);
            if (index > -1) {
                alunosSelecionados.splice(index, 1);
                liElement.remove();

                // Atualiza o campo oculto com os IDs dos alunos
                document.getElementById('alunos_ids').value = alunosSelecionados.join(',');
            }
        }
    </script>
</body>
</html>
