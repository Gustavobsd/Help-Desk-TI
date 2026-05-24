<?php
include_once('config.php');

if (isset($_POST['submit'])) {

    $nome = $_POST['nome'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $sexo = $_POST['genero'] ?? '';
    $dataNascimento = $_POST['dataNascimento'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $endereco = $_POST['endereco'] ?? '';

    $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, senha, email, telefone, sexo, dataNascimento, cidade, estado, endereco) 
    VALUES ('$nome', '$senha', '$email', '$telefone', '$sexo', '$dataNascimento', '$cidade', '$estado', '$endereco')");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(to right, rgb(20, 147, 220), rgb(17, 54, 71));
            margin: 0;
            min-height: 100vh;
        }
        .content {
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .box {
            color: white;
            position: relative;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 15px;
            border-radius: 15px;
            width: 380px;
            max-width: 100%;
        }
        fieldset {
            border: 3px solid #46477e;
        }
        legend {
            border: 1px solid #46477e;
            text-align: center;
            background-color: #46477e;
            border-radius: 5%;
            color: white;
        }
        p {
            font-size: 15px;
        }
        .box label {
            font-size: 10px;
            padding: 10px;
        }
        .inputbox {
            position: relative;
            margin-bottom: 20px;
        }
        .inputUser {
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            padding: 5px;
            font-size: 15px;
            width: 100%;
            letter-spacing: 2px;
        }
        .btn {
            background-color: #46477e;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #5a5fa0;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .labelInput {
            position: absolute;
            top: 0px;
            left: 0px;
            transition: 0.5s;
            pointer-events: none;
        }
        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput {
            top: -20px;
            left: 0px;
            font-size: 12px;
            color: rgb(255, 255, 255);
        }
        #dataNascimento {
            background: white;
            padding: 8px;
            border: none;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
        }
        #submit {
            background-image: linear-gradient(to right, #2600ff, #b4a192);
            width: 100%;
            border: none;
            padding: 10px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            border-radius: 10px;
        }
        .a {
            display: inline-block;
            margin-bottom: 18px;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.28);
            background: rgba(255, 255, 255, 0.08);
            color: white;
            text-decoration: none;
            transition: background 0.2s ease;
        }
        .a:hover {
            background: rgba(255, 255, 255, 0.15);
        }
    </style>
</head>
<body>
<div class="content">
    <div class="box">
        <a href="home.php" class="a">← Voltar para Home</a>
        <form action="formulario.php" method="POST">
            <fieldset>
                <legend><b>Novo Usuário</b></legend>
                <br>
                <div class="inputbox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome Completo</label>
                </div>
                <div class="inputbox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <div class="inputbox">
                    <input type="email" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>
                <div class="inputbox">
                    <input type="tel" name="telefone" id="telefone" class="inputUser" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <p>Sexo:</p>
                <input type="radio" id="feminino" name="genero" value="feminino" required>
                <label for="feminino" class="radioLabel">Feminino</label>
                <br>
                <input type="radio" id="masculino" name="genero" value="masculino" required>
                <label for="masculino" class="radioLabel">Masculino</label>
                <br>
                <input type="radio" id="outro" name="genero" value="outro" required>
                <label for="outro" class="radioLabel">Outro</label>
                <br>
                <label for="dataNascimento">Data de Nascimento</label>
                <input type="date" name="dataNascimento" id="dataNascimento" required>
                <br>
                <div class="inputbox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br>
                <div class="inputbox">
                    <input type="text" name="estado" id="estado" class="inputUser" required>
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <br>
                <div class="inputbox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>
                <br>
                <input type="submit" name="submit" value="Enviar" class="btn" id="submit">
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>