<?php

include_once('config.php');

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if ($email === '' || $senha === '') {
        $erro = 'Preencha e-mail e senha.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } else {
        $stmt = $conexao->prepare('SELECT id, nome, senha FROM usuarios WHERE email = ? LIMIT 1');
        if (!$stmt) {
            $erro = 'Erro na consulta de login: ' . $conexao->error;
        } else {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($id, $nome, $senhaHash);
                $stmt->fetch();

                if (password_verify($senha, $senhaHash)) {
                    session_start();
                    session_regenerate_id(true);
                    $_SESSION['usuario_id'] = $id;
                    $_SESSION['usuario_nome'] = $nome;
                    header('Location: dashboard.php');
                    exit;
                }
            }

            $erro = 'E-mail ou senha inválidos.';
            $stmt->close();
        }
    }
}

?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #0d1b2a; color: white; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .card { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 24px; width: min(440px, 100%); }
        h1 { margin-top: 0; }
        p { margin: 16px 0; }
        a { color: #7fb3ff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Login</h1>
        <?php if ($erro): ?>
            <p><?php echo htmlspecialchars($erro); ?></p>
            <p><a href="login.php">Voltar para Login</a></p>
        <?php else: ?>
            <p>Redirecionando...</p>
        <?php endif; ?>
    </div>
</body>
</html>
