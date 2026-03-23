<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Bank - Portal de Atendimento</title>

    <link rel="stylesheet" href="../assets/style_index.css"> <!-- link para acessar o css -->

</head>

<body>
    <!-- CABECALHO -->
    <header>
        <div class="logo">
            <!-- Area do logo -->
            <img src="../assets/img/logo_banco.png" alt="Logo do Banco" height="100">
            <h2></h2>
        </div>

        <nav>
            <a href="index.php">Início</a>
            <a href="base_conhecimento.php">Base de Conhecimento</a>
            <a href="faq.php">FAQ</a>
            <a href="ticket.php">Atendimento</a>
            <a href="login.php">Area do Colaborador</a>
        </nav>
    </header>

    <!-- seçao hero -->

    <main>
        <section class="hero">
            <!-- Parte de Destaque -->
            <h1>PORTAL DE ATENDIMENTO AO CLIENTE</h1>
            <p>Bem-Vindo ao canal de suporte do Ice Bank.<br>
                Aqui você encontra respostas rápidas e pode abrir solicitaçoes quando quiser.</p>
            <a href="ticket.php" class="btn">Abrir Chamado</a> <!-- Botao Principal -->
        </section>

        <!-- Seçao de Atalhos -->
        <section class="atalhos">
            <h2>O que você precisa hoje?</h2>
            <div class="atalhos-container">
                <a href="base_conhecimento.php" class="card">
                    <img src="../assets/img/artigos.png" alt="Base de Conhecimento"> <!-- Icone -->
                    <h3>Base de Conhecimentos</h3>
                    <p>Artigos e Guias sobre os Serviços Bancários.</p>
                </a>

                <a href="faq.php" class="card">
                    <img src="../assets/img/perguntas.png" alt="FAQ"> <!-- Icone -->
                    <h3>Perguntas Frequentes</h3>
                    <p>Duvidas mais Comuns respondidas em segundos.</p>
                </a>

                <a href="ticket.php" class="card">
                    <img src="../assets/img/ticket.png" alt="Atendimento"> <!-- Icone -->
                    <h3>Suporte ao Cliente</h3>
                    <p>Fale diretamente com a nossa equipe de suporte.</p>
                </a>
            </div>
        </section>
    </main>

    <!-- RODAPÉ -->
    <footer>
        &copy; 2025 Ice Bank - Todos os direitos reservados.
    </footer>

</body>

</html>