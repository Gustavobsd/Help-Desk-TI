<?php
session_start();
include_once('config.php');

$mensagem = '';
$erro = '';

/*
|--------------------------------------------------------------------------
| CADASTRO ADMINISTRADOR
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastro_admin'])) {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if ($nome == '' || $email == '' || $senha == '') {
        $erro = 'Preencha todos os campos.';
    } else {
        $sqlVerifica = "SELECT id FROM administradores WHERE email = ?";
        $stmtVerifica = $conexao->prepare($sqlVerifica);
        $stmtVerifica->bind_param('s', $email);
        $stmtVerifica->execute();
        $resultadoVerifica = $stmtVerifica->get_result();

        if ($resultadoVerifica->num_rows > 0) {
            $erro = 'E-mail já cadastrado.';
        } else {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO administradores (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $conexao->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('sss', $nome, $email, $senhaHash);
                if ($stmt->execute()) {
                    $mensagem = 'Administrador cadastrado com sucesso!';
                } else {
                    $erro = 'Erro ao cadastrar administrador.';
                }
                $stmt->close();
            }
        }
        $stmtVerifica->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastrar Administrador</title>
<style>
body{background:#0f172a;font-family:Arial, Helvetica, sans-serif;color:white;min-height:100vh;display:flex;justify-content:center;align-items:center;padding:30px;}
.box{background:#1e293b;padding:35px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,0.4);width:100%;max-width:500px;}
h2{font-size:28px;margin-bottom:15px;}
p{color:#94a3b8;margin-bottom:25px;}
input{width:100%;padding:14px;border:none;border-radius:12px;margin-bottom:15px;background:#0f172a;color:white;font-size:15px;}
button{width:100%;padding:14px;border:none;border-radius:12px;background:#2563eb;color:white;font-size:16px;font-weight:bold;cursor:pointer;transition:0.3s;}
button:hover{background:#1d4ed8;}
.msg{background:#22c55e;padding:15px;border-radius:12px;margin-bottom:20px;}
.erro{background:#ef4444;padding:15px;border-radius:12px;margin-bottom:20px;}
a{color:#60a5fa;text-decoration:none;display:inline-block;margin-top:15px;}
</style>
</head>
<body>
<div class="box">
    <h2>Cadastrar Administrador</h2>
    <p>Preencha os dados para criar um novo administrador.</p>

    <?php if($mensagem): ?>
        <div class="msg"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <?php if($erro): ?>
        <div class="erro"><?php echo $erro; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="email" name="email" placeholder="Digite o e-mail" required>
        <input type="password" name="senha" placeholder="Digite a senha" required>
        <button type="submit" name="cadastro_admin">Cadastrar Administrador</button>
    </form>

    <a href="login_adm.php">← Voltar para Login</a>
</div>
</body>
</html>