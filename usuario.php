<?php
require_once __DIR__ . '/init.php';
exigir_login();

$progresso = resumo_progresso();
$conquistas = ($progresso['total'] > 0 ? 1 : 0)
    + ($progresso['total'] > 0 && $progresso['acertos'] === $progresso['total'] ? 1 : 0);

$titulo = 'Meu painel';
$pagina = 'usuario';
require __DIR__ . '/includes/cabecalho.php';
?>
<h1>Olá, <?= h($_SESSION['usuario']['nome']) ?></h1>
<p class="suave"><?= h($_SESSION['usuario']['email']) ?></p>

<div class="numeros">
    <div>
        <strong><?= $progresso['xp'] ?></strong>
        <span>XP acumulado</span>
    </div>
    <div>
        <strong><?= $progresso['acertos'] ?>/<?= $progresso['total'] ?></strong>
        <span>Respostas corretas</span>
    </div>
    <div>
        <strong><?= $progresso['nivel'] ?></strong>
        <span>Nível</span>
    </div>
    <div>
        <strong><?= $conquistas ?></strong>
        <span>Conquistas</span>
    </div>
</div>

<progress value="<?= $progresso['xp_nivel'] ?>" max="250"></progress>
<small class="suave"><?= $progresso['xp_nivel'] ?> de 250 XP para o próximo nível</small>

<p class="suave espaco">O histórico fica guardado apenas durante a sessão atual.</p>

<div class="lista-links">
    <a href="cursos.php">Estudar módulos →</a>
    <a href="quiz.php">Praticar no quiz →</a>
    <a href="logout.php">Sair da conta →</a>
</div>
<?php require __DIR__ . '/includes/rodape.php'; ?>
