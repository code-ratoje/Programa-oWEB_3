<?php
require_once "config/conexao.php";

$modo_edicao = false;
$pais = [
    "id" => "", "nome" => "", "continente_id" => "", "populacao" => "", "area" => "",
    "idioma" => "", "governante_id" => "", "clima" => "", "regime_politico" => "", "moeda" => ""
];
$erro = "";

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $resultado = mysqli_query($conexao, "SELECT * FROM paises WHERE id = $id");
    $encontrado = mysqli_fetch_assoc($resultado);

    if ($encontrado) {
        $pais = $encontrado;
        $modo_edicao = true;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = mysqli_real_escape_string($conexao, trim($_POST["nome"]));
    $continente_id = intval($_POST["continente_id"]);
    $populacao = intval($_POST["populacao"]);
    $area = floatval(str_replace(",", ".", $_POST["area"]));
    $idioma = mysqli_real_escape_string($conexao, trim($_POST["idioma"]));
    $clima = mysqli_real_escape_string($conexao, trim($_POST["clima"]));
    $regime_politico = mysqli_real_escape_string($conexao, trim($_POST["regime_politico"]));
    $moeda = mysqli_real_escape_string($conexao, trim($_POST["moeda"]));

    // governante é opcional: se o usuário não escolher nenhum, salvamos NULL
    $governante_id_valor = ($_POST["governante_id"] !== "") ? intval($_POST["governante_id"]) : null;
    $governante_sql = ($governante_id_valor === null) ? "NULL" : $governante_id_valor;

    $id_post = (isset($_POST["id"]) && $_POST["id"] !== "") ? intval($_POST["id"]) : null;

    if ($nome === "" || $continente_id === 0) {
        $erro = "Nome e continente são obrigatórios.";
    } else {
        if ($id_post) {
            $antigoResultado = mysqli_query($conexao, "SELECT continente_id FROM paises WHERE id = $id_post");
            $antigo = mysqli_fetch_assoc($antigoResultado);
            $continente_antigo_id = $antigo ? intval($antigo["continente_id"]) : $continente_id;

            $sql = "UPDATE paises SET
                        nome = '$nome',
                        continente_id = $continente_id,
                        populacao = $populacao,
                        area = $area,
                        idioma = '$idioma',
                        governante_id = $governante_sql,
                        clima = '$clima',
                        regime_politico = '$regime_politico',
                        moeda = '$moeda'
                    WHERE id = $id_post";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado) {
                // Se o país mudou de continente, ajusta o contador dos dois continentes envolvidos
                if ($continente_antigo_id !== $continente_id) {
                    mysqli_query($conexao, "UPDATE continentes SET total_paises = total_paises - 1 WHERE id = $continente_antigo_id");
                    mysqli_query($conexao, "UPDATE continentes SET total_paises = total_paises + 1 WHERE id = $continente_id");
                }
                header("Location: paises_listar.php?sucesso=" . urlencode("País atualizado com sucesso!"));
                exit;
            } else {
                $erro = "Erro ao atualizar: " . mysqli_error($conexao);
            }
        } else {
            $sql = "INSERT INTO paises (nome, continente_id, populacao, area, idioma, governante_id, clima, regime_politico, moeda)
                    VALUES ('$nome', $continente_id, $populacao, $area, '$idioma', $governante_sql, '$clima', '$regime_politico', '$moeda')";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado) {
                mysqli_query($conexao, "UPDATE continentes SET total_paises = total_paises + 1 WHERE id = $continente_id");
                header("Location: paises_listar.php?sucesso=" . urlencode("País cadastrado com sucesso!"));
                exit;
            } else {
                $erro = "Erro ao cadastrar: " . mysqli_error($conexao);
            }
        }

        // Mantém os dados digitados na tela em caso de erro
        $pais = $_POST;
        $modo_edicao = (bool) $id_post;
    }
}

$continentes = mysqli_query($conexao, "SELECT id, nome FROM continentes ORDER BY nome");
$governantes = mysqli_query($conexao, "SELECT id, nome FROM governantes ORDER BY nome");

$titulo_pagina = $modo_edicao ? "Editar País" : "Novo País";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <h1><?php echo $titulo_pagina; ?></h1>

    <?php if ($erro): ?>
        <p class="mensagem mensagem-erro"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <?php if (mysqli_num_rows($continentes) === 0): ?>
        <p class="mensagem mensagem-erro">
            Você precisa cadastrar pelo menos um continente antes de cadastrar um país.
            <a href="continentes_form.php">Cadastrar continente</a>
        </p>
    <?php else: ?>
        <?php mysqli_data_seek($continentes, 0); ?>
        <form method="POST" class="formulario" onsubmit="return validarFormulario(this);">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($pais["id"]); ?>">

            <label for="nome">Nome do país *</label>
            <input type="text" id="nome" name="nome" required value="<?php echo htmlspecialchars($pais["nome"]); ?>">

            <label for="continente_id">Continente *</label>
            <select id="continente_id" name="continente_id" required>
                <option value="">Selecione...</option>
                <?php while ($c = mysqli_fetch_assoc($continentes)): ?>
                    <option value="<?php echo $c["id"]; ?>" <?php echo ($pais["continente_id"] == $c["id"]) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($c["nome"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="populacao">População *</label>
            <input type="number" id="populacao" name="populacao" min="0" required value="<?php echo htmlspecialchars($pais["populacao"]); ?>">

            <label for="area">Área em km² *</label>
            <input type="number" id="area" name="area" min="0" step="0.01" required value="<?php echo htmlspecialchars($pais["area"]); ?>">

            <label for="idioma">Idioma</label>
            <input type="text" id="idioma" name="idioma" value="<?php echo htmlspecialchars($pais["idioma"]); ?>">

            <label for="governante_id">Governante</label>
            <select id="governante_id" name="governante_id">
                <option value="">Nenhum</option>
                <?php while ($g = mysqli_fetch_assoc($governantes)): ?>
                    <option value="<?php echo $g["id"]; ?>" <?php echo ($pais["governante_id"] == $g["id"]) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($g["nome"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="clima">Clima</label>
            <input type="text" id="clima" name="clima" value="<?php echo htmlspecialchars($pais["clima"]); ?>">

            <label for="regime_politico">Regime político</label>
            <input type="text" id="regime_politico" name="regime_politico" value="<?php echo htmlspecialchars($pais["regime_politico"]); ?>">

            <label for="moeda">Moeda</label>
            <input type="text" id="moeda" name="moeda" value="<?php echo htmlspecialchars($pais["moeda"]); ?>">

            <div class="acoes-formulario">
                <button type="submit" class="botao botao-criar">Salvar</button>
                <a href="paises_listar.php" class="botao botao-cancelar">Cancelar</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php require_once "includes/rodape.php"; ?>
