// clica no botão "Gerar Campos de Alunos"
function gerarCampos() {
    // Pega o valor digitado no campo de quantidade e converte para número inteiro
    let quantidade = parseInt(document.getElementById('qtdAlunos').value);
    
    // Pega a div onde os campos vão ser preenchidos
    let container = document.getElementById('containerAlunos');
    
    // Pega o botão de enviar (para mostrar depois que os campos forem gerados)
    let btnEnviar = document.getElementById('btnEnviar');

    // Validação simples: a quantidade deve ser maior que zero
    if (isNaN(quantidade) || quantidade <= 0) {
        alert("Por favor, informe uma quantidade válida de alunos.");
        return; // Para a execução da função aqui se for inválido
    }

    // Limpa a div caso o usuário clique no botão mais de uma vez
    container.innerHTML = "";

    // Estrutura de repetição (loop) para criar os campos de cada aluno
    for (let i = 1; i <= quantidade; i++) {
        // Cria o HTML do bloco do aluno. 
        // Note o uso de colchetes [] nos 'names'. Isso cria um Array no PHP!
        let htmlAluno = `
            <div class="cartao-aluno">
                <h3>Aluno ${i}</h3>
                
                <div class="grupo-input">
                    <label>Nome do Aluno:</label>
                    <input type="text" name="nomes[]" required>
                </div>
                
                <div class="grupo-input">
                    <label>Nota da Prova 1:</label>
                    <input type="number" step="0.1" min="0" max="10" name="notas_prova1[]" required>
                </div>

                <div class="grupo-input">
                    <label>Nota da Prova 2:</label>
                    <input type="number" step="0.1" min="0" max="10" name="notas_prova2[]" required>
                </div>

                <div class="grupo-input">
                    <label>Nota de Trabalho:</label>
                    <input type="number" step="0.1" min="0" max="10" name="notas_trabalho[]" required>
                </div>
            </div>
        `;

        // Adiciona o bloco criado dentro do container principal na tela
        container.innerHTML += htmlAluno;
    }

    // Mostra o botão de "Calcular Resultados" para enviar o formulário ao PHP
    btnEnviar.style.display = "block";
}