<?php
require_once __DIR__ . '/init.php';
exigir_login();

// Conteúdo de cada linguagem: [nome, resumo, exemplo de código, conceitos].
$docs = [
 'html' => ['HTML','Estrutura e significado do conteúdo de uma página web.','<!DOCTYPE html>\n<html lang="pt-br">\n<head>\n  <meta charset="UTF-8">\n  <title>Minha página</title>\n</head>\n<body>\n  <h1>Olá, mundo!</h1>\n  <p>Minha primeira página.</p>\n  <a href="https://example.com">Visitar um site</a>\n</body>\n</html>','HTML não é uma linguagem de programação: é uma linguagem de marcação. Use elementos semânticos como <header>, <main>, <section>, <article> e <footer>. Formulários usam <form>, <label>, <input> e <button>. Imagens precisam de texto alternativo útil no atributo alt.'],
 'css' => ['CSS','Estilização, layout e adaptação da interface a diferentes telas.','/* Selecione elementos e defina suas regras */\n:root {\n  --cor-principal: #ffc933;\n}\n\n.cartao {\n  padding: 1.5rem;\n  border-radius: 12px;\n  display: grid;\n  gap: 1rem;\n}\n\n@media (max-width: 600px) {\n  .grade { grid-template-columns: 1fr; }\n}','Seletores comuns: elemento (p), classe (.cartao), id (#topo) e atributo ([required]). O modelo de caixa inclui conteúdo, padding, borda e margem. Flexbox é ótimo para alinhar em uma dimensão; Grid organiza linhas e colunas. Use unidades relativas e media queries para responsividade.'],
 'javascript' => ['JavaScript','Lógica, manipulação do DOM e comportamento interativo no navegador.','const nome = "Ada";\nconst notas = [8, 9, 10];\n\nfunction calcularMedia(valores) {\n  const soma = valores.reduce((total, n) => total + n, 0);\n  return soma / valores.length;\n}\n\nconsole.log(`Olá, ${nome}!`);\nconsole.log(calcularMedia(notas));','Prefira const por padrão e let quando precisar reatribuir. Tipos frequentes: string, number, boolean, null, undefined, array e object. Use if/else para decisões, for/for...of para repetições e funções para reutilizar lógica. O DOM permite selecionar e alterar elementos com querySelector; eventos como click e submit tornam a página interativa.'],
 'php' => ['PHP','Linguagem executada no servidor para gerar páginas e processar dados.','<?php\n$nome = "Ada";\n$notas = [8, 9, 10];\n$media = array_sum($notas) / count($notas);\n\necho "Olá, " . htmlspecialchars($nome, ENT_QUOTES, "UTF-8");\necho "Média: " . $media;\n?>','Variáveis começam com $. Arrays podem ser indexados ou associativos. Use if/else, foreach e funções para organizar o código. Formulários podem enviar dados por GET ou POST; valide no servidor e escape a saída com htmlspecialchars. Para senhas, use password_hash e password_verify. Para bancos de dados, prefira PDO com consultas preparadas. Sessões são iniciadas com session_start().'],
 'python' => ['Python','Sintaxe legível para automação, aplicações, dados e aprendizado de lógica.','nome = "Ada"\nnotas = [8, 9, 10]\n\ndef media(valores):\n    return sum(valores) / len(valores)\n\nprint(f"Olá, {nome}!")\nprint(media(notas))','Python usa indentação para delimitar blocos. Os tipos básicos incluem int, float, str e bool; coleções comuns são list, tuple, dict e set. Defina funções com def, percorra itens com for e trate exceções com try/except. Ambientes virtuais ajudam a isolar dependências de cada projeto.'],
];

$roteiros = [
 'html' => [
  'Fundamentos: tags, atributos, aninhamento e estrutura do documento.',
  'Semântica: header, nav, main, section, article, aside e footer ajudam navegadores e tecnologias assistivas a entender a página.',
  'Formulários: associe label e input, escolha tipos adequados e use required/min/max quando fizer sentido. A validação no navegador não substitui a validação no servidor.',
  'Acessibilidade: use títulos em ordem lógica, alt descritivo em imagens importantes e links com texto que explique o destino.',
  'Próximo passo: crie uma página de perfil com cabeçalho, conteúdo principal, formulário de contato e rodapé.'
 ],
 'css' => [
  'Cascata e especificidade: quando várias regras se aplicam, a cascata decide qual valor prevalece. Prefira seletores simples e evite !important como solução padrão.',
  'Modelo de caixa: content, padding, border e margin definem o espaço ocupado por um elemento. box-sizing: border-box facilita o controle de dimensões.',
  'Layout: use Flexbox para alinhamento em uma dimensão e CSS Grid para grades em linhas e colunas.',
  'Responsividade: comece por telas pequenas, use unidades flexíveis, imagens fluidas e media queries para adaptar o layout.',
  'Próximo passo: estilize cartões de curso, estados hover/focus e uma grade que vire uma coluna em celulares.'
 ],
 'javascript' => [
  'Dados e escopo: use const como padrão e let quando precisar reatribuir. Strings, números, booleanos, arrays e objetos resolvem muitos casos comuns.',
  'Controle de fluxo: if/else decide caminhos; for, for...of e métodos como map/filter ajudam a percorrer coleções.',
  'DOM e eventos: querySelector seleciona elementos; addEventListener registra eventos sem misturar comportamento com HTML.',
  'Assincronicidade: Promises e async/await ajudam a lidar com operações que levam tempo, como chamadas fetch a uma API.',
  'Próximo passo: valide um formulário, mostre mensagens de erro e atualize um contador ao clicar em um botão.'
 ],
 'php' => [
  'Execução no servidor: o PHP roda no servidor e envia o resultado ao navegador; o código PHP não deve ser confundido com o HTML gerado.',
  'Estruturas: variáveis usam $, arrays podem ser indexados ou associativos, e funções permitem reaproveitar lógica.',
  'Formulários e sessões: leia entradas com cuidado, valide os dados no servidor e use sessões para manter estado entre requisições.',
  'Segurança: escape conteúdo HTML com htmlspecialchars, armazene senhas com password_hash/password_verify e use PDO com consultas preparadas.',
  'Próximo passo: faça um formulário de contato com validação, mensagens de retorno e tratamento de entradas inválidas.'
 ],
 'python' => [
  'Indentação: blocos de if, for, while e def são definidos pela indentação, por isso mantenha o padrão consistente.',
  'Coleções: list mantém uma sequência mutável, tuple representa uma sequência imutável, dict associa chaves a valores e set guarda itens únicos.',
  'Funções e módulos: def cria funções; módulos ajudam a separar responsabilidades e reaproveitar código.',
  'Exceções e dependências: use try/except para erros esperados e ambientes virtuais para isolar bibliotecas de cada projeto.',
  'Próximo passo: crie um programa que leia notas, calcule a média e informe se a meta foi atingida.'
 ],
];
$detalhes = [
 'html' => [
  ['Estrutura de uma página', 'Um documento começa com <!DOCTYPE html> e contém o elemento <html>. Dentro de <head> ficam metadados, título e links de recursos; dentro de <body> fica o conteúdo visível. Defina lang="pt-br" e a codificação UTF-8 para melhorar a interpretação do conteúdo.'],
  ['Elementos semânticos', '<header> representa uma área introdutória, <nav> reúne navegação, <main> identifica o conteúdo principal, <section> agrupa um tema, <article> representa conteúdo independente e <footer> reúne informações finais. Escolha elementos pelo significado, não apenas pela aparência.'],
  ['Links, imagens e listas', 'Use <a href="..."> para navegar, <img src="..." alt="..."> para imagens e <ul>/<ol> com <li> para listas. O texto do link deve indicar o destino. Se uma imagem for apenas decorativa, o alt vazio evita leitura desnecessária por leitores de tela.'],
  ['Formulários acessíveis', 'Relacione cada <label> ao campo usando for e id. Escolha tipos apropriados, como email e password, e apresente instruções claras. O atributo required ajuda no navegador, mas dados enviados ainda precisam ser validados no servidor.'],
  ['Erros comuns', 'Evite elementos sem fechamento quando o elemento exige fechamento, ids repetidos, títulos escolhidos apenas pelo tamanho e páginas sem um título descritivo. Verifique a hierarquia de títulos e teste a navegação com teclado.']
 ],
 'css' => [
  ['Como funciona a cascata', 'O navegador combina origem, importância, especificidade e ordem das regras para decidir o estilo final. Uma classe costuma ser mais específica que um seletor de elemento. Prefira regras claras e reutilizáveis a uma disputa de seletores muito específicos.'],
  ['Cores, tipografia e espaçamento', 'Defina cores e espaçamentos em variáveis CSS para manter consistência. Garanta contraste entre texto e fundo, use uma escala tipográfica previsível e mantenha espaço suficiente entre controles interativos. Unidades rem ajudam a respeitar preferências de tamanho de fonte.'],
  ['Flexbox e Grid', 'Flexbox costuma funcionar bem para alinhar itens em uma linha ou coluna. Grid é indicado para layouts bidimensionais, como grades de cartões. As duas ferramentas podem ser combinadas; escolha a que expressa melhor a estrutura desejada.'],
  ['Estados interativos', 'Use :hover para apontar elementos sob o cursor e :focus-visible para destacar o elemento que recebeu foco por teclado. Não remova o contorno de foco sem oferecer uma alternativa visível. Transições curtas podem ajudar, mas não devem dificultar a leitura.'],
  ['Responsividade e depuração', 'Comece com uma coluna e amplie o layout conforme o conteúdo exigir. Use media queries, imagens fluidas e minmax() para grades flexíveis. Nas ferramentas de desenvolvedor do navegador, inspecione estilos computados e teste diferentes larguras de tela.']
 ],
 'javascript' => [
  ['Variáveis e tipos', 'Use const quando a variável não será reatribuída e let quando o valor precisar mudar. JavaScript tem tipos primitivos como string, number, boolean, null, undefined, bigint e symbol, além de objetos e arrays. === evita conversões implícitas comuns em comparações.'],
  ['Funções e coleções', 'Funções agrupam uma tarefa e podem receber parâmetros e retornar resultados. Arrays oferecem métodos como map para transformar, filter para selecionar e find para localizar um item. Prefira nomes que descrevam a intenção e funções pequenas.'],
  ['DOM e eventos', 'document.querySelector seleciona um elemento; textContent altera texto com segurança e classList permite alternar classes. addEventListener registra uma função para eventos como click, input e submit. Em formulários, preventDefault pode impedir o envio tradicional quando a página tratar os dados por JavaScript.'],
  ['Assincronicidade', 'fetch permite solicitar dados a um servidor. Com async/await, o fluxo assíncrono fica mais legível; trate falhas com try/catch e confira response.ok antes de interpretar a resposta. Nem toda operação assíncrona termina imediatamente.'],
  ['Depuração e segurança', 'Use console.log para investigar valores durante o desenvolvimento e as ferramentas do navegador para colocar breakpoints. Evite inserir conteúdo não confiável com innerHTML; prefira textContent ou crie elementos explicitamente. Valide dados também no servidor quando houver backend.']
 ],
 'php' => [
  ['Como o PHP funciona', 'O servidor executa o PHP e envia uma resposta, normalmente HTML, ao navegador. O visitante não recebe o código-fonte PHP executado. Arquivos podem combinar HTML e PHP, mas separar responsabilidades em funções e arquivos costuma facilitar a manutenção.'],
  ['Variáveis, arrays e funções', 'Nomes de variáveis começam com $. Arrays indexados guardam sequências; arrays associativos relacionam chaves e valores. Funções recebem argumentos e podem retornar resultados. Use nomes consistentes e evite repetir a mesma lógica em várias páginas.'],
  ['Requisições e validação', '$_GET e $_POST contêm dados enviados pela requisição. Trate toda entrada como não confiável: confira presença, formato, tamanho e regras de negócio. A validação no navegador melhora a experiência, mas não substitui a validação no servidor.'],
  ['Sessões e autenticação', 'session_start() inicia ou retoma uma sessão. Após autenticação, armazene somente os dados necessários e configure a sessão com cuidado. Para senhas, use password_hash() e password_verify(); nunca guarde senhas em texto puro.'],
  ['Banco de dados e saída segura', 'Use PDO e consultas preparadas para separar SQL dos valores recebidos. Ao inserir texto em HTML, use htmlspecialchars() com UTF-8. Trate erros sem exibir detalhes internos ao usuário e mantenha credenciais fora de arquivos públicos quando possível.']
 ],
 'python' => [
  ['Sintaxe e tipos', 'A indentação define os blocos de código. int representa inteiros, float números de ponto flutuante, str textos e bool valores lógicos. Converta entradas explicitamente quando necessário e lembre que input() retorna texto.'],
  ['Coleções e iteração', 'Listas podem mudar, tuplas são sequências imutáveis, dicionários associam chaves a valores e conjuntos mantêm itens únicos. Use for para percorrer coleções e compreensões quando deixarem a transformação mais clara, sem sacrificar a legibilidade.'],
  ['Funções e módulos', 'def declara uma função. Parâmetros e valores de retorno ajudam a separar responsabilidades. Módulos permitem dividir um projeto em arquivos; o bloco if __name__ == "__main__": é útil para código que deve executar apenas quando o arquivo for iniciado diretamente.'],
  ['Erros e arquivos', 'Use try/except para lidar com erros que você consegue tratar, sem esconder falhas inesperadas. Para abrir arquivos, prefira with open(...) para que sejam fechados corretamente. Informe mensagens úteis quando uma entrada não puder ser processada.'],
  ['Ambientes e testes', 'Um ambiente virtual isola bibliotecas de um projeto. Registre dependências para facilitar a reprodução do ambiente e escreva testes para comportamentos importantes. Teste casos normais, limites e entradas inválidas.']
 ],
];
$exercicios = [
 'html' => ['Crie um artigo com título, subtítulos, parágrafos e uma lista de três itens.', 'Adicione uma imagem com texto alternativo e um link com destino descritivo.', 'Monte um formulário com nome, e-mail, assunto e botão de envio; associe labels aos campos.'],
 'css' => ['Crie três cartões com o mesmo espaçamento usando uma classe reutilizável.', 'Transforme os cartões em uma grade e faça a grade virar uma coluna em telas estreitas.', 'Adicione estados :hover e :focus-visible sem perder contraste ou visibilidade do foco.'],
 'javascript' => ['Escreva uma função que receba números e retorne a média.', 'Adicione um botão que atualize um contador na página usando addEventListener.', 'Valide um campo de formulário e apresente uma mensagem clara quando estiver vazio.'],
 'php' => ['Crie uma função que receba uma lista de notas e retorne a média.', 'Valide no servidor um nome e um e-mail recebidos por POST.', 'Mostre um texto enviado pelo usuário escapando a saída com htmlspecialchars().'],
 'python' => ['Crie uma função que calcule a média de uma lista de números.', 'Leia valores do usuário e trate uma entrada que não possa ser convertida em número.', 'Monte um dicionário com nomes e notas e mostre apenas quem atingiu a média desejada.']
];

$linksOficiais = [
    'html' => [
        ['WHATWG HTML Living Standard', 'https://html.spec.whatwg.org/'],
        ['Guia MDN', 'https://developer.mozilla.org/pt-BR/docs/Web/HTML'],
    ],
    'css' => [
        ['W3C CSS', 'https://www.w3.org/Style/CSS/'],
        ['Guia MDN', 'https://developer.mozilla.org/pt-BR/docs/Web/CSS'],
    ],
    'javascript' => [
        ['MDN JavaScript', 'https://developer.mozilla.org/pt-BR/docs/Web/JavaScript'],
    ],
    'php' => [
        ['Manual oficial do PHP', 'https://www.php.net/manual/pt_BR/'],
    ],
    'python' => [
        ['Documentação oficial do Python', 'https://docs.python.org/pt-br/3/'],
    ],
];

// Sugestão de mini projeto para cada linguagem.
$projetos = [
    'html' => 'Monte uma página de apresentação com título, navegação, uma seção sobre você, uma lista de interesses e um formulário acessível.',
    'css' => 'Crie uma página responsiva com cabeçalho, grade de cartões, botões com estados de foco e uma versão para celular.',
    'javascript' => 'Faça uma lista de tarefas que permita adicionar itens, marcar como concluídos e atualizar a contagem de tarefas abertas.',
    'php' => 'Construa um formulário que valide nome e e-mail no servidor e mostre uma confirmação escapando corretamente os dados exibidos.',
    'python' => 'Crie um pequeno gerenciador de notas que calcule média, classifique o resultado e trate entradas inválidas.',
];


// Linguagem escolhida na URL (documentacao.php?linguagem=php).
$chave = $_GET['linguagem'] ?? '';
$chave = is_string($chave) ? strtolower($chave) : '';

if (!isset($docs[$chave])) {
    $chave = 'html';
}

[$nome, $resumo, $codigo, $explicacao] = $docs[$chave];

$titulo = 'Documentação de ' . $nome;
$pagina = 'documentacao';
require __DIR__ . '/includes/cabecalho.php';
?>
<p class="etiqueta">Central de aprendizagem</p>
<h1>Documentação</h1>
<p class="suave">Conceitos essenciais, exemplos e boas práticas para consultar enquanto você estuda.</p>

<div class="docs">
    <nav class="docs-menu">
        <?php foreach ($docs as $id => $item): ?>
            <a href="documentacao.php?linguagem=<?= h($id) ?>"<?= $id === $chave ? ' class="ativo"' : '' ?>><?= h($item[0]) ?></a>
        <?php endforeach; ?>
    </nav>

    <article>
        <h2><?= h($nome) ?></h2>
        <p class="suave"><?= h($resumo) ?></p>

        <section>
            <h3>Exemplo prático</h3>
            <pre><code><?= h(str_replace('\n', "\n", $codigo)) ?></code></pre>
        </section>

        <section>
            <h3>Conceitos e boas práticas</h3>
            <p><?= h($explicacao) ?></p>
        </section>

        <section>
            <h3>Guia de estudo</h3>
            <ul>
                <?php foreach ($roteiros[$chave] as $topico): ?>
                    <li><?= h($topico) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section>
            <h3>Conteúdo aprofundado</h3>
            <?php foreach ($detalhes[$chave] as $i => [$assunto, $texto]): ?>
                <div class="topico">
                    <span><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <div>
                        <h4><?= h($assunto) ?></h4>
                        <p><?= h($texto) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <section>
            <h3>Pratique</h3>
            <p><?= h($projetos[$chave]) ?></p>
            <ol>
                <?php foreach ($exercicios[$chave] as $exercicio): ?>
                    <li><?= h($exercicio) ?></li>
                <?php endforeach; ?>
            </ol>
        </section>

        <section>
            <h3>Checklist antes de concluir</h3>
            <ul>
                <li>O código está organizado e os nomes são fáceis de entender?</li>
                <li>Você testou pelo menos um caso comum e um caso de erro?</li>
                <li>O resultado continua correto quando os dados mudam?</li>
                <li>Você consultou a referência oficial quando teve dúvida sobre sintaxe?</li>
                <li>Se houver entrada de usuário, ela foi validada e tratada com segurança?</li>
            </ul>
        </section>

        <section>
            <h3>Referências oficiais</h3>
            <div class="links">
                <?php foreach ($linksOficiais[$chave] as [$texto, $url]): ?>
                    <a class="botao botao-contorno" href="<?= h($url) ?>" target="_blank" rel="noopener noreferrer"><?= h($texto) ?> ↗</a>
                <?php endforeach; ?>
                <a class="botao" href="quiz.php">Praticar no quiz</a>
            </div>
        </section>
    </article>
</div>
<?php require __DIR__ . '/includes/rodape.php'; ?>
