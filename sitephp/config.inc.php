<?php
  // 1ª Etapa - Conexão com Servidor 
  $conexao = mysqli_connect("localhost","root","");
  // 2ª Etapa - Selecionar Banco de dados
  $bd = mysqli_select_db($conexao,"bd1");