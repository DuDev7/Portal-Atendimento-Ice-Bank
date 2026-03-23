<?php
include_once('../crud/ticket.php'); // importa as funções do CSV

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $assunto = $_POST['assunto'];

    $mensagem = $_POST['mensagem'];

    salvarTicket($nome, $email, $assunto, $mensagem); // chama a função

    $msg = "✅ Seu chamado foi enviado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Abrir Ticket - Ice Bank</title>
    <link rel="stylesheet" href="../assets/style_ticket.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <main class="container">
        <h2>Abertura de Chamado (Ticket)</h2>
        <p>Descreva seu problema abaixo. Nossa equipe retornará em breve.</p>

        <?php if (isset($msg)): ?>
            <div class="alerta-sucesso"><?= $msg ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="form-ticket">
            <label>Nome Completo:</label>
            <input type="text" name="nome" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Assunto:</label>
            <input type="text" name="assunto" id="campo-assunto" required>
            <div id="sugestoes" class="caixa-sugestoes"></div>
            
            <label>Descrição do Problema:</label>
            <textarea name="mensagem" rows="5" required></textarea>

            <button type="submit" class="btn-enviar">Enviar Chamado</button>
        </form>
    </main>

    <?php include('../includes/footer.php'); ?>

    <script>
// Função para buscar sugestões conforme o usuário digita
document.getElementById('campo-assunto').addEventListener('keyup', function() {
    const termo = this.value.trim(); // pega o texto digitado
    const sugestoesDiv = document.getElementById('sugestoes');

    // Se o campo estiver vazio, limpa as sugestões
    if (termo.length < 2) {
        sugestoesDiv.innerHTML = '';
        return;
    }

    // Faz requisição AJAX para o PHP
    fetch(`../crud/sugestao.php?q=${encodeURIComponent(termo)}`)
        .then(res => res.json())
        .then(dados => {
            if (dados.length === 0) {
                sugestoesDiv.innerHTML = '<p class="nenhum-artigo">Nenhum artigo relacionado encontrado.</p>';
                return;
            }

            // Monta os resultados
            let html = '<p class="titulo-sugestoes">Talvez estes artigos te ajudem:</p>';
            dados.forEach(a => {
                html += `
                    <div class="artigo-sugestao">
                        <strong>${a.titulo}</strong><br>
                        <small>${a.conteudo}</small>
                    </div>
                `;
            });
            sugestoesDiv.innerHTML = html;
        })
        .catch(err => console.error('Erro ao buscar artigos:', err));
});
</script>
</body>
</html>
