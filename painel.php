<?php

session_start();
if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit;
}

include_once('../crud/ticket.php');
$tickets = lerTickets();
$contagem = contarTicketsPorStatus();


include_once('../crud/ticket.php'); // Importa as funções de tickets
$tickets = lerTickets(); // Lê todos os tickets do CSV
$contagem = contarTicketsPorStatus(); // Pega os números
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="../assets/style_painel.css">
</head>
<body>
<?php include('../includes/header.php'); ?>
<?php if (isset($_GET['deletado'])): ?>
    <div class="alerta-sucesso">
        ✅ Chamado excluído com sucesso!
    </div>
<?php endif; ?>


<main style="padding: 20px;">
    <a href="logout.php" class="btn-ver" style="float:right; margin-top:10px;">Desconectar</a>
    <h2>Painel de Chamados (Administrador)</h2>

    <div class="contadores">
        <div class="card azul">Abertos: <?= $contagem['Abertos'] ?></div>
        <div class="card verde">Resolvidos: <?= $contagem['Resolvidos'] ?></div>
    </div>

    <table class="tabela-artigos">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Assunto</th>
            <th>Status</th>
            <th>Ações</th>
            <th>Deletar</th>
        </tr>
            <?php foreach ($tickets as $t): ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?= htmlspecialchars($t['nome']) ?></td>
                <td><?= htmlspecialchars($t['assunto']) ?></td>
                <td><?= htmlspecialchars($t['status']) ?></td>
                <td>
                    <a href="ver_ticket.php?id=<?= $t['id'] ?>" class="btn-ver">Ver/Responder</a>
                </td>
                <td><a href="../crud/deletar_ticket.php?id=<?= $t['id'] ?>" 
                        onclick="return confirm('Deseja excluir este chamado?');" 
                        class="btn-excluir">Excluir</a></td>
            </tr>
            <?php endforeach; ?>
    </table>
</main>




</body>
</html>
