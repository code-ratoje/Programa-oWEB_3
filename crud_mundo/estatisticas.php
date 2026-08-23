<?php
require_once "config/conexao.php";

// A cidade mais populosa de cada país
$sqlCidadeMaisPopulosa = "
    SELECT p.nome AS pais, ci.nome AS cidade, ci.populacao
    FROM cidades ci
    INNER JOIN paises p ON ci.pais_id = p.id
    WHERE ci.populacao = (
        SELECT MAX(ci2.populacao) FROM cidades ci2 WHERE ci2.pais_id = ci.pais_id
    )
    ORDER BY p.nome
";
$cidadesMaisPopulosas = mysqli_query($conexao, $sqlCidadeMaisPopulosa);

// Total de cidades cadastradas por continente
$sqlCidadesPorContinente = "
    SELECT co.nome AS continente, COUNT(ci.id) AS total_cidades
    FROM continentes co
    LEFT JOIN paises p ON p.continente_id = co.id
    LEFT JOIN cidades ci ON ci.pais_id = p.id
    GROUP BY co.id, co.nome
    ORDER BY co.nome
";
$cidadesPorContinente = mysqli_query($conexao, $sqlCidadesPorContinente);

$titulo_pagina = "Estatísticas";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <h1>Estatísticas</h1>

    <h2>Cidade mais populosa de cada país</h2>
    <div class="tabela-rolavel">
        <table class="tabela-dados">
            <thead><tr><th>País</th><th>Cidade</th><th>População</th></tr></thead>
            <tbody>
                <?php if (mysqli_num_rows($cidadesMaisPopulosas) === 0): ?>
                    <tr><td colspan="3">Nenhum dado disponível ainda.</td></tr>
                <?php else: ?>
                    <?php while ($linha = mysqli_fetch_assoc($cidadesMaisPopulosas)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linha["pais"]); ?></td>
                            <td><?php echo htmlspecialchars($linha["cidade"]); ?></td>
                            <td><?php echo number_format($linha["populacao"], 0, ",", "."); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <h2>Total de cidades cadastradas por continente</h2>
    <div class="tabela-rolavel">
        <table class="tabela-dados">
            <thead><tr><th>Continente</th><th>Total de cidades</th></tr></thead>
            <tbody>
                <?php if (mysqli_num_rows($cidadesPorContinente) === 0): ?>
                    <tr><td colspan="2">Nenhum dado disponível ainda.</td></tr>
                <?php else: ?>
                    <?php while ($linha = mysqli_fetch_assoc($cidadesPorContinente)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linha["continente"]); ?></td>
                            <td><?php echo $linha["total_cidades"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once "includes/rodape.php"; ?>
