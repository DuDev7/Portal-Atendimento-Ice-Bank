<?php
// Caminho do arquivo JSON
$arquivo = __DIR__ . '/../includes/dbfake.json'; // localiza o banco simulado

// ====== Função para ler os artigos existentes ======
function lerArtigos() {
    global $arquivo; // acessa variável global do caminho
    $dados = json_decode(file_get_contents($arquivo), true); // lê e converte o JSON em array PHP
    return $dados['artigos'] ?? []; // retorna a lista de artigos ou array vazio
}

// ====== Função para salvar os artigos de volta no JSON ======
function salvarArtigos($artigos) {
    global $arquivo;
    $dados = ['artigos' => $artigos]; // monta estrutura padrão
    file_put_contents($arquivo, json_encode($dados, JSON_PRETTY_PRINT)); // regrava o JSON formatado
}

// ====== Função para adicionar novo artigo ======
function adicionarArtigo($titulo, $conteudo, $categoria) {
    $artigos = lerArtigos(); // carrega os artigos existentes
    $novoId = (count($artigos) > 0) ? end($artigos)['id'] + 1 : 1; // cria novo ID automaticamente
    $novoArtigo = [
        "id" => $novoId,
        "titulo" => $titulo,
        "conteudo" => $conteudo,
        "categoria" => $categoria
    ];
    $artigos[] = $novoArtigo; // adiciona o novo artigo no array
    salvarArtigos($artigos); // salva tudo novamente no JSON
}

// ====== Função para editar um artigo ======
function editarArtigo($id, $titulo, $conteudo, $categoria) {
    $artigos = lerArtigos(); // carrega todos
    foreach ($artigos as &$artigo) { // percorre todos
        if ($artigo['id'] == $id) { // se achar o artigo certo
            $artigo['titulo'] = $titulo;
            $artigo['conteudo'] = $conteudo;
            $artigo['categoria'] = $categoria;
        }
    }
    salvarArtigos($artigos); // regrava o arquivo atualizado
}

// ====== Função para deletar artigo ======
function deletarArtigo($id) {
    $artigos = lerArtigos(); // carrega todos
    $artigos = array_filter($artigos, fn($a) => $a['id'] != $id); // remove o artigo com ID correspondente
    salvarArtigos(array_values($artigos)); // regrava o JSON com índices corrigidos
}

// ====== Função para buscar artigo específico ======
function buscarArtigoPorId($id) {
    $artigos = lerArtigos();
    foreach ($artigos as $artigo) {
        if ($artigo['id'] == $id) {
            return $artigo; // retorna o artigo correspondente
        }
    }
    return null; // caso não encontre
}
?>
