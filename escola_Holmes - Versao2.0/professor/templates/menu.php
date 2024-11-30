<style>
nav {
    background-color: #4CAF50;
    padding: 10px 0;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    gap: 15px;
}
nav ul li {
    display: inline;
}
nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    padding: 10px 15px;
    transition: background-color 0.3s ease, transform 0.2s ease;
    border-radius: 5px;
}
nav ul li a:hover {
    background-color: #45a049;
    transform: scale(1.1);
}
</style>

<nav>
    <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="criar_turma.php">Criar Turma</a></li>
        <li><a href="lista_turmas.php">Listar Turmas</a></li>
        <li><a href="lista_alunos.php">Listar Alunos</a></li>
        <li><a href="../index.php">Sair</a></li>
    </ul>
</nav>
