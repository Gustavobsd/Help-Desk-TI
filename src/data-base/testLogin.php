<?php
    if(isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        include_once('config.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Usar prepared statement para evitar SQL injection
        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
        $stmt->bind_param("ss", $email, $senha);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            // Login bem-sucedido, redirecionar para página principal ou dashboard
            header('Location: home.php');
            exit();
        } else {
            // Login falhou, redirecionar de volta ao login
            header('Location: login.php?erro=1');
            exit();
        }
    } else {
        // Dados não enviados, redirecionar
        header('Location: login.php');
        exit();
    }
?>