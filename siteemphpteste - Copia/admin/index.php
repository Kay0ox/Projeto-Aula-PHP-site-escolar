<h1>Painel Admin</h1>

<?php
    include("sessao.php");

    // Verifica se o usuário está logado
    if (logado()) {
        echo "<p>Bem-vindo <b>$_SESSION[usuario]</b>!</p>";
    } else {
        header("Location: form_login.php");  // Redireciona se não estiver logado
        exit();
    }
?>

<nav>
    <a href="?pg=conteudo">Página Inicial</a> |
    <a href="?pg=lista_msg">Lista de Mensagens</a> |
    <a href="?pg=lista_alunos">Alunos</a> 
</nav>

<?php
    // Verifica qual página incluir
    if (empty($_SERVER['QUERY_STRING'])) {
        $var = "../conteudo.php";
        include_once($var);
    } else {
        $pg = $_GET['pg'];
        include_once("$pg.php");
    }
?>
