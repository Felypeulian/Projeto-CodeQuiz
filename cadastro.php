<?php
require_once __DIR__ . '/init.php';

if (!empty($_SESSION['usuario'])) {
    redirecionar('index.php');
}

$erro = '';
$nome = preg_replace('/[\r\n\t]+/', ' ', campo('nome'));
$usuario = campo('usuario');
$email = strtolower(campo('email'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha = campo('senha', false);
    $confirmacao = campo('confirmacao', false);

    if ($nome === '' || mb_strlen($nome) > 60) {
        $erro = 'Digite seu nome (até 60 caracteres).';
    } elseif (!preg_match('/^[a-z0-9_]{3,20}$/i', $usuario)) {
        $erro = 'O usuário deve ter de 3 a 20 letras, números ou _.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Digite um e-mail válido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha precisa ter pelo menos 6 caracteres.';
    } elseif ($senha !== $confirmacao) {
        $erro = 'As senhas não coincidem.';
    } elseif (buscar_usuario($usuario) !== null || buscar_usuario($email) !== null) {
        $erro = 'Este usuário ou e-mail já está cadastrado.';
    } else {
        $novo = [
            'usuario' => $usuario,
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha,
            'admin' => false,
        ];

        $usuarios = carregar_usuarios();
        $usuarios[] = $novo;

        if (salvar_usuarios($usuarios)) {
            entrar($novo);
            redirecionar('index.php');
        }

        $erro = 'Não foi possível salvar a conta. Verifique as permissões da pasta data/.';
    }
}

$titulo = 'Criar conta';
$publico = true;
require __DIR__ . '/includes/cabecalho.php';
?>
<section class="formulario">
    <h1>Criar conta</h1>
    <p class="suave">Cadastre-se para acessar o CodeQuiz.</p>

    <?php if ($erro !== ''): ?>
        <p class="erro"><?= h($erro) ?></p>
    <?php endif; ?>

    <form method="post" action="cadastro.php">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="<?= h($nome) ?>" required>

        <label for="usuario">Usuário</label>
        <input type="text" id="usuario" name="usuario" value="<?= h($usuario) ?>" autocomplete="username" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="<?= h($email) ?>" required>

        <label for="senha">Senha (mínimo 6 caracteres)</label>
        <input type="password" id="senha" name="senha" autocomplete="new-password" required>

        <label for="confirmacao">Confirmar senha</label>
        <input type="password" id="confirmacao" name="confirmacao" autocomplete="new-password" required>

        <button type="submit">Criar conta</button>
    </form>

    <p class="suave">Já tem conta? <a href="login.php">Entrar</a></p>
</section>
<?php require __DIR__ . '/includes/rodape.php'; ?>
