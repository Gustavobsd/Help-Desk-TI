<?php
session_start();

// Defina a senha autorizada
$senha_autorizada = "12345"; // troque por uma senha segura

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha = $_POST["senha"];

    if ($senha === $senha_autorizada) {
        $_SESSION["autorizado"] = true;
        header("Location: login_adm.php");
        exit();
    } else {
        $erro = "Senha incorreta!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Proteção</title>
</head>
<body>
    <h2>Digite a senha para acessar</h2>
    <form method="POST">
        <input type="password" name="senha" required>
        <button type="submit">Entrar</button>
    </form>
    <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
</body>
</html>
