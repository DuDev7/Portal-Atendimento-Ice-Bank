<?php
date_default_timezone_set('America/Sao_Paulo'); // ✅ Define o fuso horário de Brasília
// Caminho do arquivo CSV
$arquivoCSV = __DIR__ . '/../includes/tickets.csv'; // caminho do arquivo CSV

// Função para salvar um novo ticket no CSV
function salvarTicket($nome, $email, $assunto, $mensagem) {
    global $arquivoCSV; // usa o caminho definido acima

    // Cria o arquivo se não existir e adiciona cabeçalho
    if (!file_exists($arquivoCSV)) {
        $cabecalho = "id,nome,email,assunto,mensagem,status,data\n";
        file_put_contents($arquivoCSV, $cabecalho);
    }

    // Lê todos os tickets para calcular o próximo ID
    $linhas = file($arquivoCSV);
    $id = count($linhas); // número da linha como ID simples

    // Monta a nova linha com os dados do ticket
    $novaLinha = "$id,$nome,$email,$assunto,\"$mensagem\",Aberto," . date("d/m/Y H:i:s") . "\n";

    // Adiciona a linha ao arquivo
    file_put_contents($arquivoCSV, $novaLinha, FILE_APPEND);
}

// Função para ler todos os tickets do CSV
function lerTickets() {
    global $arquivoCSV;
    if (!file_exists($arquivoCSV)) return [];

    $linhas = array_map('str_getcsv', file($arquivoCSV));
    $cabecalho = array_shift($linhas); // remove o cabeçalho

    $tickets = [];
    foreach ($linhas as $linha) {
        $tickets[] = array_combine($cabecalho, $linha);
    }

    return $tickets;
}
?>
