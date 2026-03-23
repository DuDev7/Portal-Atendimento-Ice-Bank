<?php
session_start(); // Inicia sessão

// Se já estiver logado, redireciona direto pro painel
if (isset($_SESSION['admin_logado'])) {
    header("Location: painel.php");
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Credenciais fixas (poderia vir de um JSON futuramente)
    $usuarioPadrao = 'admin';
    $senhaPadrao = '12345';

    if ($usuario === $usuarioPadrao && $senha === $senhaPadrao) {
        $_SESSION['admin_logado'] = true;
        header("Location: painel.php");
        exit;
    } else {
        $erro = "Usuário ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área do Colaborador</title>
    <link rel="stylesheet" href="../assets/style_login.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <body>
    <main class="login-container">
        <div class="login-box">
            <img src="../assets/img/logo_banco.png" alt="Logo do Banco" height="100">
            <h2>Área do Colaborador - Ice Bank</h2>
            <p>Faça login para acessar o painel de chamados</p>

            <?php if (isset($erro)): ?>
                <div class="erro-login"><?= $erro ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="usuario" placeholder="Usuário" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit" class="btn-login">Entrar</button>
            </form>
    </main>
        </div>
    </body>
    
    <footer>
        &copy; 2025 Ice Bank - Todos os direitos reservados.
    </footer>
    <!-- RODAPÉ -->

</body>
</html>
