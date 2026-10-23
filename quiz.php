<?php
require_once __DIR__ . '/init.php';
exigir_login();

// Cada pergunta: [enunciado, [opções], índice da opção correta, explicação].
$perguntas = [
    'HTML' => [
        ['Qual tag cria um link clicável?', ['<link>', '<a>', '<href>', '<url>'], 1, 'A tag <a> cria hiperlinks com o atributo href.'],
        ['Qual atributo fornece texto alternativo para uma imagem?', ['title', 'src', 'alt', 'name'], 2, 'O atributo alt descreve a imagem para leitores de tela e quando ela não carrega.'],
        ['Qual elemento representa o conteúdo principal da página?', ['<main>', '<head>', '<meta>', '<style>'], 0, 'A tag <main> identifica o conteúdo principal do documento.'],
        ['Qual tag cria uma lista não ordenada?', ['<ol>', '<li>', '<dl>', '<ul>'], 3, 'A tag <ul> cria uma lista não ordenada; cada item usa <li>.'],
    ],
    'CSS' => [
        ['Qual propriedade altera a cor do texto?', ['font-style', 'color', 'background', 'text-size'], 1, 'A propriedade color define a cor do texto.'],
        ['Qual seletor seleciona um elemento pelo id painel?', ['.painel', '#painel', 'painel', '*painel'], 1, 'O símbolo # seleciona um id em CSS.'],
        ['Qual propriedade cria espaço interno?', ['margin', 'gap', 'padding', 'border'], 2, 'padding cria espaço entre o conteúdo e a borda.'],
        ['Qual sistema ajuda a criar layouts em duas dimensões?', ['Grid', 'Float apenas', 'Text-align', 'Opacity'], 0, 'CSS Grid organiza elementos em linhas e colunas.'],
    ],
    'JavaScript' => [
        ['Qual palavra declara uma variável que pode ser reatribuída?', ['const', 'let', 'static', 'define'], 1, 'let declara uma variável de escopo de bloco que pode receber outro valor.'],
        ['Qual método adiciona um item ao final de um array?', ['push()', 'pop()', 'shift()', 'join()'], 0, 'push() adiciona um ou mais elementos ao final do array.'],
        ['Qual operador compara valor e tipo?', ['=', '==', '!=', '==='], 3, '=== compara sem realizar conversão automática de tipo.'],
        ['Qual comando escreve no console do navegador?', ['print()', 'echo()', 'console.log()', 'writeLine()'], 2, 'console.log() envia informações ao console para depuração.'],
    ],
    'PHP' => [
        ['Qual símbolo inicia uma variável PHP?', ['#', '$', '@', '%'], 1, 'Variáveis PHP começam com o símbolo $.'],
        ['Qual superglobal recebe dados enviados por formulário via POST?', ['$_GET', '$_FORM', '$_POST', '$_SEND'], 2, '$_POST contém dados enviados pelo método HTTP POST.'],
        ['Qual comando imprime texto em PHP?', ['echo', 'console.log', 'document.write', 'printf-js'], 0, 'echo pode enviar texto para a saída HTML.'],
        ['Qual função inicia ou retoma uma sessão?', ['start_session()', 'session_start()', 'begin_session()', 'open_session()'], 1, 'session_start() inicia ou retoma uma sessão PHP.'],
    ],
    'Python' => [
        ['Qual palavra define uma função?', ['func', 'function', 'def', 'lambda'], 2, 'def define uma função nomeada em Python.'],
        ['Qual estrutura percorre os itens de uma sequência?', ['foreach', 'for', 'repeat', 'loop'], 1, 'for itera sobre itens de uma sequência ou iterável.'],
        ['Qual tipo representa uma sequência mutável comum?', ['tuple', 'str', 'list', 'int'], 2, 'list é uma coleção ordenada e mutável.'],
        ['Qual palavra inicia uma condição alternativa?', ['elseif', 'otherwise', 'elif', 'case'], 2, 'elif permite testar outra condição se a anterior for falsa.'],
    ],
];

const PONTOS_POR_ACERTO = 100;


// ---------- Processamento (POST): atualiza a sessão e volta para esta página ----------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = campo('acao');
    $quiz = $_SESSION['quiz'] ?? null;
    $emAndamento = $quiz !== null && !$quiz['fim'];

    if ($acao === 'iniciar') {
        $linguagem = campo('linguagem');

        if (isset($perguntas[$linguagem])) {
            $ordem = array_keys($perguntas[$linguagem]);
            shuffle($ordem);

            $_SESSION['quiz'] = [
                'linguagem' => $linguagem,
                'ordem' => $ordem,
                'atual' => 0,
                'pontos' => 0,
                'acertos' => 0,
                'resposta' => null,
                'fim' => false,
            ];
        }
    } elseif ($acao === 'sair') {
        unset($_SESSION['quiz']);
    } elseif ($emAndamento && $acao === 'responder' && $quiz['resposta'] === null) {
        $pergunta = $perguntas[$quiz['linguagem']][$quiz['ordem'][$quiz['atual']]];
        $escolha = filter_var(campo('resposta'), FILTER_VALIDATE_INT);

        if ($escolha !== false && isset($pergunta[1][$escolha])) {
            $_SESSION['quiz']['resposta'] = $escolha;

            if ($escolha === $pergunta[2]) {
                $_SESSION['quiz']['acertos']++;
                $_SESSION['quiz']['pontos'] += PONTOS_POR_ACERTO;
            }
        }
    } elseif ($emAndamento && $acao === 'proxima' && $quiz['resposta'] !== null) {
        if ($quiz['atual'] < count($quiz['ordem']) - 1) {
            $_SESSION['quiz']['atual']++;
            $_SESSION['quiz']['resposta'] = null;
        } else {
            // Última pergunta respondida: encerra e grava no histórico da sessão.
            $_SESSION['quiz']['fim'] = true;
            $_SESSION['quiz_historico'][] = [
                'linguagem' => $quiz['linguagem'],
                'xp' => $quiz['pontos'],
                'acertos' => $quiz['acertos'],
                'total' => count($quiz['ordem']),
            ];
            $_SESSION['quiz_historico'] = array_slice($_SESSION['quiz_historico'], -100);
        }
    }

    redirecionar('quiz.php');
}


// ---------- Exibição (GET) ----------

$quiz = $_SESSION['quiz'] ?? null;

$titulo = 'Quiz';
$pagina = 'quiz';
require __DIR__ . '/includes/cabecalho.php';
?>
<?php if ($quiz === null): ?>

    <p class="etiqueta">Quiz de programação</p>
    <h1>Escolha uma linguagem</h1>
    <p class="suave">Responda a 4 perguntas e aprenda com o feedback após cada resposta.</p>

    <form method="post" class="quiz-lista">
        <input type="hidden" name="acao" value="iniciar">
        <?php foreach ($perguntas as $linguagem => $itens): ?>
            <button type="submit" name="linguagem" value="<?= h($linguagem) ?>">
                <strong><?= h($linguagem) ?></strong>
                <small><?= count($itens) ?> perguntas · nível iniciante</small>
            </button>
        <?php endforeach; ?>
    </form>

<?php elseif ($quiz['fim']): ?>

    <?php
    $total = count($quiz['ordem']);

    if ($quiz['acertos'] === $total) {
        $mensagem = 'Excelente! Você acertou tudo.';
    } elseif ($quiz['acertos'] >= 2) {
        $mensagem = 'Bom trabalho! Continue praticando.';
    } else {
        $mensagem = 'Não desanime: estudar é evoluir.';
    }
    ?>
    <section class="resultado">
        <p class="etiqueta">Resultado · <?= h($quiz['linguagem']) ?></p>
        <div class="placar"><?= $quiz['acertos'] ?>/<?= $total ?></div>
        <h2><?= h($mensagem) ?></h2>
        <p class="suave">Você ganhou <?= $quiz['pontos'] ?> XP. Use os comentários para revisar os conceitos.</p>

        <div class="acoes">
            <form method="post">
                <input type="hidden" name="acao" value="iniciar">
                <input type="hidden" name="linguagem" value="<?= h($quiz['linguagem']) ?>">
                <button type="submit">Jogar novamente</button>
            </form>
            <form method="post">
                <input type="hidden" name="acao" value="sair">
                <button type="submit" class="botao-contorno">Escolher outra linguagem</button>
            </form>
        </div>
    </section>

<?php else: ?>

    <?php
    [$enunciado, $opcoes, $correta, $explicacao] = $perguntas[$quiz['linguagem']][$quiz['ordem'][$quiz['atual']]];
    $respondida = $quiz['resposta'] !== null;
    $ultima = $quiz['atual'] === count($quiz['ordem']) - 1;
    ?>
    <div class="quiz-topo">
        <form method="post">
            <input type="hidden" name="acao" value="sair">
            <button type="submit" class="botao-contorno">← Linguagens</button>
        </form>
        <span><?= h($quiz['linguagem']) ?> · <?= $quiz['atual'] + 1 ?>/<?= count($quiz['ordem']) ?></span>
        <span><?= $quiz['pontos'] ?> pts</span>
    </div>

    <h2 class="pergunta"><?= h($enunciado) ?></h2>

    <?php if (!$respondida): ?>

        <form method="post" class="opcoes">
            <input type="hidden" name="acao" value="responder">
            <?php foreach ($opcoes as $i => $texto): ?>
                <button type="submit" name="resposta" value="<?= $i ?>" class="opcao"><?= h($texto) ?></button>
            <?php endforeach; ?>
        </form>

    <?php else: ?>

        <div class="opcoes">
            <?php foreach ($opcoes as $i => $texto): ?>
                <?php
                if ($i === $correta) {
                    $classe = ' certa';
                    $marca = '✓ ';
                } elseif ($i === $quiz['resposta']) {
                    $classe = ' errada';
                    $marca = '✗ ';
                } else {
                    $classe = '';
                    $marca = '';
                }
                ?>
                <div class="opcao<?= $classe ?>"><?= $marca . h($texto) ?></div>
            <?php endforeach; ?>
        </div>

        <p class="feedback">
            <?= $quiz['resposta'] === $correta ? 'Muito bem!' : 'Não foi dessa vez.' ?>
            <?= h($explicacao) ?>
        </p>

        <form method="post">
            <input type="hidden" name="acao" value="proxima">
            <button type="submit"><?= $ultima ? 'Ver resultado' : 'Próxima pergunta' ?> →</button>
        </form>

    <?php endif; ?>

<?php endif; ?>
<?php require __DIR__ . '/includes/rodape.php'; ?>
