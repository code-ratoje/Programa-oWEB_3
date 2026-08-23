<?php
require_once "config/conexao.php";

$id = intval($_GET["id"]);

// Cidade não tem "filhos" no banco, então a exclusão é direta.
$resultado = mysqli_query($conexao, "DELETE FROM cidades WHERE id = $id");

if ($resultado) {
    header("Location: cidades_listar.php?sucesso=" . urlencode("Cidade excluída com sucesso!"));
} else {
    header("Location: cidades_listar.php?erro=" . urlencode("Erro ao excluir: " . mysqli_error($conexao)));
}
exit;
