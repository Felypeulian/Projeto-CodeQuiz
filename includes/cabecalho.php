<?php

// Cabeçalho comum. Variáveis: $titulo (obrigatória), $pagina e $publico (opcionais).
// O <main> aberto aqui é fechado em includes/rodape.php.

$pagina = $pagina ?? '';
$publico = $publico ?? false;

$menu = [
    'esquerda' => [
        'cursos' => ['cursos.php', 'Módulos'],
        'documentacao' => ['documentacao.php', 'Documentação'],
        'sobre' => ['sobre.php', 'Sobre'],
    ],
    'direita' => [
        'quiz' => ['quiz.php', 'Quiz'],
        'editor' => ['editor.php', 'Editor'],
        'assinaturas' => ['assinaturas.php', 'Preços'],
        'usuario' => ['usuario.php', 'Meu painel'],
    ],
];

if (!empty($_SESSION['usuario']['admin'])) {
    $menu['direita']['admin'] = ['admin.php', 'Admin'];
}

$menu['direita']['sair'] = ['logout.php', 'Sair'];

// Páginas públicas (login e cadastro) mostram apenas a marca.
if ($publico) {
    $menu = ['esquerda' => [], 'direita' => []];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= h($titulo) ?> | CodeQuiz</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header class="topo">
        <nav>
            <?php foreach ($menu['esquerda'] as $id_menu => [$link_menu, $rotulo_menu]): ?>
                <a href="<?= $link_menu ?>"<?= $id_menu === $pagina ? ' class="ativo"' : '' ?>><?= $rotulo_menu ?></a>
            <?php endforeach; ?>
        </nav>

        <a class="marca" href="index.php">
            <img src="img/logo-nav.png" alt="">
            <span>CodeQuiz</span>
        </a>

        <nav class="direita">
            <?php foreach ($menu['direita'] as $id_menu => [$link_menu, $rotulo_menu]): ?>
                <a href="<?= $link_menu ?>"<?= $id_menu === $pagina ? ' class="ativo"' : '' ?>><?= $rotulo_menu ?></a>
            <?php endforeach; ?>
        </nav>
    </header>

    <main>
