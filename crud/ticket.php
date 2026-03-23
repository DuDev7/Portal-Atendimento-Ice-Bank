<?php // arquivo: crud/tickets.php  // comentário: arquivo que contém todas as funções de leitura/escrita/atualização de tickets em CSV
date_default_timezone_set('America/Sao_Paulo'); // ✅ Define o fuso horário de Brasília

$arquivoCSV = __DIR__ . '/../includes/tickets.csv'; // define o caminho absoluto do arquivo CSV usado para armazenar tickets

// Função: garante que o arquivo CSV exista e tenha o cabeçalho correto
function inicializarCSV() { 
    global $arquivoCSV;
    if (!file_exists($arquivoCSV)) {
        $fp = fopen($arquivoCSV, 'w');
        // Novo cabeçalho de 9 colunas, consistente com tickets respondidos (data_resposta)
        fputcsv($fp, ['id','nome','email','assunto','mensagem','status','resposta_admin','data','data_resposta']); 
        fclose($fp);
    }
}

// Função: lê todos os tickets do CSV de forma segura e retorna array associativo
function lerTickets() { // comentario: retorna um array de tickets lidos do CSV
    global $arquivoCSV; // comentario: usa a variável global de caminho
    inicializarCSV(); // comentario: garante que o CSV exista antes de ler
    $linhas = array_map('str_getcsv', file($arquivoCSV)); // comentario: lê todas as linhas e converte CSV para arrays
    $cabecalho = array_shift($linhas); // comentario: retira a primeira linha como cabeçalho

    $tickets = []; // comentario: array que armazenará tickets válidos
    foreach ($linhas as $linha) { // comentario: percorre cada linha do CSV
        // normaliza o tamanho da linha para combinar com o cabeçalho (preenche campos faltantes com string vazia)
        if (count($linha) < count($cabecalho)) { // comentario: se a linha tiver menos colunas que o cabeçalho
            $linha = array_pad($linha, count($cabecalho), ''); // comentario: completa com valores vazios
        } elseif (count($linha) > count($cabecalho)) { // comentario: se houver mais colunas que o cabeçalho
            $linha = array_slice($linha, 0, count($cabecalho)); // comentario: corta colunas extras
        }
        $tickets[] = array_combine($cabecalho, $linha); // comentario: combina cabeçalho com valores, criando array associativo
    }
    return $tickets; // comentario: retorna o array de tickets
}

// Função utilitária: grava todo o array de tickets de volta ao CSV (substitui arquivo)
function salvarTodosTickets(array $tickets) { // comentario: regrava o CSV com os dados em $tickets
    global $arquivoCSV; // comentario: usa a variável global de caminho
    if (empty($tickets)) { // comentario: caso não existam tickets, ainda queremos manter o cabeçalho
        inicializarCSV(); // comentario: cria o CSV com cabeçalho se necessário
        return; // comentario: encerra a função
    }
    $fp = fopen($arquivoCSV, 'w'); // comentario: abre o arquivo para escrita (sobrescreve)
    fputcsv($fp, array_keys($tickets[0])); // comentario: escreve o cabeçalho com as chaves do primeiro ticket
    foreach ($tickets as $t) { // comentario: percorre todos os tickets
        // garante que a ordem dos campos seja a mesma do cabeçalho (evita desalinhamento)
        $linha = []; // comentario: prepara array de valores
        foreach (array_keys($tickets[0]) as $k) { // comentario: para cada chave do cabeçalho
            $linha[] = isset($t[$k]) ? $t[$k] : ''; // comentario: usa valor se existir, senão string vazia
        }
        fputcsv($fp, $linha); // comentario: escreve a linha no CSV
    }
    fclose($fp); // comentario: fecha o arquivo
}

// Função: salvar novo ticket (CREATE)
function salvarTicket($nome, $email, $assunto, $mensagem, $origem = 'portal') { // comentario: adiciona um novo ticket ao CSV
    $tickets = lerTickets(); // comentario: carrega tickets existentes
    // gera novo ID: usa último id numérico +1 para manter consistência (se vazio inicia em 1)
    $ultimoId = 0; // comentario: inicializa ultimoId
    foreach ($tickets as $t) { // comentario: percorre tickets para achar maior id
        $idNum = intval($t['id']); // comentario: converte o id para inteiro
        if ($idNum > $ultimoId) $ultimoId = $idNum; // comentario: atualiza ultimoId
    }
    $novoId = $ultimoId + 1; // comentario: novo id é ultimo + 1
    $novo = [ // NOVO ARRAY $novo COM 9 COLUNAS
        'id' => (string)$novoId,
        'nome' => $nome,
        'email' => $email,
        'assunto' => $assunto,
        'mensagem' => $mensagem,
        'status' => 'Aberto',
        'resposta_admin' => '',
        'data' => date('d-m-y H:i:s'),
        'data_resposta' => '', // <--- NOVO: Inicializado vazio para manter a consistência de colunas (9)
        // Campo 'origem' foi removido para manter o alinhamento com 9 colunas.
    ];
    $tickets[] = $novo; 
    salvarTodosTickets($tickets); 
}

// Função: atualizar status de um ticket (ex: Aberto -> Resolvido)
function atualizarStatus($id, $novoStatus) { // comentario: altera somente o campo status do ticket identificado por id
    $tickets = lerTickets(); // comentario: carrega tickets
    foreach ($tickets as &$t) { // comentario: busca o ticket desejado por referência
        if ($t['id'] == $id) { // comentario: compara IDs (string/int indiferente)
            $t['status'] = $novoStatus; // comentario: atualiza status do ticket
            break; // comentario: interrompe o loop após encontrar
        }
    }
    salvarTodosTickets($tickets); // comentario: regrava o CSV com alteração
}

// Função: responder um ticket (adiciona resposta do admin, mantém o ticket no CSV e marca como Resolvido)
function responderTicket($id, $respostaAdmin) { // comentario: salva a resposta do admin no ticket e o marca como Resolvido
    $tickets = lerTickets(); // comentario: lê todos os tickets
    foreach ($tickets as &$t) { // comentario: percorre por referência para modificar
        if ($t['id'] == $id) { // comentario: se encontrar o ticket com o id desejado
            $t['resposta_admin'] = $respostaAdmin; // comentario: guarda a resposta do admin
            $t['status'] = 'Resolvido'; // comentario: define status como Resolvido
            $t['data_resposta'] = date('d/m/Y H:i:s'); // comentario: registra data/hora da resposta
            break; // comentario: sai do loop
        }
    }
    salvarTodosTickets($tickets); // comentario: salva tudo de volta no CSV
}

// Função: contar tickets por status (útil para o dashboard)
function contarTicketsPorStatus() { // comentario: retorna um array associativo com contagem por status
    $tickets = lerTickets(); // comentario: carrega tickets
    $contagem = ['Abertos' => 0, 'Resolvidos' => 0]; // comentario: inicializa contadores
    foreach ($tickets as $t) { // comentario: percorre todos os tickets
        $status = strtolower(trim($t['status'])); // comentario: normaliza texto do status
        if ($status === 'resolvido') { // comentario: se status for 'resolvido'
            $contagem['Resolvidos']++; // comentario: incrementa resolvidos
        } else { // comentario: qualquer outro status considera como aberto
            $contagem['Abertos']++; // comentario: incrementa abertos
        }
    }
    return $contagem; // comentario: retorna contagens
}
