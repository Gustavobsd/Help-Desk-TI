<?php
session_start();

/*
|--------------------------------------------------------------------------
| CHATBOT SIMPLES (REGRAS DE SUPORTE)
|--------------------------------------------------------------------------
*/

function chatbotResposta($mensagem) {

    $msg = strtolower(trim($mensagem));

    if (strpos($msg, 'senha') !== false) {
        return "🔐 Para redefinir sua senha, acesse 'Esqueci minha senha' na tela de login.";
    }

    if (strpos($msg, 'login') !== false) {
        return "👤 Verifique se seu e-mail e senha estão corretos. Caso não consiga, abra um chamado.";
    }

    if (strpos($msg, 'chamado') !== false) {
        return "📌 Você pode abrir um chamado no menu principal do sistema de Service Desk.";
    }

    if (strpos($msg, 'erro') !== false) {
        return "⚠️ Descreva o erro com detalhes para que possamos te ajudar melhor.";
    }

    if (strpos($msg, 'oi') !== false || strpos($msg, 'olá') !== false) {
        return "👋 Olá! Como posso te ajudar hoje?";
    }

    return "🤖 Não entendi sua solicitação. Tente perguntar sobre login, senha ou chamados.";
}

/*
|--------------------------------------------------------------------------
| ENVIAR MENSAGEM
|--------------------------------------------------------------------------
*/

$resposta = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se o usuário clicar em "Sair", encerra a sessão e retorna para home.php
    if (isset($_POST['sair'])) {
        // limpa e encerra sessão
        $_SESSION = [];
        session_destroy();
        header('Location: home.php');
        exit;
    }

    // Se o usuário clicar em "Finalizar Atendimento", redireciona para home.php
    if (!empty($_POST['finalizar'])) {
        header('Location: home.php');
        exit;
    }

    $mensagem = $_POST['mensagem'] ?? '';
    $resposta = chatbotResposta($mensagem);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Suporte - Chatbot</title>

<style>
body{
    font-family: Arial;
    background:#0f172a;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.chat-container{
    width:400px;
    background:#1e293b;
    border-radius:15px;
    padding:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
}

h2{
    text-align:center;
    color:#60a5fa;
}

.chat-box{
    height:300px;
    overflow-y:auto;
    background:#0f172a;
    padding:10px;
    border-radius:10px;
    margin-bottom:10px;
}

.msg-user{
    text-align:right;
    margin:10px 0;
    color:#22c55e;
}

.msg-bot{
    text-align:left;
    margin:10px 0;
    color:#60a5fa;
}

input{
    width:75%;
    padding:10px;
    border:none;
    border-radius:8px;
}

button{
    width:22%;
    padding:10px;
    border:none;
    background:#2563eb;
    color:white;
    border-radius:8px;
    cursor:pointer;
}

button:hover{
    background:#1d4ed8;
}
</style>
</head>

<body>

<div class="chat-container">

<h2>🤖 Suporte Service Desk</h2>

<div class="chat-box">

    <?php if(isset($_POST['mensagem'])): ?>
        <div class="msg-user">
            👤 Você: <?php echo htmlspecialchars($_POST['mensagem']); ?>
        </div>

        <div class="msg-bot">
            🤖 Bot: <?php echo $resposta; ?>
        </div>
    <?php else: ?>
        <div class="msg-bot">🤖 Bot: Olá! Como posso te ajudar?</div>
    <?php endif; ?>

</div>

<form id="chatForm" method="POST" style="display:flex; gap:5px;">
    <input type="text" name="mensagem" placeholder="Digite sua dúvida..." required>
    <input type="hidden" name="finalizar" id="finalizarInput" value="">
    <button type="submit" name="enviar">Enviar</button>
    <button type="button" id="btnFinalizar" style="background:#ef4444;color:white;border:none;padding:10px;border-radius:8px;">Finalizar Atendimento</button>
</form>

<script>
document.getElementById('btnFinalizar').addEventListener('click', function(){
    if (confirm('Deseja finalizar o atendimento?')) {
        document.getElementById('finalizarInput').value = '1';
        document.getElementById('chatForm').submit();
    }
});
</script>

    <form method="POST" style="margin-top:12px;">
    <button type="submit" name="sair" value="1" style="background:#6b7280;color:white;border:none;padding:10px;border-radius:8px;">Sair</button>
</form>

</div>

</body>
</html>