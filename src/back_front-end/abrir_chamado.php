<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Abrir Chamado</title>

<style>
:root{
    --bg1: #0f1724;
    --bg2: #0b3a57;
    --card: rgba(255,255,255,0.06);
    --accent: #1fb6ff;
    --accent-2: #3b82f6;
    --glass: rgba(255,255,255,0.04);
}

*{box-sizing:border-box}
body {
    font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    background: linear-gradient(135deg, var(--bg2) 0%, var(--bg1) 100%);
    color: #080808;
    margin:0;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:32px;
}

.container{
    width:100%;
    max-width:820px;
    background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
    border-radius:14px;
    padding:28px;
    box-shadow: 0 10px 30px rgba(2,6,23,0.6);
    border: 1px solid rgba(255,255,255,0.04);
}

.header{
    display:flex;
    align-items:center;
    gap:16px;
    margin-bottom:18px;
}

.logo{
    width:56px;height:56px;border-radius:10px;background:linear-gradient(135deg,var(--accent),var(--accent-2));
    display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:20px;
}

h1{margin:0;font-size:20px}

.card{
    background: var(--card);
    padding:20px;
    border-radius:12px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

label{display:block;font-size:13px;margin-bottom:6px;color:#cfe9ff}

input[type="text"], textarea, select, input[type="email"]{
    width:100%;
    padding:12px 14px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,0.06);
    background:transparent;
    color:inherit;
    outline:none;
    transition:box-shadow .12s, border-color .12s;
}

input:focus, textarea:focus, select:focus{
    box-shadow: 0 6px 18px rgba(31,182,255,0.08);
    border-color: var(--accent);
}

textarea{resize:vertical;min-height:120px}

.actions{display:flex;gap:12px;margin-top:10px}

.btn{
    flex:1;padding:12px 16px;border-radius:10px;border:none;cursor:pointer;font-weight:600;
}

.btn-primary{background:linear-gradient(90deg,var(--accent),var(--accent-2));color:#012036}
.btn-secondary{background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--accent)}

.note{font-size:13px;color:#9fc9ff;margin-top:8px}

@media (max-width:640px){
    .form-grid{grid-template-columns:1fr}
    .header{gap:10px}
    .logo{width:48px;height:48px}
}
</style>

</head>
<body>

<div class="container">
    <div class="header">
        <div class="logo">SC</div>
        <div>
            <h1>Abrir Chamado</h1>
            <div style="font-size:13px;color:#bfe6ff;margin-top:4px">Preencha os dados para registrar seu chamado</div>
        </div>
    </div>

    <div class="card">
        <?php if(isset($_POST['submit'])): ?>
            <div style="padding:12px;border-radius:8px;background:linear-gradient(90deg,#0b513f,#063a30);margin-bottom:12px;color:#dfffe6">Chamado enviado com sucesso.</div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-grid">
                <div>
                    <label for="titulo">Título</label>
                    <input id="titulo" type="text" name="titulo" placeholder="Resumo curto do problema" required>
                </div>

                <div>
                    <label for="prioridade">Prioridade</label>
                    <select id="prioridade" name="prioridade">
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
            </div>

            <div style="margin-top:12px">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" placeholder="Descreva o problema com detalhes, passos para reproduzir e prints se houver." rows="6"></textarea>
            </div>

            <div class="actions">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('titulo').value='';document.getElementById('descricao').value='';document.getElementById('prioridade').selectedIndex=0">Limpar</button>
                <button type="submit" name="submit" class="btn btn-primary">Enviar Chamado</button>
            </div>

            <div class="note">Ao enviar, nossa equipe receberá a solicitação e entrará em contato.</div>
        </form>
    </div>
</div>

</body>
</html>