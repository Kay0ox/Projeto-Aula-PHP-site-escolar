<h2>area de cadastro</h2>

<form method="post" action="criar-turma_action.php">
    <label for="turma">TURMA: </label>
    <input type="text" name="turma" id="turma" maxlength="16" required><br>

    <label for="descricao">DESCRIÇÃO: </label>
    <textarea name="descricao" id="descricao" required></textarea><br>

    <label for="ano_periodo"> ANO/PERIODO: </label>
    <input type="text" name="ano_periodo" id="ano_periodo" maxlength="7" required><br>

    <button type="submit"> Cadastrar Turma</button>

</from>