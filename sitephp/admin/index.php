<h1>Painel Admin</h1>

<?php

    include("sessao.php");

    if (logado()) {
        // Usuário está logado
        echo "<p>Bem-vindo <b>$_SESSION[usuario]</b>!</p>";
    } else {
        header("Location: form_login.php");
        exit();
    }

?>
<nav>
    
    <a href="#"> Página Inicial </a> |
    <a href="?pg=lista_msg">Lista de Mensagens </a> |
    <a href="?pg=lista_clientes">Clientes </a> |
  
</nav>
<?php

    if(empty($_SERVER['QUERY_STRING'])){
        $var = "conteudo.php";
        include_once($var);
    }else{
        $pg = $_GET['pg'];
        include_once("$pg.php");
    }
