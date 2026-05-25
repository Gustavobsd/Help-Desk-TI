<?php
session_start();
include_once('config.php');

/*
|--------------------------------------------------------------------------
| PROTEÇÃO (opcional)
|--------------------------------------------------------------------------
| Se quiser bloquear acesso sem login:
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}
*/
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestão - Service Desk</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#0f172a;
    color:white;
}

/* NAVBAR */
nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    background:rgba(0,0,0,0.4);
    backdrop-filter: blur(10px);
}

nav h1{
    color:#60a5fa;
    font-size:18px;
}

nav a{
    background:#ef4444;
    color:white;
    text-decoration:none;
    padding:8px 14px;
    border-radius:8px;
    font-size:13px;
}

/* CONTAINER */
.container{
    padding:40px;
}

/* CARDS */
.cards{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

.card{
    flex:1;
    min-width:220px;
    background:rgba(255,255,255,0.06);
    padding:20px;
    border-radius:15px;
    border:1px solid rgba(255,255,255,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    color:#93c5fd;
    margin-bottom:10px;
}

.card h2{
    font-size:28px;
}

/* MENU */
.menu{
    margin-top:40px;
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.menu a{
    padding:12px 18px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
}

.menu a:hover{
    background:#1d4ed8;
    transform:scale(1.05);
}
</style>
</head>

<body>

<nav>
    <h1>Gestão Service Desk</h1>
    <a href="logout.php?redirect=home.php">Sair</a>
</nav>

<div class="container">

    <h2 style="margin-bottom:20px;">📊 Painel de Gestão</h2>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Chamados Abertos</h3>
            <h2>12</h2>
        </div>

        <div class="card">
            <h3>Em Atendimento</h3>
            <h2>5</h2>
        </div>

        <div class="card">
            <h3>Fechados</h3>
            <h2>23</h2>
        </div>

        <div class="card">
            <h3>Usuários</h3>
            <h2>8</h2>
        </div>

    </div>

    <!-- MENU -->
    <div class="menu">

        <a href="dashboard.php">📊 Dashboard</a>
        <a href="fechamento_chamados.php">📌 Chamados</a>
        <a href="suporte.php">🤖 Suporte Chat</a>
        <a href="cadastro_admin.php">👤 Administradores</a>

    </div>

</div>

</body>
</html>