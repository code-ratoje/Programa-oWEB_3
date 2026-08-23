<?php
require_once "config/conexao.php";

$sql = "SELECT ci.id, ci.nome, p.nome AS pais_nome, ci.populacao, g.nome AS governante_nome
        FROM cidades ci
        INNER JOIN paises p ON ci.pais_id = p.id
        LEFT JOIN governantes g ON ci.governante_id = g.id
        ORDER BY ci.nome";
$resultado = mysqli_query($conexao, $sql);

$titulo_pagina = "Cidades";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <div class="topo-pagina">
        <h1>Cidades</h1>
        <a href="cidades_form.php" class="botao botao-criar">+ Nova Cidade</a>
    </div>

    <?php if (isset($_GET["sucesso"])): ?>
        <p class="mensagem mensagem-sucesso"><?php echo htmlspecialchars($_GET["sucesso"]); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET["erro"])): ?>
        <p class="mensagem mensagem-erro"><?php echo htmlspecialchars($_GET["erro"]); ?></p>
    <?php endif; ?>

    <div class="caixa-busca">
        <input type="text" id="campo-busca" placeholder="Buscar cidade pelo nome..." onkeyup="buscarRegistros('cidades')">
    </div>

    <div class="tabela-rolavel">
        <table class="tabela-dados">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>País</th>
                    <th>População</th>
                    <th>Governante</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="corpo-tabela">
                <?php if (mysqli_num_rows($resultado) === 0): ?>
                    <tr><td colspan="5">Nenhuma cidade cadastrada ainda.</td></tr>
                <?php else: ?>
                    <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linha["nome"]); ?></td>
                            <td><?php echo htmlspecialchars($linha["pais_nome"]); ?></td>
                            <td><?php echo number_format($linha["populacao"], 0, ",", "."); ?></td>
                            <td><?php echo $linha["governante_nome"] ? htmlspecialchars($linha["governante_nome"]) : "—"; ?></td>
                            <td class="coluna-acoes">
                                <a href="cidades_form.php?id=<?php echo $linha["id"]; ?>" class="botao botao-editar">Editar</a>
                                <a href="cidades_excluir.php?id=<?php echo $linha["id"]; ?>"
                                   class="botao botao-excluir"
                                   onclick="return confirmarExclusao('<?php echo htmlspecialchars($linha["nome"], ENT_QUOTES); ?>');">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once "includes/rodape.php"; ?>
