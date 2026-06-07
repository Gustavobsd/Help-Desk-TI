<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Service Desk - Home</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    min-height:100vh;
    background: linear-gradient(135deg, #0f172a, #1e3a8a, #0ea5e9);
    color:white;
}

/* NAVBAR */
nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 60px;
    background:rgba(0,0,0,0.25);
    backdrop-filter: blur(10px);
    position:fixed;
    width:100%;
    top:0;
    left:0;
}

nav h1{
    font-size:20px;
    color:#60a5fa;
    letter-spacing:1px;
}

nav .links a{
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-size:14px;
    padding:8px 14px;
    border-radius:8px;
    transition:0.3s;
}

nav .links a:hover{
    background:#2563eb;
}

/* HERO */
.hero{
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    height:100vh;
    padding-top:80px;
}

.hero h2{
    font-size:44px;
    margin-bottom:15px;
}

.hero p{
    font-size:16px;
    color:#cbd5e1;
    max-width:600px;
    line-height:1.5;
}

/* BOTÕES */
.box{
    margin-top:30px;
    display:flex;
    gap:15px;
}

.btn{
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.btn-login{
    background:#2563eb;
    color:white;
}

.btn-login:hover{
    background:#1d4ed8;
    transform:scale(1.05);
}

.btn-cadastro{
    background:transparent;
    border:2px solid #60a5fa;
    color:white;
}

.btn-cadastro:hover{
    background:#60a5fa;
    color:#0f172a;
    transform:scale(1.05);
}

/* CARDS */
.cards{
    margin-top:50px;
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    justify-content:center;
}

.card{
    background:rgba(255,255,255,0.08);
    padding:20px;
    border-radius:15px;
    width:220px;
    backdrop-filter: blur(10px);
    border:1px solid rgba(255,255,255,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-6px);
}

.card h3{
    margin-bottom:10px;
    color:#93c5fd;
}

.card p{
    font-size:13px;
    color:#cbd5e1;
}

.card-link {
    text-decoration: none;
    color: inherit;
}
</style>
</head>

<body>

<nav>
    <h1>HELP DESK SYSTEM</h1>
    <div class="links">
        <?php if (!empty($_SESSION['usuario_id'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Sair</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="formulario.php">Cadastro</a>
            <a href="login_adm.php">Admin</a>
        <?php endif; ?>
    </div>
</nav>

<div class="hero">

    <h2>Central de Service Desk</h2>

    <p>
        Gerencie chamados, acompanhe solicitações e organize seu suporte técnico de forma rápida, moderna e eficiente.
    </p>

    <div class="box">
        <?php if (!empty($_SESSION['usuario_id'])): ?>
            <a href="dashboard.php" class="btn btn-login">Dashboard</a>
            <a href="formulario.php" class="btn btn-cadastro">Criar Conta</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-login">Entrar</a>
            <a href="formulario.php" class="btn btn-cadastro">Criar Conta</a>
        <?php endif; ?>
    </div>

    <div class="cards">
        <a href="<?php echo !empty($_SESSION['usuario_id']) ? 'dashboard.php' : 'login.php'; ?>" class="card card-link">
            <h3>Chamados</h3>
            <p>Abertura e acompanhamento de tickets em tempo real.</p>
        </a>

        <a href="suporte.php" class="card card-link">
            <h3>Suporte</h3>
            <p>Atendimento organizado e eficiente para usuários.</p>
        </a>

        <a href="gestao.php" class="card card-link">
            <h3>Gestão</h3>
            <p>Controle completo dos atendimentos e status.</p>
        </a>
    </div>

</div>

</body>
</html>
