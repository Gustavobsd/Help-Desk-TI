<?php

session_start();
include_once('config.php');

/*
|--------------------------------------------------------------------------
| VERIFICA LOGIN ADMIN
|--------------------------------------------------------------------------
*/

if(empty($_SESSION['admin_id']))
{
    header('Location: login_adm.php');
    exit;
}

$mensagem = '';
$erro = '';

/*
|--------------------------------------------------------------------------
| LOGOUT ADMIN
|--------------------------------------------------------------------------
*/

if(isset($_GET['logout']))
{
    session_destroy();

    header('Location: login_adm.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| ALTERAR STATUS DO CHAMADO
|--------------------------------------------------------------------------
*/

if(
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['editar_chamado'])
)
{
    $id = (int) $_POST['id'];

    $status = trim($_POST['status']);

    $statusPermitidos = [
        'aberto',
        'em andamento',
        'concluido'
    ];

    if(!in_array($status, $statusPermitidos))
    {
        $erro = 'Status inválido.';
    }
    else
    {
        $sql = "

        UPDATE chamados

        SET status = ?

        WHERE id = ?

        ";

        $stmt = $conexao->prepare($sql);

        if($stmt)
        {
            $stmt->bind_param(
                'si',
                $status,
                $id
            );

            if($stmt->execute())
            {
                $mensagem =
                    'Chamado atualizado com sucesso!';
            }
            else
            {
                $erro =
                    'Erro ao atualizar chamado.';
            }

            $stmt->close();
        }
        else
        {
            $erro =
                'Erro SQL: ' .
                $conexao->error;
        }
    }
}

/*
|--------------------------------------------------------------------------
| EXCLUIR CHAMADO CONCLUÍDO
|--------------------------------------------------------------------------
*/

if(
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['excluir_chamado'])
)
{
    $id = (int) $_POST['id'];

    $sqlDelete = "

    DELETE FROM chamados

    WHERE id = ?
    AND status = 'concluido'

    ";

    $stmtDelete = $conexao->prepare($sqlDelete);

    if($stmtDelete)
    {
        $stmtDelete->bind_param(
            'i',
            $id
        );

        if($stmtDelete->execute())
        {
            $mensagem =
                'Chamado excluído com sucesso!';
        }
        else
        {
            $erro =
                'Erro ao excluir chamado.';
        }

        $stmtDelete->close();
    }
    else
    {
        $erro =
            'Erro SQL ao excluir.';
    }
}

/*
|--------------------------------------------------------------------------
| LISTAR TODOS CHAMADOS
|--------------------------------------------------------------------------
*/

$chamados = [];

$sqlChamados = "

SELECT
    id,
    titulo,
    categoria,
    prioridade,
    descricao,
    status,
    criado_em

FROM chamados

ORDER BY criado_em DESC

";

$resultado = $conexao->query($sqlChamados);

if($resultado)
{
    while($row = $resultado->fetch_assoc())
    {
        $chamados[] = $row;
    }
}
else
{
    $erro =
        'Erro ao buscar chamados.';
}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Fechamento de Chamados</title>

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
}

.container{
    width:95%;
    max-width:1400px;
    margin:auto;
    padding:30px;
}

.topo{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    gap:20px;
}

.topo h1{
    font-size:34px;
}

.topo p{
    color:#94a3b8;
    margin-top:8px;
}

.botoes{
    display:flex;
    gap:15px;
}

.btn{
    padding:12px 20px;
    border-radius:12px;
    text-decoration:none;
    color:white;
    font-weight:bold;
    transition:0.3s;
}

.btn-voltar{
    background:#2563eb;
}

.btn-voltar:hover{
    background:#1d4ed8;
}

.btn-sair{
    background:#ef4444;
}

.btn-sair:hover{
    background:#dc2626;
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

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(340px,1fr));
    gap:25px;
}

.card{
    background:#1e293b;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h2{
    margin-bottom:15px;
    font-size:22px;
}

.info{
    margin-bottom:12px;
    color:#cbd5e1;
}

.descricao{
    background:#0f172a;
    padding:15px;
    border-radius:12px;
    margin-top:15px;
    margin-bottom:20px;
    color:#e2e8f0;
    line-height:1.5;
}

.badge{
    display:inline-block;
    padding:8px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
    margin-right:10px;
    margin-top:10px;
}

.alta{
    background:#ef4444;
}

.media{
    background:#f59e0b;
}

.baixa{
    background:#3b82f6;
}

.status{
    background:#22c55e;
}

form{
    margin-top:20px;
}

select{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:#0f172a;
    color:white;
    margin-bottom:15px;
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
    cursor:pointer;
    font-weight:bold;
    transition:0.3s;
}

button:hover{
    background:#1d4ed8;
}

.btn-excluir{
    background:#ef4444;
    margin-top:12px;
}

.btn-excluir:hover{
    background:#dc2626;
}

.data{
    margin-top:15px;
    color:#94a3b8;
    font-size:14px;
}

.sem{
    background:#1e293b;
    padding:30px;
    border-radius:20px;
    text-align:center;
    color:#cbd5e1;
}

@media(max-width:768px)
{
    .topo{
        flex-direction:column;
        align-items:flex-start;
    }

    .botoes{
        width:100%;
        flex-direction:column;
    }

    .btn{
        text-align:center;
    }
}

</style>

</head>

<body>

<div class="container">

<div class="topo">

<div>

<h1>Gerenciamento de Chamados</h1>

<p>
Administrador:
<strong>
<?php echo $_SESSION['admin_nome']; ?>
</strong>
</p>

</div>

<div class="botoes">

<a href="logout.php?redirect=login_adm.php" class="btn btn-sair">
Sair
</a>


</div>

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

<?php if(empty($chamados)): ?>

<div class="sem">

Nenhum chamado encontrado.

</div>

<?php else: ?>

<div class="grid">

<?php foreach($chamados as $ticket): ?>

<div class="card">

<h2>

#<?php echo $ticket['id']; ?>

-

<?php echo htmlspecialchars(
    $ticket['titulo']
); ?>

</h2>

<div class="info">

<strong>Categoria:</strong>

<?php echo htmlspecialchars(
    $ticket['categoria']
); ?>

</div>

<span class="badge <?php
echo $ticket['prioridade'];
?>">

<?php echo ucfirst(
    $ticket['prioridade']
); ?>

</span>

<span class="badge status">

<?php echo ucfirst(
    $ticket['status']
); ?>

</span>

<div class="descricao">

<?php echo nl2br(
    htmlspecialchars(
        $ticket['descricao']
    )
); ?>

</div>

<form method="POST">

<input
type="hidden"
name="id"
value="<?php echo $ticket['id']; ?>"
>

<select name="status">

<option value="aberto"
<?php
if($ticket['status'] == 'aberto')
{
    echo 'selected';
}
?>
>
Aberto
</option>

<option value="em andamento"
<?php
if($ticket['status'] == 'em andamento')
{
    echo 'selected';
}
?>
>
Em andamento
</option>

<option value="concluido"
<?php
if($ticket['status'] == 'concluido')
{
    echo 'selected';
}
?>
>
Concluído
</option>

</select>

<button
type="submit"
name="editar_chamado"
>

Salvar Alterações

</button>

</form>

<?php if($ticket['status'] == 'concluido'): ?>

<form method="POST">

<input
type="hidden"
name="id"
value="<?php echo $ticket['id']; ?>"
>

<button
type="submit"
name="excluir_chamado"
class="btn-excluir"
onclick="return confirm('Deseja excluir este chamado?')"
>

Excluir Chamado

</button>

</form>

<?php endif; ?>

<div class="data">

Criado em:

<?php

echo date(
    'd/m/Y H:i',
    strtotime($ticket['criado_em'])
);

?>

</div>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>

</div>

</body>

</html>