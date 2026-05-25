<?php
session_start();
include_once('config.php');

$mensagem = '';
$erro = '';

if (!empty($_SESSION['admin_id'])) {
    header('Location: fechamento_chamados.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_admin'])) {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if ($email === '' || $senha === '') {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $stmt = $conexao->prepare('SELECT id, nome, senha FROM administradores WHERE email = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado && $resultado->num_rows === 1) {
                $admin = $resultado->fetch_assoc();
                if (password_verify($senha, $admin['senha'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_nome'] = $admin['nome'];
                    header('Location: fechamento_chamados.php');
                    exit;
                }
            }

            $erro = 'E-mail ou senha inválidos.';
            $stmt->close();
        } else {
            $erro = 'Erro na consulta de login: ' . $conexao->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administrador Help Desk</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#0f172a;
    font-family:Arial, Helvetica, sans-serif;
    color:white;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:30px;
}

.container{
    width:100%;
    max-width:600px;
}

.box{
    background:#1e293b;
    padding:35px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

h2{
    font-size:30px;
    margin-bottom:15px;
}

p{
    color:#94a3b8;
    margin-bottom:25px;
}

input{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    margin-bottom:15px;
    background:#0f172a;
    color:white;
    font-size:15px;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:#2563eb;
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#1d4ed8;
}

.msg{
    background:#22c55e;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

.erro{
    background:#ef4444;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

.logo{
    text-align:center;
    margin-bottom:25px;
}

.logo h1{
    font-size:38px;
    color:#60a5fa;
}

/* ===== BOTÃO SAIR MODERNO ===== */
.logout{
    display:flex;
    justify-content:flex-end;
    margin-bottom:10px;
}

.btn-sair{
    background:#ef4444;
    color:white;
    text-decoration:none;
    padding:6px 14px;
    font-size:13px;
    border-radius:8px;
    font-weight:600;
    transition:0.2s;
    display:inline-block;
    box-shadow:0 4px 10px rgba(239,68,68,0.3);
}

.btn-sair:hover{
    background:#dc2626;
    transform:scale(1.05);
    box-shadow:0 6px 14px rgba(220,38,38,0.4);
}
</style>
</head>

<body>

<div class="container">
<div class="box">

<!-- BOTÃO SAIR -->
<div class="logout">
    <a href="logout.php" class="btn-sair">Sair</a>
</div>

<div class="logo">
<h1>HELP DESK</h1>
</div>

<h2>Login Administrativo</h2>
<p>Entre para gerenciar os chamados.</p>

<?php if($mensagem): ?>
<div class="msg"><?php echo $mensagem; ?></div>
<?php endif; ?>

<?php if($erro): ?>
<div class="erro"><?php echo $erro; ?></div>
<?php endif; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    <input type="password" name="senha" placeholder="Digite sua senha" required>
    <button type="submit" name="login_admin">Entrar</button>
</form>

<p style="margin-top:20px; text-align:center;">
    <a href="cadastro_admin.php">
        <button type="button">Cadastrar Administrador</button>
    </a>
</p>

</div>
</div>

</body>
</html>