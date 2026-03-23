<?php
include_once('../crud/ticket.php');

// Captura o ID do ticket
$id = $_GET['id'] ?? null;
$tickets = lerTickets();
$ticket = null;

foreach ($tickets as $t) {
    if ($t['id'] == $id) {
        $ticket = $t;
        break;
    }
}

if (!$ticket) {
    die("Ticket não encontrado.");
}

// Se o admin enviou uma resposta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resposta = $_POST['resposta'];
    responderTicket($id, $resposta);
    echo "<script>alert('Resposta enviada e ticket finalizado!'); window.location.href='painel.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Ticket</title>
    <link rel="stylesheet" href="../assets/style_ticket.css">
</head>
<body>
<?php include('../includes/header.php'); ?>

<main style="width:80%; margin:auto; padding:30px;">
    <h2>Ticket #<?= $ticket['id'] ?> - <?= htmlspecialchars($ticket['assunto']) ?></h2>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($ticket['nome']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($ticket['email']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($ticket['status']) ?></p>
    <p><strong>Data de Abertura:</strong> <?= htmlspecialchars($ticket['data']) ?></p> <!-- ✅ Exibe o horário do chamado -->

    <hr>
    <p><strong>Mensagem:</strong><br><?= nl2br(htmlspecialchars($ticket['mensagem'])) ?></p>

    <?php if (!empty($ticket['resposta_admin'])): ?>
        <div style="background:#e8f7e4; padding:15px; margin-top:20px; border-radius:8px;">
            <strong>Resposta do Administrador:</strong><br>
            <?= nl2br(htmlspecialchars($ticket['resposta_admin'])) ?>
            <br>
            <br><p><strong>Respondido em:</strong> <?= htmlspecialchars($ticket['data_resposta'] ?? 'Ainda sem resposta') ?></p> <!-- ✅ Exibe data/hora da resposta -->

        </div>
    <?php else: ?>
        <form method="POST" style="margin-top:30px;">
            <label for="resposta">Responder:</label><br>
            <textarea name="resposta" rows="6" style="width:100%; padding:10px;"></textarea><br><br>
            <button type="submit" class="btn-ver">Enviar Resposta e Finalizar</button>
        </form>
    <?php endif; ?>
</main>


</body>
</html>
