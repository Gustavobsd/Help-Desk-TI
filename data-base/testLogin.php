<?php

include_once('config.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email = ?";

echo "<pre>";
echo "SQL: " . $sql . "<br><br>";

$stmt = $conexao->prepare($sql);

if($stmt === false)
{
    die("ERRO DO MYSQL: " . $conexao->error);
}

$stmt->bind_param("s", $email);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows > 0)
{
    echo "Usuário encontrado!";
}
else
{
    echo "Usuário não encontrado!";
}

?>