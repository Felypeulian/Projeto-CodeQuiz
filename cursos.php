<?php
require_once __DIR__ . '/init.php';
exigir_login();

// Cada curso: nome, ícone, descrição, linguagem na documentação e nível.
$cursos = [
    ['HTML', 'html.png', 'Estrutura de páginas web.', 'html', 'Iniciante'],
    ['CSS', 'css-3.png', 'Cores, layout e responsividade.', 'css', 'Iniciante'],
    ['JavaScript', 'js.png', 'Lógica e interatividade no navegador.', 'javascript', 'Iniciante'],
    ['PHP', 'php.png', 'Programação no servidor, formulários e login.', 'php', 'Intermediário'],
    ['Python', 'python.png', 'Lógica de programação com sintaxe simples.', 'python', 'Iniciante'],
];

$titulo = 'Módulos';
$pagina = 'cursos';
require __DIR__ . '/includes/cabecalho.php';
?>
<p class="etiqueta">Trilhas de aprendizagem</p>
<h1>Escolha seu próximo módulo</h1>
<p class="suave">Cada módulo reúne explicações, exemplos e exercícios para você praticar.</p>

<div class="cursos">
    <?php foreach ($cursos as [$nome, $icone, $descricao, $linguagem, $nivel]): ?>
        <article class="curso">
            <img src="img/<?= $icone ?>" alt="<?= h($nome) ?>">
            <h2><?= h($nome) ?></h2>
            <p class="etiqueta"><?= h($nivel) ?></p>
            <p><?= h($descricao) ?></p>
            <a href="documentacao.php?linguagem=<?= $linguagem ?>">Começar →</a>
        </article>
    <?php endforeach; ?>
</div>

<a class="botao" href="quiz.php">Testar meu nível</a>
<?php require __DIR__ . '/includes/rodape.php'; ?>
