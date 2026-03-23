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
