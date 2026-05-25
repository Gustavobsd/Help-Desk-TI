<?php
session_start();

// Lista branca de destinos permitidos para evitar open redirect
$allowed = [
    'home.php',
    'login.php',
    'login_adm.php',
    'dashboard.php'
];

// Se foi passado ?redirect=arquivo.php e estiver na lista branca, usaremos ele
$redirect = '';
if (!empty($_GET['redirect'])) {
    $r = basename($_GET['redirect']);
    if (in_array($r, $allowed, true)) {
        $redirect = $r;
    }
}

// Se nenhum redirect válido, escolher padrão conforme tipo de sessão
if ($redirect === '') {
    if (!empty($_SESSION['admin_id'])) {
        $redirect = 'login_admin.php';
    } else {
        $redirect = 'login.php';
    }
}

// limpa dados da sessão e destrói
$_SESSION = [];
session_destroy();

header('Location: ' . $redirect);
exit;
?>