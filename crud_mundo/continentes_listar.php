<?php
require_once "config/conexao.php";

$sql = "SELECT id, nome, populacao, area, total_paises FROM continentes ORDER BY nome";
$resultado = mysqli_query($conexao, $sql);

$titulo_pagina = "Continentes";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <div class="topo-pagina">
        <h1>Continentes</h1>
        <a href="continentes_form.php" class="botao botao-criar">+ Novo Continente</a>
    </div>

    <?php if (isset($_GET["sucesso"])): ?>
        <p class="mensagem mensagem-sucesso"><?php echo htmlspecialchars($_GET["sucesso"]); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET["erro"])): ?>
        <p class="mensagem mensagem-erro"><?php echo htmlspecialchars($_GET["erro"]); ?></p>
    <?php endif; ?>

    <div class="tabela-rolavel">
        <table class="tabela-dados">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>População</th>
                    <th>Área (km²)</th>
                    <th>Total de países</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($resultado) === 0): ?>
                    <tr><td colspan="5">Nenhum continente cadastrado ainda.</td></tr>
                <?php else: ?>
                    <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linha["nome"]); ?></td>
                            <td><?php echo number_format($linha["populacao"], 0, ",", "."); ?></td>
                            <td><?php echo number_format($linha["area"], 2, ",", "."); ?></td>
                            <td><?php echo $linha["total_paises"]; ?></td>
                            <td class="coluna-acoes">
                                <a href="continentes_form.php?id=<?php echo $linha["id"]; ?>" class="botao botao-editar">Editar</a>
                                <a href="continentes_excluir.php?id=<?php echo $linha["id"]; ?>"
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
