<?php
require_once "config/conexao.php";

$id = intval($_GET["id"]);

//Com o ON DELETE SET NULL" definido no banco, se este governante
// estiver associado a um país ou cidade, ela é automaticamente removida (fica NULL) sem apagar o país/cidade.
$resultado = mysqli_query($conexao, "DELETE FROM governantes WHERE id = $id");

if ($resultado) {
    header("Location: governantes_listar.php?sucesso=" . urlencode("Governante excluído com sucesso!"));
} else {
    header("Location: governantes_listar.php?erro=" . urlencode("Erro ao excluir: " . mysqli_error($conexao)));
}
exit;
