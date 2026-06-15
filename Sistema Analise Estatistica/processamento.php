<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório Estatístico</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">

<?php
// Verifica se o formulário realmente foi enviado (se os dados existem via POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recebendo os dados do formulário
    $nome_turma = $_POST['nome_turma'];
    // os dados dos alunos são puxados como listas (arrays) devido ao "[]" no HTML/JS
    $nomes = $_POST['nomes'];
    $notas_prova1 = $_POST['notas_prova1'];
    $notas_prova2 = $_POST['notas_prova2'];
    $notas_trabalho = $_POST['notas_trabalho'];

    // contando a quantidade total de alunos
    $total_alunos = count($nomes);

    // criação das variaveis gerais
    $soma_todas_notas_turma = 0;
    $soma_medias_turma = 0;
    $maior_media = -1; // Começa negativo para garantir que a 1ª média seja maior
    $menor_media = 99999999; // Começa alto para garantir que a 1ª média seja menor
    $quantidade_aprovados = 0;
    $quantidade_recuperacao = 0;
    $quantidade_reprovados = 0;

    echo "<h1>Relatório da Turma: $nome_turma</h1>";
    echo "<h2>Resultados Individuais</h2>";
    echo "<table>";
    echo "<tr>
            <th>Aluno</th>
            <th>Média</th>
            <th>Raiz da Soma</th>
            <th>Dif. Absoluta (Maior - Menor)</th>
            <th>Situação</th>
          </tr>";

    // repetição for para processar os dados de cada aluno
    for ($i = 0; $i < $total_alunos; $i++) {
        // Lendo os dados do aluno atual da repetição
        $nome_aluno = $nomes[$i];
        $nota1 = floatval($notas_prova1[$i]);
        $nota2 = floatval($notas_prova2[$i]);
        $trabalho = floatval($notas_trabalho[$i]);

        // 1- Cálculo da soma das notas do aluno
        $soma_notas_aluno = $nota1 + $nota2 + $trabalho;
        
        // Acumula na soma total da turma
        $soma_todas_notas_turma += $soma_notas_aluno;

        // 2- Cálculo da média
        $media_aluno = $soma_notas_aluno / 3;
        $soma_medias_turma += $media_aluno; // Acumula para a média geral depois

        // 3- Raiz quadrada da soma 
        $raiz_soma = sqrt($soma_notas_aluno);

        // 4. Diferença entre a maior e menor nota
        // Pega a maior nota entre as três
        $maior_nota_aluno = max($nota1, $nota2, $trabalho);
        // Pega a menor nota entre as três
        $menor_nota_aluno = min($nota1, $nota2, $trabalho);
        // Calcula o valor absoluto (Função nativa abs solicitada)
        $diferenca_absoluta = abs($maior_nota_aluno - $menor_nota_aluno);

        // 5- verificação do estado do aluno
        if ($media_aluno >= 7.0) {
            $situacao = "Aprovado";
            $classe_css = "aprovado";
            $quantidade_aprovados++;
        } elseif ($media_aluno >= 5.0 && $media_aluno < 7.0) {
            $situacao = "Recuperação";
            $classe_css = "recuperacao";
            $quantidade_recuperacao++;
        } else {
            $situacao = "Reprovado";
            $classe_css = "reprovado";
            $quantidade_reprovados++;
        }

        // 6- Verificando a maior e menor média da turma
        if ($media_aluno > $maior_media) {
            $maior_media = $media_aluno;
        }
        if ($media_aluno < $menor_media) {
            $menor_media = $media_aluno;
        }

        // Imprimindo a linha do aluno na tabela (Formatando números para 2 casas decimais)
        echo "<tr>";
        echo "<td>$nome_aluno</td>";
        echo "<td>" . number_format($media_aluno, 2, ',', '.') . "</td>";
        echo "<td>" . number_format($raiz_soma, 2, ',', '.') . "</td>";
        echo "<td>" . number_format($diferenca_absoluta, 2, ',', '.') . "</td>";
        echo "<td class='$classe_css'>$situacao</td>";
        echo "</tr>";
    }

    echo "</table>";

    // ==========================================
    // CÁLCULOS FINAIS DA TURMA
    // ==========================================
    
    // Média geral (Soma de todas as médias dividida pelo total de alunos)
    $media_geral_turma = $soma_medias_turma / $total_alunos;

    // Percentual de aprovação: (Aprovados / Total) * 100
    $percentual_aprovacao = ($quantidade_aprovados / $total_alunos) * 100;

    // Gerando mensagem automática de desempenho
    $mensagem_desempenho = "";
    if ($percentual_aprovacao >= 70) {
        $mensagem_desempenho = "Excelente trabalho! A maior parte da turma foi aprovada.";
    } elseif ($percentual_aprovacao >= 40) {
        $mensagem_desempenho = "Desempenho regular. Muitos alunos em recuperação ou reprovados, atenção necessária.";
    } else {
        $mensagem_desempenho = "Desempenho crítico! A maioria da turma foi reprovada. Revisar metodologias.";
    }

    // ==========================================
    // EXIBIÇÃO DO RELATÓRIO ESTATÍSTICO DA TURMA
    // ==========================================
    echo "<div class='estatisticas'>";
    echo "<h2>Estatísticas Gerais da Turma</h2>";
    echo "<p><strong>Total de Alunos:</strong> $total_alunos</p>";
    echo "<p><strong>Média Geral da Turma:</strong> " . number_format($media_geral_turma, 2, ',', '.') . "</p>";
    echo "<p><strong>Maior Média:</strong> " . number_format($maior_media, 2, ',', '.') . "</p>";
    echo "<p><strong>Menor Média:</strong> " . number_format($menor_media, 2, ',', '.') . "</p>";
    echo "<p><strong>Soma Total de Todas as Notas:</strong> " . number_format($soma_todas_notas_turma, 2, ',', '.') . "</p>";
    
    echo "<h3>Contagem e Desempenho</h3>";
    echo "<p><strong>Alunos Aprovados:</strong> $quantidade_aprovados</p>";
    echo "<p><strong>Alunos em Recuperação:</strong> $quantidade_recuperacao</p>";
    echo "<p><strong>Alunos Reprovados:</strong> $quantidade_reprovados</p>";
    echo "<p><strong>Percentual de Aprovação:</strong> " . number_format($percentual_aprovacao, 1, ',', '.') . "%</p>";
    
    echo "<h3>Análise do Sistema</h3>";
    echo "<p><em>$mensagem_desempenho</em></p>";
    
    // Botão para voltar
    echo "<button onclick='window.history.back()' style='margin-top: 20px;'>Voltar e Inserir Nova Turma</button>";
    echo "</div>";

} else {
    // Caso alguém tente acessar o arquivo PHP direto pela URL sem enviar o formulário
    echo "<h2>Acesso negado. Por favor, preencha o formulário primeiro.</h2>";
    echo "<a href='index.html'>Voltar ao Formulário</a>";
}
?>

</div>
</body>
</html>