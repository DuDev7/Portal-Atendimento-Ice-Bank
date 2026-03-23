// ===============================================
// Objetivo: Usar as funções robustas de CRUD para exclusão segura.
// ===============================================

<?php

// Inclui o arquivo que tem as funções lerTickets e salvarTodosTickets
include_once('../crud/ticket.php'); 

$caminhoArquivo = __DIR__ . '/../includes/tickets.csv';


// Define o fuso horário correto do Brasil
date_default_timezone_set('America/Sao_Paulo'); 


// Verifica se foi passado o ID via URL (ex: deletar_ticket.php?id=3)
if (isset($_GET['id'])) { 
    $id = $_GET['id']; 

    // Lê todos os tickets usando a função segura.
    $tickets = lerTickets(); 

    // Cria um novo array para armazenar os tickets que NÃO serão excluídos
    $novaLista = []; 

    // Percorre o array associativo (mais seguro que percorrer linhas)
    foreach ($tickets as $t) {
        // Compara o ID do ticket atual com o ID a ser deletado
        if ($t['id'] != $id) { 
            $novaLista[] = $t; // Mantém tickets diferentes do ID a ser deletado
        }
    }
    
    // Regrava o arquivo CSV com os tickets restantes usando a função segura.
    salvarTodosTickets($novaLista); 

   
   // Redireciona de volta ao painel com mensagem de sucesso
    header('Location: ../public/painel.php?deletado=1');
    exit();
} 
else {
    echo "ID do ticket não especificado."; 
}
?>




<?php
// ===========================================
// ARQUIVO: deletar_ticket.php
// FUNÇÃO: Excluir um ticket do arquivo CSV
// ===========================================

$caminhoArquivo = __DIR__ . '/../includes/tickets.csv';
if (!file_exists($caminhoArquivo)) {
    die("❌ Arquivo CSV não encontrado em: " . $caminhoArquivo);
}


// Define o fuso horário correto do Brasil
date_default_timezone_set('America/Sao_Paulo'); // ✅ Garante data/hora corretas


// Verifica se foi passado o ID via URL (ex: deletar_ticket.php?id=3)
if (isset($_GET['id'])) { // ✅ Verifica se o ID foi recebido
    $id = $_GET['id']; // ✅ Captura o ID que veio na URL

    // Lê todas as linhas do CSV (cada linha é um ticket)
    $linhas = file($caminhoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // ✅ Lê e ignora linhas vazias

    if (!$linhas || count($linhas) <= 1) { // ✅ Garante que há conteúdo no arquivo
        die('Nenhum ticket encontrado ou arquivo vazio.');
    }

    // Remove a primeira linha (cabeçalho)
    $cabecalho = array_shift($linhas); // ✅ Guarda o cabeçalho para manter ao regravar o arquivo

    // Cria um novo array para armazenar os tickets que NÃO serão excluídos
    $novaLista = []; // ✅ Lista temporária para regravação

    // Percorre cada linha e mantém apenas as que têm ID diferente do que será deletado
    foreach ($linhas as $linha) {
        $colunas = str_getcsv($linha); // ✅ Converte a linha CSV em array
        if ($colunas[0] != $id) { // ✅ A primeira coluna é o ID do ticket
            $novaLista[] = $linha; // ✅ Mantém tickets diferentes do ID a ser deletado
        }
    }

    // Reabre o arquivo CSV para sobrescrever com os tickets restantes
    $arquivo = fopen($caminhoArquivo, 'w'); // ✅ Abre o arquivo em modo escrita
    fwrite($arquivo, $cabecalho . PHP_EOL); // ✅ Reescreve o cabeçalho original

    // Escreve novamente cada ticket que permaneceu
    foreach ($novaLista as $linha) {
        fwrite($arquivo, $linha . PHP_EOL); // ✅ Regrava linha por linha
    }

    fclose($arquivo); // ✅ Fecha o arquivo para liberar o recurso

   
   // Redireciona de volta ao painel com mensagem de sucesso
    header('Location: ../public/painel.php?deletado=1');
    exit();
} 
else {
    echo "ID do ticket não especificado."; // ✅ Caso o ID não tenha sido passado pela URL
}
?>
