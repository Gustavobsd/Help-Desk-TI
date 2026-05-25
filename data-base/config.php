<?php

// Dados do banco
$host = "localhost";
$usuario = "root";
$senha = "59797552";
$banco = "cadastro";

// Criar conexão
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verificar conexão
if($conexao->connect_error)
{
    die("Erro de conexão: " . $conexao->connect_error);
}

// Charset UTF8
$conexao->set_charset("utf8mb4");

?>