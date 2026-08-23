<?php
require_once "config/conexao.php";

$id = intval($_GET["id"]);

// Não deixa excluir um país que ainda tenha cidades vinculadas
$verificacao = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM cidades WHERE pais_id = $id");
$linha = mysqli_fetch_assoc($verificacao);

if ($linha["total"] > 0) {
    $mensagem = "Não é possível excluir: existem {$linha['total']} cidade(s) cadastradas para este país. Exclua-as (ou mude o país delas) antes de excluir o país.";
    header("Location: paises_listar.php?erro=" . urlencode($mensagem));
    exit;
}

// Guarda o continente antes de excluir, para atualizar o contador depois
$paisResultado = mysqli_query($conexao, "SELECT continente_id FROM paises WHERE id = $id");
$paisEncontrado = mysqli_fetch_assoc($paisResultado);

$resultado = mysqli_query($conexao, "DELETE FROM paises WHERE id = $id");

if ($resultado) {
    if ($paisEncontrado) {
        mysqli_query($conexao, "UPDATE continentes SET total_paises = total_paises - 1 WHERE id = {$paisEncontrado['continente_id']}");
    }
    header("Location: paises_listar.php?sucesso=" . urlencode("País excluído com sucesso!"));
} else {
    header("Location: paises_listar.php?erro=" . urlencode("Erro ao excluir: " . mysqli_error($conexao)));
}
exit;
