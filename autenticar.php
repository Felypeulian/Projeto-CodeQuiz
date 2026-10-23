<?php
require_once __DIR__ . '/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('login.php');
}

$login = campo('login');
$senha = campo('senha', false);

if ($login === '' || $senha === '') {
    $_SESSION['erro'] = 'Informe seu usuário (ou e-mail) e a senha.';
    redirecionar('login.php');
}

// Projeto acadêmico: a senha é comparada em texto puro, direto com o array.
$usuario = buscar_usuario($login);

if ($usuario === null || !hash_equals($usuario['senha'], $senha)) {
    $_SESSION['erro'] = 'Usuário ou senha incorretos.';
    redirecionar('login.php');
}

entrar($usuario);

// Volta para a página que o usuário tentou abrir antes do login.
$destino = $_SESSION['destino'] ?? 'index.php';
unset($_SESSION['destino']);

redirecionar($destino);
