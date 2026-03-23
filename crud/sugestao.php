<?php
// Lê o arquivo de base de conhecimento
$caminho = __DIR__ . '/../includes/dbfake.json';
$dados = json_decode(file_get_contents($caminho), true);

// Pega o termo digitado via GET
$termo = strtolower($_GET['q'] ?? '');
$resultados = [];

// Procura por artigos que contenham o termo no título
if ($termo && isset($dados['artigos'])) {
    foreach ($dados['artigos'] as $artigo) {
        if (strpos(strtolower($artigo['titulo']), $termo) !== false) {
            $resultados[] = [
                'titulo' => $artigo['titulo'],
                'conteudo' => $artigo['conteudo'],
                'categoria' => $artigo['categoria']
            ];
        }
    }
}

// Retorna os resultados em formato JSON
header('Content-Type: application/json');
echo json_encode($resultados);
?>
