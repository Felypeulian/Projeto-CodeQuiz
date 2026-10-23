<?php
require_once __DIR__ . '/init.php';

if (!empty($_SESSION['usuario'])) {
    redirecionar('index.php');
}

// Mensagem de erro deixada por autenticar.php (exibida uma única vez).
$erro = $_SESSION['erro'] ?? '';
unset($_SESSION['erro']);

$titulo = 'Entrar';
$publico = true;
require __DIR__ . '/includes/cabecalho.php';
?>
<section class="formulario">
    <h1>Entrar</h1>
    <p class="suave">Acesse sua conta para continuar.</p>

    <?php if ($erro !== ''): ?>
        <p class="erro"><?= h($erro) ?></p>
    <?php endif; ?>

    <form method="post" action="autenticar.php">
        <label for="login">Usuário ou e-mail</label>
        <input type="text" id="login" name="login" autocomplete="username" required>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" autocomplete="current-password" required>

        <button type="submit">Entrar</button>
    </form>

    <p class="suave">Ainda não tem conta? <a href="cadastro.php">Criar conta</a></p>
</section>
<?php require __DIR__ . '/includes/rodape.php'; ?>
