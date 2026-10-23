<?php
require_once __DIR__ . '/init.php';
exigir_login();

// Cada plano: nome, preço, período, descrição, benefícios e se tem destaque.
$planos = [
    [
        'Grátis', 'R$ 0', 'para sempre', 'Comece sua jornada na programação.',
        ['Aulas básicas', 'Quizzes iniciais', 'Exercícios de programação', 'Sistema de progresso', 'Conquistas básicas', 'Limite de uso diário'],
        false,
    ],
    [
        'Anual', 'R$ 149,90', 'pagamento anual', 'Pague uma vez ao ano e tenha acesso a tudo.',
        ['Tudo do plano Grátis', 'Acesso anual', 'Todos os cursos', 'Quizzes exclusivos', 'Medalha exclusiva'],
        false,
    ],
    [
        'Vitalício', 'R$ 299,90', 'pagamento único', 'Pague uma vez e aprenda para sempre.',
        ['Tudo do plano Grátis', 'Acesso vitalício', 'Todos os cursos atuais', 'Novos cursos futuros', 'Medalha exclusiva'],
        true,
    ],
];

$titulo = 'Preços';
$pagina = 'assinaturas';
require __DIR__ . '/includes/cabecalho.php';
?>
<p class="etiqueta">Planos</p>
<h1>Escolha seu plano e comece a programar</h1>
<p class="suave">Aprenda, pratique e evolua com o CodeQuiz.</p>

<div class="planos">
    <?php foreach ($planos as [$nome, $preco, $periodo, $descricao, $beneficios, $destaque]): ?>
        <article class="plano<?= $destaque ? ' destaque' : '' ?>">
            <p class="etiqueta"><?= h($nome) ?></p>
            <div class="preco"><?= h($preco) ?></div>
            <p class="periodo"><?= h($periodo) ?></p>
            <p class="descricao"><?= h($descricao) ?></p>
            <ul>
                <?php foreach ($beneficios as $beneficio): ?>
                    <li><?= h($beneficio) ?></li>
                <?php endforeach; ?>
            </ul>
        </article>
    <?php endforeach; ?>
</div>
<?php require __DIR__ . '/includes/rodape.php'; ?>
