<?php


    include_once("templates/topo.php");
    include_once("templates/menu.php");

    if(empty($_SERVER['QUERY_STRING'])){
        $var = "conteudo.php";
        include_once($var);
    }else{
        $pg = $_GET['pg'];
        include_once("$pg.php");
    }

    include_once("templates/rodape.php");
