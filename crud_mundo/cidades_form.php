<?php
require_once "config/conexao.php";

$modo_edicao = false;
$cidade = [
    "id" => "", "nome" => "", "pais_id" => "", "populacao" => "", "area" => "",
    "clima" => "", "governante_id" => "", "data_fundacao" => ""
];
$erro = "";

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $resultado = mysqli_query($conexao, "SELECT * FROM cidades WHERE id = $id");
    $encontrado = mysqli_fetch_assoc($resultado);

    if ($encontrado) {
        $cidade = $encontrado;
        $modo_edicao = true;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = mysqli_real_escape_string($conexao, trim($_POST["nome"]));
    $pais_id = intval($_POST["pais_id"]);
    $populacao = intval($_POST["populacao"]);
    $area = floatval(str_replace(",", ".", $_POST["area"]));
    $clima = mysqli_real_escape_string($conexao, trim($_POST["clima"]));
    $data_fundacao = trim($_POST["data_fundacao"]);
    $data_fundacao_sql = ($data_fundacao !== "") ? "'" . mysqli_real_escape_string($conexao, $data_fundacao) . "'" : "NULL";

    $governante_id_valor = ($_POST["governante_id"] !== "") ? intval($_POST["governante_id"]) : null;
    $governante_sql = ($governante_id_valor === null) ? "NULL" : $governante_id_valor;

    $id_post = (isset($_POST["id"]) && $_POST["id"] !== "") ? intval($_POST["id"]) : null;

    if ($nome === "" || $pais_id === 0) {
        $erro = "Nome e país são obrigatórios.";
    } else {
        if ($id_post) {
            $sql = "UPDATE cidades SET
                        nome = '$nome',
                        pais_id = $pais_id,
                        populacao = $populacao,
                        area = $area,
                        clima = '$clima',
                        governante_id = $governante_sql,
                        data_fundacao = $data_fundacao_sql
                    WHERE id = $id_post";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado) {
                header("Location: cidades_listar.php?sucesso=" . urlencode("Cidade atualizada com sucesso!"));
                exit;
            } else {
                $erro = "Erro ao atualizar: " . mysqli_error($conexao);
            }
        } else {
            $sql = "INSERT INTO cidades (nome, pais_id, populacao, area, clima, governante_id, data_fundacao)
                    VALUES ('$nome', $pais_id, $populacao, $area, '$clima', $governante_sql, $data_fundacao_sql)";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado) {
                header("Location: cidades_listar.php?sucesso=" . urlencode("Cidade cadastrada com sucesso!"));
                exit;
            } else {
                $erro = "Erro ao cadastrar: " . mysqli_error($conexao);
            }
        }

        $cidade = $_POST;
        $modo_edicao = (bool) $id_post;
    }
}

$paises = mysqli_query($conexao, "SELECT id, nome FROM paises ORDER BY nome");
$governantes = mysqli_query($conexao, "SELECT id, nome FROM governantes ORDER BY nome");

$titulo_pagina = $modo_edicao ? "Editar Cidade" : "Nova Cidade";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <h1><?php echo $titulo_pagina; ?></h1>

    <?php if ($erro): ?>
        <p class="mensagem mensagem-erro"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <?php if (mysqli_num_rows($paises) === 0): ?>
        <p class="mensagem mensagem-erro">
            Você precisa cadastrar pelo menos um país antes de cadastrar uma cidade.
            <a href="paises_form.php">Cadastrar país</a>
        </p>
    <?php else: ?>
        <form method="POST" class="formulario" onsubmit="return validarFormulario(this);">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($cidade["id"]); ?>">

            <label for="nome">Nome da cidade *</label>
            <input type="text" id="nome" name="nome" required value="<?php echo htmlspecialchars($cidade["nome"]); ?>">

            <label for="pais_id">País *</label>
            <select id="pais_id" name="pais_id" required>
                <option value="">Selecione...</option>
                <?php while ($p = mysqli_fetch_assoc($paises)): ?>
                    <option value="<?php echo $p["id"]; ?>" <?php echo ($cidade["pais_id"] == $p["id"]) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($p["nome"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="populacao">População *</label>
            <input type="number" id="populacao" name="populacao" min="0" required value="<?php echo htmlspecialchars($cidade["populacao"]); ?>">

            <label for="area">Área em km² *</label>
            <input type="number" id="area" name="area" min="0" step="0.01" required value="<?php echo htmlspecialchars($cidade["area"]); ?>">

            <label for="clima">Clima</label>
            <input type="text" id="clima" name="clima" value="<?php echo htmlspecialchars($cidade["clima"]); ?>">

            <label for="governante_id">Governante (ex.: prefeito)</label>
            <select id="governante_id" name="governante_id">
                <option value="">Nenhum</option>
                <?php while ($g = mysqli_fetch_assoc($governantes)): ?>
                    <option value="<?php echo $g["id"]; ?>" <?php echo ($cidade["governante_id"] == $g["id"]) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($g["nome"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="data_fundacao">Data de fundação</label>
            <input type="date" id="data_fundacao" name="data_fundacao" value="<?php echo htmlspecialchars($cidade["data_fundacao"] ?? ""); ?>">

            <div class="acoes-formulario">
                <button type="submit" class="botao botao-criar">Salvar</button>
                <a href="cidades_listar.php" class="botao botao-cancelar">Cancelar</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php require_once "includes/rodape.php"; ?>
