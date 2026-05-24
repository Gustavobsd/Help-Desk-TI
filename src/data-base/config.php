<?php

    $db_host = "localhost";
    $db_user = "root";
    $dbPassword = "59797552";  // Senha vazia por padrão no XAMPP
    $dbName = "cadastro"; 

    $conexao = new mysqli($db_host, $db_user, $dbPassword, $dbName);
    //if ($conexao->connect_errno) {
       // die("Falha na conexão: " . $conexao->connect_error);
   // }
   // else {
       //echo "Conexão bem-sucedida, você pode realizar operações no banco de dados aqui";
   // }


?>