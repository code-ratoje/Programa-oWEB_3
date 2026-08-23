<?php
require_once "config/conexao.php";

$modo_edicao = false;
$governante = [
    "id" => "", "nome" => "", "partido_politico" => "", "data_nascimento" => "",
    "idade" => "", "data_inicio_mandato" => "", "data_fim_mandato" => ""
];
$erro = "";

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $resultado = mysqli_query($conexao, "SELECT * FROM governantes WHERE id = $id");
    $encontrado = mysqli_fetch_assoc($resultado);

    if ($encontrado) {
        $governante = $encontrado;
        $modo_edicao = true;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = mysqli_real_escape_string($conexao, trim($_POST["nome"]));
    $partido_politico = mysqli_real_escape_string($conexao, trim($_POST["partido_politico"]));
    $data_nascimento = trim($_POST["data_nascimento"]);
    $data_inicio_mandato = trim($_POST["data_inicio_mandato"]);
    $data_fim_mandato = trim($_POST["data_fim_mandato"]);

    $id_post = (isset($_POST["id"]) && $_POST["id"] !== "") ? intval($_POST["id"]) : null;

    if ($nome === "" || $data_nascimento === "") {
        $erro = "Nome e data de nascimento são obrigatórios.";
    } else {
        // A idade é sempre calculada pelo próprio sistema a partir da
        // data de nascimento, para não correr o risco de ficar
        // desatualizada ou incorreto com o que foi digitado.
        $nascimento = new DateTime($data_nascimento);
        $hoje = new DateTime();
        $idade = $hoje->diff($nascimento)->y;

        $data_nascimento_sql = "'" . mysqli_real_escape_string($conexao, $data_nascimento) . "'";
        $data_inicio_sql = ($data_inicio_mandato !== "") ? "'" . mysqli_real_escape_string($conexao, $data_inicio_mandato) . "'" : "NULL";
        $data_fim_sql = ($data_fim_mandato !== "") ? "'" . mysqli_real_escape_string($conexao, $data_fim_mandato) . "'" : "NULL";

        if ($id_post) {
            $sql = "UPDATE governantes SET
                        nome = '$nome',
                        partido_politico = '$partido_politico',
                        data_nascimento = $data_nascimento_sql,
                        idade = $idade,
                        data_inicio_mandato = $data_inicio_sql,
                        data_fim_mandato = $data_fim_sql
                    WHERE id = $id_post";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado) {
                header("Location: governantes_listar.php?sucesso=" . urlencode("Governante atualizado com sucesso!"));
                exit;
            } else {
                $erro = "Erro ao atualizar: " . mysqli_error($conexao);
            }
        } else {
            $sql = "INSERT INTO governantes (nome, partido_politico, data_nascimento, idade, data_inicio_mandato, data_fim_mandato)
                    VALUES ('$nome', '$partido_politico', $data_nascimento_sql, $idade, $data_inicio_sql, $data_fim_sql)";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado) {
                header("Location: governantes_listar.php?sucesso=" . urlencode("Governante cadastrado com sucesso!"));
                exit;
            } else {
                $erro = "Erro ao cadastrar: " . mysqli_error($conexao);
            }
        }

        $governante = $_POST;
        $modo_edicao = (bool) $id_post;
    }
}

$titulo_pagina = $modo_edicao ? "Editar Governante" : "Novo Governante";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <h1><?php echo $titulo_pagina; ?></h1>

    <?php if ($erro): ?>
        <p class="mensagem mensagem-erro"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <form method="POST" class="formulario" onsubmit="return validarFormulario(this);">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($governante["id"]); ?>">

        <label for="nome">Nome *</label>
        <input type="text" id="nome" name="nome" required value="<?php echo htmlspecialchars($governante["nome"]); ?>">

        <label for="partido_politico">Partido político</label>
        <input type="text" id="partido_politico" name="partido_politico" value="<?php echo htmlspecialchars($governante["partido_politico"] ?? ""); ?>">

        <label for="data_nascimento">Data de nascimento *</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required
               value="<?php echo htmlspecialchars($governante["data_nascimento"]); ?>"
               onchange="calcularIdadePreview()">
        <p class="ajuda" id="preview-idade"></p>

        <label for="data_inicio_mandato">Início do mandato</label>
        <input type="date" id="data_inicio_mandato" name="data_inicio_mandato" value="<?php echo htmlspecialchars($governante["data_inicio_mandato"] ?? ""); ?>">

        <label for="data_fim_mandato">Fim do mandato (deixe em branco se ainda estiver no cargo)</label>
        <input type="date" id="data_fim_mandato" name="data_fim_mandato" value="<?php echo htmlspecialchars($governante["data_fim_mandato"] ?? ""); ?>">

        <div class="acoes-formulario">
            <button type="submit" class="botao botao-criar">Salvar</button>
            <a href="governantes_listar.php" class="botao botao-cancelar">Cancelar</a>
        </div>
    </form>
</div>

<script>calcularIdadePreview();</script>

<?php require_once "includes/rodape.php"; ?>
