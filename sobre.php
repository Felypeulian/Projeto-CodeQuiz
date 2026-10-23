<?php
require_once __DIR__ . '/init.php';
exigir_login();

$titulo = 'Sobre';
$pagina = 'sobre';
require __DIR__ . '/includes/cabecalho.php';
?>
<p class="etiqueta">CodeQuiz · sua jornada</p>
<h1>Sobre o CodeQuiz</h1>
<p class="suave intro">
    O CodeQuiz é um ambiente de aprendizagem prática para quem quer começar a programar ou consolidar
    fundamentos. A ideia é combinar documentação clara, exemplos pequenos, exercícios com feedback e
    indicadores de evolução.
</p>

<div class="recursos">
    <article>
        <h3>Aprender fazendo</h3>
        <p>Conteúdos curtos ligados a exercícios e exemplos que podem ser modificados.</p>
    </article>
    <article>
        <h3>Evolução visível</h3>
        <p>Níveis e metas para ajudar a identificar o que estudar a seguir.</p>
    </article>
    <article>
        <h3>Acesso gradual</h3>
        <p>Uma base gratuita para conhecer as linguagens e praticar no próprio ritmo.</p>
    </article>
</div>

<h2>O que queremos construir</h2>
<ul>
    <li>Módulos organizados por iniciante, intermediário e avançado.</li>
    <li>Exemplos comentados e editor de experimentação.</li>
    <li>Quizzes com explicação das respostas.</li>
    <li>Histórico de evolução e conquistas.</li>
</ul>

<p><a class="botao" href="cursos.php">Conhecer os módulos</a></p>
<?php require __DIR__ . '/includes/rodape.php'; ?>
