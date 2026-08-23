<?php
require_once "config/conexao.php";

$modo_edicao = false;
$continente = [
    "id" => "",
    "nome" => "",
    "populacao" => "",
    "area" => "",
    "total_paises" => 0
];
$erro = "";

// Se veio um "id" pela URL, estamos editando um registro existente
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $resultado = mysqli_query($conexao, "SELECT * FROM continentes WHERE id = $id");
    $encontrado = mysqli_fetch_assoc($resultado);

    if ($encontrado) {
        $continente = $encontrado;
        $modo_edicao = true;
    }
}

// Processa o envio do formulário (tanto criação quanto edição)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = mysqli_real_escape_string($conexao, trim($_POST["nome"]));
    $populacao = intval($_POST["populacao"]);
    $area = floatval(str_replace(",", ".", $_POST["area"]));
    $id_post = (isset($_POST["id"]) && $_POST["id"] !== "") ? intval($_POST["id"]) : null;

    if ($nome === "") {
        $erro = "O nome do continente é obrigatório.";
    } elseif ($populacao < 0 || $area < 0) {
        $erro = "População e área não podem ser negativas.";
    } else {
        if ($id_post) {
            // ATUALIZAÇÃO (UPDATE)
            $sql = "UPDATE continentes
                    SET nome = '$nome', populacao = $populacao, area = $area
                    WHERE id = $id_post";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado) {
                header("Location: continentes_listar.php?sucesso=" . urlencode("Continente atualizado com sucesso!"));
                exit;
            } else {
                $erro = "Erro ao atualizar: " . mysqli_error($conexao);
            }
        } else {
            // INSERÇÃO (INSERT) - total_paises sempre começa em 0
            $sql = "INSERT INTO continentes (nome, populacao, area, total_paises)
                    VALUES ('$nome', $populacao, $area, 0)";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado) {
                header("Location: continentes_listar.php?sucesso=" . urlencode("Continente cadastrado com sucesso!"));
                exit;
            } else {
                $erro = "Erro ao cadastrar: " . mysqli_error($conexao);
            }
        }

        // Se caiu aqui é porque deu erro; mantém os dados digitados na tela
        $continente["id"] = $id_post;
        $continente["nome"] = $_POST["nome"];
        $continente["populacao"] = $_POST["populacao"];
        $continente["area"] = $_POST["area"];
        $modo_edicao = (bool) $id_post;
    }
}

$titulo_pagina = $modo_edicao ? "Editar Continente" : "Novo Continente";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <h1><?php echo $titulo_pagina; ?></h1>

    <?php if ($erro): ?>
        <p class="mensagem mensagem-erro"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <form method="POST" class="formulario" onsubmit="return validarFormulario(this);">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($continente["id"] ?? ""); ?>">

        <label for="nome">Nome do continente *</label>
        <input type="text" id="nome" name="nome" required
               value="<?php echo htmlspecialchars($continente["nome"]); ?>">

        <label for="populacao">População *</label>
        <input type="number" id="populacao" name="populacao" min="0" required
               value="<?php echo htmlspecialchars($continente["populacao"]); ?>">

        <label for="area">Área em km² *</label>
        <input type="number" id="area" name="area" min="0" step="0.01" required
               value="<?php echo htmlspecialchars($continente["area"]); ?>">

        <?php if ($modo_edicao): ?>
            <p class="ajuda">Total de países neste continente: <?php echo $continente["total_paises"]; ?>
               (calculado automaticamente pelo sistema)</p>
        <?php endif; ?>

        <div class="acoes-formulario">
            <button type="submit" class="botao botao-criar">Salvar</button>
            <a href="continentes_listar.php" class="botao botao-cancelar">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once "includes/rodape.php"; ?>
