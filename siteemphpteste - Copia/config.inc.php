<?php
  // 1ª Etapa - Conexão com Servidor 
  $conexao = mysqli_connect("localhost","kayo","");
  // 2ª Etapa - Selecionar Banco de dados
  $bd = mysqli_select_db($conexao,"bd1");