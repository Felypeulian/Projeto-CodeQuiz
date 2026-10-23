<?php

// Inicialização comum a todas as páginas: sessão e funções de apoio.

session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();


// ---------- Utilitários ----------

// Escapa texto antes de imprimir no HTML.
function h($texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

function redirecionar(string $destino): void
{
    header('Location: ' . $destino);
    exit;
}

// Lê um campo de formulário POST sempre como texto.
function campo(string $nome, bool $limpar = true): string
{
    $valor = $_POST[$nome] ?? '';

    if (!is_string($valor)) {
        return '';
    }

    return $limpar ? trim($valor) : $valor;
}


// ---------- Usuários (array PHP em data/usuarios.php) ----------

function carregar_usuarios(): array
{
    return require __DIR__ . '/data/usuarios.php';
}

function salvar_usuarios(array $usuarios): bool
{
    $arquivo = __DIR__ . '/data/usuarios.php';
    $codigo = "<?php\n\n"
        . "// Usuários permitidos. Projeto acadêmico: senhas em texto puro.\n"
        . "// NÃO use este método em produção nem com senhas reais.\n"
        . 'return ' . var_export($usuarios, true) . ";\n";

    $salvou = file_put_contents($arquivo, $codigo, LOCK_EX) !== false;

    if (function_exists('opcache_invalidate')) {
        opcache_invalidate($arquivo, true);
    }

    return $salvou;
}

// Procura um usuário pelo nome de usuário ou pelo e-mail.
function buscar_usuario(string $login): ?array
{
    $login = strtolower($login);

    foreach (carregar_usuarios() as $usuario) {
        if ($login === strtolower($usuario['usuario']) || $login === strtolower($usuario['email'])) {
            return $usuario;
        }
    }

    return null;
}


// ---------- Sessão autenticada ----------

// Inicia a sessão autenticada (a senha nunca vai para a sessão).
function entrar(array $usuario): void
{
    session_regenerate_id(true);

    $_SESSION['usuario'] = [
        'usuario' => $usuario['usuario'],
        'nome' => $usuario['nome'],
        'email' => $usuario['email'],
        'admin' => $usuario['admin'],
    ];
}

// Protege uma página: sem login, guarda o destino e manda para o login.
function exigir_login(): void
{
    if (!empty($_SESSION['usuario'])) {
        return;
    }

    $consulta = $_SERVER['QUERY_STRING'] ?? '';
    $_SESSION['destino'] = basename($_SERVER['SCRIPT_NAME']) . ($consulta !== '' ? '?' . $consulta : '');

    redirecionar('login.php');
}

function exigir_admin(): void
{
    exigir_login();

    if (empty($_SESSION['usuario']['admin'])) {
        redirecionar('index.php');
    }
}


// ---------- Progresso do quiz (guardado na sessão) ----------

function resumo_progresso(): array
{
    $historico = $_SESSION['quiz_historico'] ?? [];
    $xp = array_sum(array_column($historico, 'xp'));

    return [
        'xp' => $xp,
        'acertos' => array_sum(array_column($historico, 'acertos')),
        'total' => array_sum(array_column($historico, 'total')),
        'nivel' => 1 + intdiv($xp, 250),
        'xp_nivel' => $xp % 250,
    ];
}
