<?php
session_start();

if (!empty($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../type.css">
    <style>
      body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
      font-family: Arial, sans-serif;
    }

    .glas-container {
      width: 320px;
      padding: 30px;
      border-radius: 20px;
      backdrop-filter: blur(15px);
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      color: white;
    }

    .input-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;
    }

    .input-group label {
      margin-bottom: 5px;
      font-size: 14px;
    }

    .input-group input {
      padding: 10px;
      border-radius: 8px;
      border: none;
      outline: none;
    }
    .acesso{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .button {
      padding: 10px;
      border-radius: 8px;
      width: 100%;
      color: white;
      border: none;
      background-color: rgb(4, 119, 235);
      cursor: pointer;
      font-size: 20px;
    }
    .button:hover {
      background-color: rgba(10, 107, 204, 0.8);
    }

    .a {
      display: inline-block;
      margin-bottom: 20px;
      padding: 10px 14px;
      border-radius: 8px;
      border: 1px solid rgba(255, 255, 255, 0.35);
      background: rgba(255, 255, 255, 0.08);
      color: white;
      text-decoration: none;
      transition: background 0.2s ease;
    }
    .a:hover {
      background: rgba(255, 255, 255, 0.15);
    }

    .acesso a {
      color: white;
      text-decoration: none;
    }
    </style>
</head>
<body>
  <?php if (isset($_GET['msg']) && $_GET['msg'] === 'login'): ?>
    <div style="padding: 12px; margin: 20px auto 0; width: fit-content; border-radius: 10px; background: #1d4ed8; color: white; text-align: center;">
      Faça login para acessar o dashboard.
    </div>
  <?php endif; ?>
  <div class="glas-container">
    <a href="home.php" class="a">← Voltar para Home</a>
    <h1>Login</h1>
    <form action="testLogin.php" method="POST">
    <div class="input-group">
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="input-group">
      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha" required>
    </div>

    <div class="acesso">
      <label>
        <input type="checkbox"> Lembrar
      </label>
      <a href="#">Esqueci minha senha</a>
    </div>
    <button class="button" type="submit" name="submit"> Entrar </button>
    </form>
    <div style="margin-top: 18px; text-align: center;">
      <a href="login_adm.php" class="a">Área Administrativa</a>
    </div>
  </div>
</body>
</html>
