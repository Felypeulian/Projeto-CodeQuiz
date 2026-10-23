<?php

// Usuários permitidos. Projeto acadêmico: senhas em texto puro.
// NÃO use este método em produção nem com senhas reais.
// Novos cadastros feitos em cadastro.php são acrescentados a este arquivo.
return [
    [
        'usuario' => 'admin',
        'nome' => 'Administrador',
        'email' => 'admin@admin.com',
        'senha' => 'admin123',
        'admin' => true,
    ],
    [
        'usuario' => 'aluno',
        'nome' => 'Aluno Teste',
        'email' => 'aluno@codequiz.com',
        'senha' => 'aluno123',
        'admin' => false,
    ],
];
