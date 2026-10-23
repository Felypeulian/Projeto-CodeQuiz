<?php
require_once __DIR__ . '/init.php';
exigir_login();

$titulo = 'Início';
$pagina = 'inicio';
$progresso = resumo_progresso();

require __DIR__ . '/includes/cabecalho.php';
?>
<section class="hero">
    <p class="etiqueta">Aprenda Pratique Evolua</p>
    <h1>Seu próximo nível em programação<br>começa aqui.</h1>
    <p>Explicações objetivas, desafios por dificuldade e indicadores para acompanhar a sua evolução.</p>

    <a class="botao" href="cursos.php">Explorar módulos</a>
    <a class="botao botao-contorno" href="quiz.php">Começar um quiz</a>
</section>

<section class="recursos">
    <article>
        <h3>Módulos</h3>
        <p>HTML, CSS, JavaScript, PHP e Python, do primeiro contato aos conceitos intermediários.</p>
        <a href="cursos.php">Ver módulos →</a>
    </article>
    <article>
        <h3>Quiz</h3>
        <p>Teste seus conhecimentos, receba feedback e revise o que ainda precisa praticar.</p>
        <a href="quiz.php">Fazer um quiz →</a>
    </article>
    <article>
        <h3>Editor</h3>
        <p>Resolva desafios de HTML e veja o resultado ao lado do código.</p>
        <a href="editor.php">Abrir editor →</a>
    </article>
    <article>
        <h3>Documentação</h3>
        <p>Fundamentos, boas práticas e links para os sites oficiais de cada linguagem.</p>
        <a href="documentacao.php">Estudar →</a>
    </article>
</section>

<section class="progresso">
    <h2>Olá, <?= h($_SESSION['usuario']['nome']) ?></h2>

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
            <strong>Nível <?= $progresso['nivel'] ?></strong>
            <span>Calculado a partir do XP</span>
        </div>
    </div>

    <progress value="<?= $progresso['xp_nivel'] ?>" max="250"></progress>
    <small class="suave"><?= $progresso['xp_nivel'] ?> de 250 XP para o próximo nível</small>
</section>
<?php require __DIR__ . '/includes/rodape.php'; ?>
