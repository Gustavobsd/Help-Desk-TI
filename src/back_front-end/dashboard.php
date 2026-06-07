<?php

session_start();
include_once('config.php');

if (!isset($conexao) || !$conexao instanceof mysqli) {
    die('Erro interno: conexão com o banco de dados não inicializada. Verifique config.php.');
}

if (empty($_SESSION['usuario_id'])) {
    header('Location: login.php?msg=login');
    exit;
}

$nome = htmlspecialchars(
    $_SESSION['usuario_nome'] ?? 'Usuário'
);

$usuarioId = (int) $_SESSION['usuario_id'];

$mensagem = '';
$erro = '';

/*
|--------------------------------------------------------------------------
| CRIAR TABELA AUTOMATICAMENTE
|--------------------------------------------------------------------------
*/

$createTableSql = "

CREATE TABLE IF NOT EXISTS chamados (

    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NOT NULL,

    titulo VARCHAR(255) NOT NULL,

    categoria VARCHAR(100) NOT NULL,

    prioridade ENUM(
        'baixa',
        'media',
        'alta'
    ) NOT NULL DEFAULT 'media',

    descricao TEXT NOT NULL,

    status ENUM(
        'aberto',
        'em andamento',
        'concluido'
    ) NOT NULL DEFAULT 'aberto',

    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)

ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4

";

$conexao->query($createTableSql);

/*
|--------------------------------------------------------------------------
| MENSAGEM
|--------------------------------------------------------------------------
*/

if(isset($_GET['sucesso']))
{
    $mensagem =
        'Chamado aberto com sucesso!';
}

/*
|--------------------------------------------------------------------------
| ABRIR CHAMADO
|--------------------------------------------------------------------------
*/

if(
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['submit_chamado'])
)
{
    $titulo =
        trim($_POST['titulo'] ?? '');

    $categoria =
        trim($_POST['categoria'] ?? '');

    $prioridade =
        trim($_POST['prioridade'] ?? '');

    $descricao =
        trim($_POST['descricao'] ?? '');

    if(
        $titulo === '' ||
        $categoria === '' ||
        $descricao === ''
    )
    {
        $erro =
            'Preencha todos os campos.';
    }
    else
    {
        $sql = "

        INSERT INTO chamados
        (
            usuario_id,
            titulo,
            categoria,
            prioridade,
            descricao
        )

        VALUES (?, ?, ?, ?, ?)

        ";

        $stmt = $conexao->prepare($sql);

        if($stmt)
        {
            $stmt->bind_param(
                'issss',
                $usuarioId,
                $titulo,
                $categoria,
                $prioridade,
                $descricao
            );

            if($stmt->execute())
            {
                header(
                    "Location: ".
                    $_SERVER['PHP_SELF'].
                    "?sucesso=1"
                );

                exit;
            }
            else
            {
                $erro =
                    'Erro ao abrir chamado.';
            }

            $stmt->close();
        }
        else
        {
            $erro = 'Erro SQL.';
        }
    }
}

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

$dashboard = [

    'baixa' => 0,
    'media' => 0,
    'alta' => 0

];

$sqlDashboard = "

SELECT
prioridade,
COUNT(*) as total

FROM chamados

WHERE usuario_id = ?

GROUP BY prioridade

";

$stmtDashboard =
    $conexao->prepare($sqlDashboard);

if($stmtDashboard)
{
    $stmtDashboard->bind_param(
        'i',
        $usuarioId
    );

    $stmtDashboard->execute();

    $resultadoDashboard =
        $stmtDashboard->get_result();

    while(
        $row =
        $resultadoDashboard->fetch_assoc()
    )
    {
        $dashboard[
            $row['prioridade']
        ] = $row['total'];
    }

    $stmtDashboard->close();
}

/*
|--------------------------------------------------------------------------
| LISTAR CHAMADOS
|--------------------------------------------------------------------------
*/

$chamados = [];

$sqlChamados = "

SELECT

id,
titulo,
categoria,
prioridade,
status,
criado_em

FROM chamados

WHERE usuario_id = ?

ORDER BY criado_em DESC

";

$stmtChamados =
    $conexao->prepare($sqlChamados);

if($stmtChamados)
{
    $stmtChamados->bind_param(
        'i',
        $usuarioId
    );

    $stmtChamados->execute();

    $resultado =
        $stmtChamados->get_result();

    while(
        $row =
        $resultado->fetch_assoc()
    )
    {
        $chamados[] = $row;
    }

    $stmtChamados->close();
}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>
Sistema de Chamados
</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    background:#0b1120;
    color:white;
}

.container{
    width:95%;
    max-width:1300px;
    margin:auto;
    padding:20px;
}

.topo{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.topo h1{
    font-size:32px;
}

.logout{
    padding:10px 20px;
    background:#ff5e5e;
    color:white;
    border-radius:10px;
    text-decoration:none;
}

.dashboard{
    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(220px,1fr));

    gap:20px;

    margin-bottom:30px;
}

.dashboard-card{
    background:#131c31;
    padding:25px;
    border-radius:20px;
    text-align:center;
}

.dashboard-card h3{
    margin-bottom:15px;
    font-size:20px;
}

.dashboard-card span{
    font-size:45px;
    font-weight:bold;
}

.card-baixa{
    border-left:8px solid #4f8cff;
}

.card-media{
    border-left:8px solid #f0b429;
}

.card-alta{
    border-left:8px solid #ff5e5e;
}

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}

.box{
    background:#131c31;
    border-radius:20px;
    padding:25px;
}

.box h2{
    margin-bottom:20px;
}

input,
select,
textarea{
    width:100%;
    padding:14px;
    margin-bottom:15px;
    border:none;
    border-radius:10px;
    background:#1c2742;
    color:white;
}

textarea{
    min-height:150px;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#4f8cff;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#3c74db;
}

.ticket{
    background:#1c2742;
    padding:18px;
    border-radius:15px;
    margin-bottom:15px;
}

.badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
    margin-top:10px;
    margin-right:10px;
}

.badge-alta{
    background:#ff5e5e;
}

.badge-media{
    background:#f0b429;
}

.badge-baixa{
    background:#4f8cff;
}

.badge-status{
    background:#29c57c;
}

.msg{
    background:#29c57c;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

.erro{
    background:#ff5e5e;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

@media(max-width:900px)
{
    .grid{
        grid-template-columns:1fr;
    }
}

</style>

</head>

<body>

<div class="container">

<div class="topo">

<div>

<h1>
Sistema de Chamados
</h1>

<p>

Bem-vindo,
<?php echo $nome; ?>

</p>

</div>

<a
href="logout.php"
class="logout"
>

Sair

</a>

</div>

<?php if($mensagem): ?>

<div class="msg">

<?php echo $mensagem; ?>

</div>

<?php endif; ?>

<?php if($erro): ?>

<div class="erro">

<?php echo $erro; ?>

</div>

<?php endif; ?>

<!-- DASHBOARD -->

<div class="dashboard">

<div class="dashboard-card card-baixa">

<h3>
Baixa Prioridade
</h3>

<span>
<?php echo $dashboard['baixa']; ?>
</span>

</div>

<div class="dashboard-card card-media">

<h3>
Média Prioridade
</h3>

<span>
<?php echo $dashboard['media']; ?>
</span>

</div>

<div class="dashboard-card card-alta">

<h3>
Alta Prioridade
</h3>

<span>
<?php echo $dashboard['alta']; ?>
</span>

</div>

</div>

<div class="grid">

<!-- FORMULÁRIO -->

<div class="box">

<h2>
Abrir Chamado
</h2>

<form method="POST">

<input
type="text"
name="titulo"
placeholder="Título do chamado"
required
>

<select
name="categoria"
required
>

<option value="">
Selecione a categoria
</option>

<option value="Rede">
Rede
</option>

<option value="Sistema">
Sistema
</option>

<option value="Servidor">
Servidor
</option>

<option value="Banco de Dados">
Banco de Dados
</option>

<option value="Segurança">
Segurança
</option>

<option value="Hardware">
Hardware
</option>

</select>

<select
name="prioridade"
required
>

<option value="baixa">
Baixa
</option>

<option value="media">
Média
</option>

<option value="alta">
Alta
</option>

</select>

<textarea
name="descricao"
placeholder="Descreva o problema..."
required
></textarea>

<button
type="submit"
name="submit_chamado"
>

Abrir Chamado

</button>

</form>

</div>

<!-- CHAMADOS -->

<div class="box">

<h2>
Meus Chamados
</h2>

<?php if(empty($chamados)): ?>

<p>

Nenhum chamado encontrado.

</p>

<?php else: ?>

<?php foreach($chamados as $ticket): ?>

<div class="ticket">

<h3>

#<?php echo $ticket['id']; ?>

-

<?php echo htmlspecialchars(
$ticket['titulo']
); ?>

</h3>

<p>

Categoria:

<strong>

<?php echo htmlspecialchars(
$ticket['categoria']
); ?>

</strong>

</p>

<span
class="badge badge-<?php
echo $ticket['prioridade'];
?>"
>

<?php echo ucfirst(
$ticket['prioridade']
); ?>

</span>

<span
class="badge badge-status"
>

<?php echo ucfirst(
$ticket['status']
); ?>

</span>

<p style="margin-top:12px;">

<?php

echo date(
'd/m/Y H:i',
strtotime($ticket['criado_em'])
);

?>

</p>

</div>

<?php endforeach; ?>

<?php endif; ?>

</div>

</div>

</div>

</body>

</html>