<?php
require_once "config/conexao.php";

// Para cada governante, verificamos (com subconsultas) se ele está
// associado a algum país e/ou a alguma cidade, só para exibição.
$sql = "SELECT g.*,
            (SELECT p.nome FROM paises p WHERE p.governante_id = g.id LIMIT 1) AS pais_governado,
            (SELECT c.nome FROM cidades c WHERE c.governante_id = g.id LIMIT 1) AS cidade_governada
        FROM governantes g
        ORDER BY g.nome";
$resultado = mysqli_query($conexao, $sql);

$titulo_pagina = "Governantes";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <div class="topo-pagina">
        <h1>Governantes</h1>
        <a href="governantes_form.php" class="botao botao-criar">+ Novo Governante</a>
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
                    <th>Partido</th>
                    <th>Idade</th>
                    <th>Início do mandato</th>
                    <th>Governa</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($resultado) === 0): ?>
                    <tr><td colspan="6">Nenhum governante cadastrado ainda.</td></tr>
                <?php else: ?>
                    <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
                        <?php
                            $governa = [];
                            if ($linha["pais_governado"]) { $governa[] = "País: " . $linha["pais_governado"]; }
                            if ($linha["cidade_governada"]) { $governa[] = "Cidade: " . $linha["cidade_governada"]; }
                            $texto_governa = $governa ? implode(" / ", $governa) : "—";
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linha["nome"]); ?></td>
                            <td><?php echo htmlspecialchars($linha["partido_politico"] ?? ""); ?></td>
                            <td><?php echo htmlspecialchars($linha["idade"] ?? ""); ?></td>
                            <td><?php echo $linha["data_inicio_mandato"] ? date("d/m/Y", strtotime($linha["data_inicio_mandato"])) : "—"; ?></td>
                            <td><?php echo htmlspecialchars($texto_governa); ?></td>
                            <td class="coluna-acoes">
                                <a href="governantes_form.php?id=<?php echo $linha["id"]; ?>" class="botao botao-editar">Editar</a>
                                <a href="governantes_excluir.php?id=<?php echo $linha["id"]; ?>"
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
