<?php
include_once("../config.inc.php");

$sql = "SELECT * FROM alunos";
$result = $conexao->query($sql);

// Verifica se há alunos
if ($result->num_rows > 0) {
    echo "<h2>Lista de Alunos</h2>";
    echo "<table border='1'>";
    echo "<thead><tr><th>Nome</th><th>Email</th><th>Curso</th><th>Idade</th></tr></thead>";
    echo "<tbody>";
 // Exibe os alunos
 while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['curso']) . "</td>";
    echo "<td>" . htmlspecialchars($row['idade']) . "</td>";
    echo "</tr>";

}
echo "</tdbody>";
echo "/table>";
} else {
    echo "<p> Nenhum Aluno encontrado.</p>";
}
?>