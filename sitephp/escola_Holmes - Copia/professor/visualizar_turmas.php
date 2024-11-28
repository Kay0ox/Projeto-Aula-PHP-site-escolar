<h2>Lista das Turmas</h2>

<table border="1">
    <thead>
        <tr>
            <th>Turmas</th>
            <th>descrição</th>
            <th>Ano e periodo</th>
        </tr>
    </thead>
<tdbody>
<?php
include_once("../../includes/config.inc.php");

$sql = "SELECT turma, descricao, ano_periodo FROM turmas";
$result = $conexao->query($sql);

if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>". htmlspecialchars($row['turma']) . "</td>";
        echo "<td>". htmlspecialchars($row['descricao']) . "</td>";
        echo "<td>". htmlspecialchars($row['ano_periodo']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>Nenhuma turma encontrada</td></tr>";
}
$conexao->close();
?>
    </tdbody>
</table>