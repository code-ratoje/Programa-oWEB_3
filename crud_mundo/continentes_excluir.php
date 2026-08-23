<?php
require_once "config/conexao.php";

$id = intval($_GET["id"]);

// Integridade referencial: não deixa excluir um continente que ainda tenha países cadastrados 
$verificacao = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM paises WHERE continente_id = $id");
$linha = mysqli_fetch_assoc($verificacao);

if ($linha["total"] > 0) {
    $mensagem = "Não é possível excluir: existem {$linha['total']} país(es) cadastrados neste continente. Exclua-os (ou mude o continente deles) antes de excluir o continente.";
    header("Location: continentes_listar.php?erro=" . urlencode($mensagem));
    exit;
}

$resultado = mysqli_query($conexao, "DELETE FROM continentes WHERE id = $id");

if ($resultado) {
    header("Location: continentes_listar.php?sucesso=" . urlencode("Continente excluído com sucesso!"));
} else {
    header("Location: continentes_listar.php?erro=" . urlencode("Erro ao excluir: " . mysqli_error($conexao)));
}
exit;
