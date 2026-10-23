<?php
require_once __DIR__ . '/init.php';
exigir_admin();

$titulo = 'Administração';
$pagina = 'admin';
require __DIR__ . '/includes/cabecalho.php';
?>
<p class="etiqueta">Área restrita</p>
<h1>Painel administrativo</h1>
<p class="suave">Conta: <?= h($_SESSION['usuario']['email']) ?></p>

<div class="recursos">
    <article>
        <h3>Conteúdo</h3>
        <p>Revise os módulos e a documentação.</p>
        <a href="cursos.php">Módulos →</a>
        <a href="documentacao.php">Documentação →</a>
    </article>
    <article>
        <h3>Quiz</h3>
        <p>Confira as atividades disponíveis.</p>
        <a href="quiz.php">Abrir quiz →</a>
    </article>
    <article>
        <h3>Editor</h3>
        <p>Teste a área de desafios de HTML.</p>
        <a href="editor.php">Abrir editor →</a>
    </article>
</div>
<?php require __DIR__ . '/includes/rodape.php'; ?>
