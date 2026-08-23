<?php
require_once "config/conexao.php";

$sql = "SELECT p.id, p.nome, c.nome AS continente_nome, p.populacao, g.nome AS governante_nome
        FROM paises p
        INNER JOIN continentes c ON p.continente_id = c.id
        LEFT JOIN governantes g ON p.governante_id = g.id
        ORDER BY p.nome";
$resultado = mysqli_query($conexao, $sql);

$titulo_pagina = "Países";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <div class="topo-pagina">
        <h1>Países</h1>
        <a href="paises_form.php" class="botao botao-criar">+ Novo País</a>
    </div>

    <?php if (isset($_GET["sucesso"])): ?>
        <p class="mensagem mensagem-sucesso"><?php echo htmlspecialchars($_GET["sucesso"]); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET["erro"])): ?>
        <p class="mensagem mensagem-erro"><?php echo htmlspecialchars($_GET["erro"]); ?></p>
    <?php endif; ?>

    <div class="caixa-busca">
        <input type="text" id="campo-busca" placeholder="Buscar país pelo nome..." onkeyup="buscarRegistros('paises')">
    </div>

    <div class="tabela-rolavel">
        <table class="tabela-dados">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Continente</th>
                    <th>População</th>
                    <th>Governante</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="corpo-tabela">
                <?php if (mysqli_num_rows($resultado) === 0): ?>
                    <tr><td colspan="5">Nenhum país cadastrado ainda.</td></tr>
                <?php else: ?>
                    <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linha["nome"]); ?></td>
                            <td><?php echo htmlspecialchars($linha["continente_nome"]); ?></td>
                            <td><?php echo number_format($linha["populacao"], 0, ",", "."); ?></td>
                            <td><?php echo $linha["governante_nome"] ? htmlspecialchars($linha["governante_nome"]) : "—"; ?></td>
                            <td class="coluna-acoes">
                                <a href="paises_form.php?id=<?php echo $linha["id"]; ?>" class="botao botao-editar">Editar</a>
                                <a href="paises_excluir.php?id=<?php echo $linha["id"]; ?>"
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
