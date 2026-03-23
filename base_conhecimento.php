<?php
// Importa as funções de leitura dos artigos
include_once('../crud/artigos.php');

// Lê todos os artigos do JSON
$artigos = lerArtigos();

// Captura o termo de busca (caso o usuário tenha pesquisado)
$termoBusca = isset($_GET['busca']) ? strtolower(trim($_GET['busca'])) : '';

// Filtra os artigos se houver busca
if ($termoBusca !== '') {
    $artigos = array_filter($artigos, function ($artigo) use ($termoBusca) {
        return str_contains(strtolower($artigo['titulo']), $termoBusca) ||
               str_contains(strtolower($artigo['categoria']), $termoBusca);
    });
}
?>

<!DOCTYPE html> 
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Base de Conhecimento - Ice Bank </title>
    <link rel="stylesheet" href="../assets/style_duvidas.css"> <!-- Importa o estilo -->
</head>

<body>

    <header>
        <div class="logo">
            <img src="../assets/img/logo_banco.png" alt="Logo Banco" height="100">
            <h2>Ice Bank</h2>
        </div>
        <nav>
            <a href="index.php">Início</a>
            <a href="base_conhecimento.php" class="ativo">Base de Conhecimento</a>
            <a href="faq.php">FAQ</a>
            <a href="ticket.php">Atendimento</a>
            <a href="login.php">Area do Colaborador</a>
        </nav>
    </header>

    <main class="conteudo-base">
        <h1>Duvidas Frequentes</h1>
        <p>Encontre respostas e tutoriais sobre os serviços do Ice Bank.</p>

        <!-- Campo de pesquisa -->
        <form method="GET" action="" class="form-busca">
            <input type="text" name="busca" placeholder="Digite uma palavra-chave..."
                value="<?= htmlspecialchars($termoBusca) ?>">
            <button type="submit">Buscar</button>
        </form>

        <!-- Lista de artigos -->
        <div class="lista-artigos">
            <?php if (count($artigos) > 0): ?>
            <?php foreach ($artigos as $artigo): ?>
            <div class="artigo">
                <h2><?= htmlspecialchars($artigo['titulo']) ?></h2>
                <p class="categoria">Categoria: <?= htmlspecialchars($artigo['categoria']) ?></p>
                <p><?= htmlspecialchars($artigo['conteudo']) ?></p>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="sem-resultado">Nenhum artigo encontrado para sua busca.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        &copy; 2025 Ice Bank - Todos os direitos reservados.
    </footer>

</body>

</html>