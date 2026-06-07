<?php

// Exibir erros em ambiente de desenvolvimento
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Configuração de conexão com o banco de dados
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '59797552';
$db_name = 'cadastro';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexao = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $conexao->set_charset('utf8mb4');

    $createUsuariosSql = "
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            senha VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            telefone VARCHAR(50) DEFAULT NULL,
            genero VARCHAR(50) DEFAULT NULL,
            dataNascimento DATE DEFAULT NULL,
            cidade VARCHAR(100) DEFAULT NULL,
            estado VARCHAR(100) DEFAULT NULL,
            endereco VARCHAR(255) DEFAULT NULL,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $conexao->query($createUsuariosSql);

    $createAdministradoresSql = "
        CREATE TABLE IF NOT EXISTS administradores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $conexao->query($createAdministradoresSql);

    $createChamadosSql = "
        CREATE TABLE IF NOT EXISTS chamados (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            titulo VARCHAR(255) NOT NULL,
            categoria VARCHAR(100) NOT NULL,
            prioridade ENUM('baixa','media','alta') NOT NULL DEFAULT 'media',
            descricao TEXT NOT NULL,
            status ENUM('aberto','em andamento','concluido') NOT NULL DEFAULT 'aberto',
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $conexao->query($createChamadosSql);
} catch (mysqli_sql_exception $e) {
    die('Falha na conexão com o banco de dados: ' . $e->getMessage());
}

// Inclua este arquivo nas páginas que precisam do banco de dados:
// include_once('config.php');
?>
