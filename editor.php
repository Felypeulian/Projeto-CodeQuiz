<?php
require_once __DIR__ . '/init.php';
exigir_login();

// Monta um documento HTML completo em volta do corpo do exercício.
function modelo(string $corpo): string
{
    return "<!DOCTYPE html>\n<html lang=\"pt-br\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Exercício</title>\n</head>\n<body>\n"
        . $corpo
        . "</body>\n</html>";
}

// Devolve o texto de todos os elementos encontrados pela consulta XPath.
function textos(DOMXPath $xpath, string $consulta): array
{
    $lista = [];

    foreach ($xpath->query($consulta) as $elemento) {
        $lista[] = trim($elemento->textContent);
    }

    return $lista;
}

// Cada desafio tem título, enunciado, código inicial e testes [nome, função].
$desafios = [
    [
        'titulo' => 'Olá, página',
        'enunciado' => 'Crie um h1 com o texto: Olá, HTML!',
        'inicial' => modelo("  \n"),
        'testes' => [
            ['Existe h1', fn($x) => $x->query('//h1')->length > 0],
            ['Texto do h1', fn($x) => trim($x->evaluate('string(//h1)')) === 'Olá, HTML!'],
        ],
    ],
    [
        'titulo' => 'Parágrafo e link',
        'enunciado' => 'Adicione um p e um a com href https://example.com e texto Visitar site.',
        'inicial' => modelo("  <h1>Navegação</h1>\n  \n"),
        'testes' => [
            ['Existe p', fn($x) => $x->query('//p')->length > 0],
            ['Existe a', fn($x) => $x->query('//a')->length > 0],
            ['href correto', fn($x) => str_contains($x->evaluate('string(//a/@href)'), 'example.com')],
            ['Texto do link', fn($x) => trim($x->evaluate('string(//a)')) === 'Visitar site'],
        ],
    ],
    [
        'titulo' => 'Lista',
        'enunciado' => 'Crie uma ul com 3 li: HTML, CSS e JavaScript.',
        'inicial' => modelo("  <h1>Linguagens</h1>\n  \n"),
        'testes' => [
            ['Existe ul', fn($x) => $x->query('//ul')->length > 0],
            ['3 itens', fn($x) => $x->query('//ul//li')->length === 3],
            ['Itens certos', fn($x) => array_diff(['HTML', 'CSS', 'JavaScript'], textos($x, '//ul//li')) === []],
        ],
    ],
    [
        'titulo' => 'Imagem',
        'enunciado' => 'Inclua img com src="foto.jpg" e alt="Foto de perfil".',
        'inicial' => modelo("  <h1>Perfil</h1>\n  \n"),
        'testes' => [
            ['Existe img', fn($x) => $x->query('//img')->length > 0],
            ['src correto', fn($x) => $x->evaluate('string(//img/@src)') === 'foto.jpg'],
            ['alt correto', fn($x) => $x->evaluate('string(//img/@alt)') === 'Foto de perfil'],
        ],
    ],
    [
        'titulo' => 'Formulário',
        'enunciado' => 'Monte um form com input type="email" e um button.',
        'inicial' => modelo("  <h1>Contato</h1>\n  \n"),
        'testes' => [
            ['Existe form', fn($x) => $x->query('//form')->length > 0],
            ['Input email', fn($x) => $x->query('//input[@type="email"]')->length > 0],
            ['Existe button', fn($x) => $x->query('//button')->length > 0],
        ],
    ],
];

// Desafio escolhido na URL (editor.php?desafio=2).
$atual = (int) ($_GET['desafio'] ?? 0);

if ($atual < 0 || $atual >= count($desafios)) {
    $atual = 0;
}

$desafio = $desafios[$atual];
$feitos = $_SESSION['editor']['feitos'] ?? [];
$codigo = $_SESSION['editor']['codigo'][$atual] ?? $desafio['inicial'];
$resultados = null;
$concluido = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (campo('acao') === 'recomecar') {
        unset($_SESSION['editor']['codigo'][$atual]);
        redirecionar('editor.php?desafio=' . $atual);
    }

    // Guarda o código na sessão e roda os testes do desafio no servidor.
    $codigo = mb_substr(campo('codigo', false), 0, 20000);
    $_SESSION['editor']['codigo'][$atual] = $codigo;

    libxml_use_internal_errors(true);
    $documento = new DOMDocument();
    $documento->loadHTML('<?xml encoding="UTF-8">' . $codigo);
    $xpath = new DOMXPath($documento);

    $resultados = [];

    foreach ($desafio['testes'] as [$nome, $teste]) {
        $resultados[$nome] = (bool) $teste($xpath);
    }

    $concluido = !in_array(false, $resultados, true);

    if ($concluido && !in_array($atual, $feitos, true)) {
        $feitos[] = $atual;
        $_SESSION['editor']['feitos'] = $feitos;
    }
}

$titulo = 'Editor de HTML';
$pagina = 'editor';
require __DIR__ . '/includes/cabecalho.php';
?>
<p class="etiqueta">Editor</p>
<h1>Editor de HTML</h1>
<p class="suave">Escreva o HTML, envie e veja o resultado na pré-visualização.</p>

<nav class="desafios">
    <?php foreach ($desafios as $i => $item): ?>
        <a href="editor.php?desafio=<?= $i ?>"<?= $i === $atual ? ' class="ativo"' : '' ?>>
            <?= in_array($i, $feitos, true) ? '✓ ' : '' ?><?= h($item['titulo']) ?>
        </a>
    <?php endforeach; ?>
</nav>

<progress value="<?= count($feitos) ?>" max="<?= count($desafios) ?>"></progress>
<small class="suave"><?= count($feitos) ?> de <?= count($desafios) ?> desafios concluídos</small>

<h2 class="espaco"><?= h($desafio['titulo']) ?></h2>
<p><?= h($desafio['enunciado']) ?></p>

<div class="editor">
    <form method="post" action="editor.php?desafio=<?= $atual ?>">
        <label for="codigo">Seu HTML</label>
        <textarea id="codigo" name="codigo" spellcheck="false"><?= h($codigo) ?></textarea>

        <div class="acoes">
            <button type="submit" name="acao" value="atualizar">Atualizar prévia</button>
            <button type="submit" name="acao" value="recomecar" class="botao-contorno">Recomeçar</button>
        </div>

        <?php if ($resultados !== null): ?>
            <ul class="testes">
                <?php foreach ($resultados as $nome => $passou): ?>
                    <li class="<?= $passou ? 'ok' : 'falhou' ?>"><?= $passou ? '✓' : '✗' ?> <?= h($nome) ?></li>
                <?php endforeach; ?>
                <?php if ($concluido): ?>
                    <li class="ok">Desafio concluído.</li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </form>

    <div>
        <label>Pré-visualização</label>
        <iframe title="Pré-visualização do HTML" sandbox="" srcdoc="<?= h($codigo) ?>"></iframe>
    </div>
</div>
<?php require __DIR__ . '/includes/rodape.php'; ?>
