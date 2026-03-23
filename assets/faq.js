console.log("✅ O arquivo FAQ.JS foi carregado com sucesso!");

// seleciona as perguntas do FAQ

const perguntas = document.querySelectorAll('.faq-pergunta');
console.log("Perguntas Encontradas:", perguntas.length); // Mostra no console quantas perguntas FAQ foram achadas. //

// Percorre todas as perguntas
perguntas.forEach((pergunta) =>{

    // Adiciona um evento de clique em cada pergunta
    pergunta.addEventListener('click', ()=> {
        
        // fecha qualquer outra respota aberta
        perguntas.forEach((outra) => {
            if(outra !== pergunta) {
                outra.classList.remove('ativa'); // remove clase ativa
                const outraResposta = outra.nextElementSibling;
                if (outraResposta) {
                    outraResposta.style.maxHeight = null;
                }
            }
        });
        // Alterna o estado da pergunta clicada
        pergunta.classList.toggle('ativa');
         
        // seleciona o elemento de resposta (logo abaixo da pergunta)
        const resposta = pergunta.nextElementSibling;

        // Se estiver ativa, expande;  se nao retrai
        if (perguntas.classList.contains('ativa')) {
            resposta.style.maxHeight = resposta.scrollHeight + 'px'; // anima expansão
        } else {
            resposta.style.maxHeight = null; // fecha a animacao
        }
    });
});


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
    fetch(`sugestoes_artigos.php?q=${encodeURIComponent(termo)}`)
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
    fetch(`sugestoes_artigos.php?q=${encodeURIComponent(termo)}`)
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

