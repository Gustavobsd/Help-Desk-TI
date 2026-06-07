<?php
session_start();
include_once('config.php');

// Apenas aceite POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    $_SESSION['login_error'] = 'Preencha e-mail e senha.';
    header('Location: login.php');
    exit;
}

$sql = "SELECT id, nome, senha FROM usuarios WHERE email = ? LIMIT 1";

$stmt = $conexao->prepare($sql);
if ($stmt === false) {
    die('ERRO DO MYSQL: ' . $conexao->error);
}

$stmt->bind_param('s', $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows === 1) {
    $user = $resultado->fetch_assoc();

    // Verifica senha (assumindo hash com password_hash)
    if (password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['login_error'] = 'E-mail ou senha inválidos.';
        header('Location: login.php');
        exit;
    }
} else {
    $_SESSION['login_error'] = 'Usuário não encontrado.';
    header('Location: login.php');
    exit;
}

?>