
function confirmarExclusao(nome) {
    return confirm('Tem certeza que deseja excluir "' + nome + '"?\nEsta ação não pode ser desfeita.');
}
function validarFormulario(formulario) {
    const camposNumericos = formulario.querySelectorAll('input[type="number"]');

    for (const campo of camposNumericos) {
        if (campo.value !== "" && Number(campo.value) < 0) {
            alert('O campo "' + campo.previousElementSibling.textContent + '" não pode ser negativo.');
            campo.focus();
            return false;
        }
    }
    return true;
}
function calcularIdadePreview() {
    const campoNascimento = document.getElementById("data_nascimento");
    const previewIdade = document.getElementById("preview-idade");

    if (!campoNascimento || !previewIdade) {
        return;
    }

    if (!campoNascimento.value) {
        previewIdade.textContent = "";
        return;
    }

    const nascimento = new Date(campoNascimento.value);
    const hoje = new Date();
    let idade = hoje.getFullYear() - nascimento.getFullYear();
    const aindaNaoFezAniversarioEsteAno =
        hoje.getMonth() < nascimento.getMonth() ||
        (hoje.getMonth() === nascimento.getMonth() && hoje.getDate() < nascimento.getDate());

    if (aindaNaoFezAniversarioEsteAno) {
        idade--;
    }

    previewIdade.textContent = "Idade calculada: " + idade + " anos";
}

function buscarRegistros(tipo) {
    const campoBusca = document.getElementById("campo-busca");
    const corpoTabela = document.getElementById("corpo-tabela");

    if (!campoBusca || !corpoTabela) {
        return;
    }

    const termo = campoBusca.value.trim();

    fetch("buscar.php?tipo=" + encodeURIComponent(tipo) + "&termo=" + encodeURIComponent(termo))
        .then(function (resposta) {
            return resposta.json();
        })
        .then(function (dados) {
            montarLinhasDaTabela(tipo, dados, corpoTabela);
        })
        .catch(function (erro) {
            console.error("Erro ao buscar registros:", erro);
        });
}

function montarLinhasDaTabela(tipo, dados, corpoTabela) {
    corpoTabela.innerHTML = "";

    if (dados.length === 0) {
        corpoTabela.innerHTML = '<tr><td colspan="6">Nenhum resultado encontrado.</td></tr>';
        return;
    }

    dados.forEach(function (item) {
        const linha = document.createElement("tr");
        const governante = item.governante_nome ? item.governante_nome : "—";
        const populacaoFormatada = Number(item.populacao).toLocaleString("pt-BR");

        if (tipo === "paises") {
            linha.innerHTML =
                "<td>" + item.nome + "</td>" +
                "<td>" + item.continente_nome + "</td>" +
                "<td>" + populacaoFormatada + "</td>" +
                "<td>" + governante + "</td>" +
                '<td class="coluna-acoes">' +
                '<a href="paises_form.php?id=' + item.id + '" class="botao botao-editar">Editar</a> ' +
                '<a href="paises_excluir.php?id=' + item.id + '" class="botao botao-excluir" ' +
                "onclick=\"return confirmarExclusao('" + item.nome + "');\">Excluir</a>" +
                "</td>";
        } else {
            linha.innerHTML =
                "<td>" + item.nome + "</td>" +
                "<td>" + item.pais_nome + "</td>" +
                "<td>" + populacaoFormatada + "</td>" +
                "<td>" + governante + "</td>" +
                '<td class="coluna-acoes">' +
                '<a href="cidades_form.php?id=' + item.id + '" class="botao botao-editar">Editar</a> ' +
                '<a href="cidades_excluir.php?id=' + item.id + '" class="botao botao-excluir" ' +
                "onclick=\"return confirmarExclusao('" + item.nome + "');\">Excluir</a>" +
                "</td>";
        }

        corpoTabela.appendChild(linha);
    });
}
