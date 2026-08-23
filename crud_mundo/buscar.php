<?php
require_once "config/conexao.php";
header("Content-Type: application/json; charset=utf-8");

$tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : "";
$termo = isset($_GET["termo"]) ? mysqli_real_escape_string($conexao, $_GET["termo"]) : "";

$resultados = [];

if ($tipo === "paises") {
    $sql = "SELECT p.id, p.nome, p.populacao, c.nome AS continente_nome, g.nome AS governante_nome
            FROM paises p
            INNER JOIN continentes c ON p.continente_id = c.id
            LEFT JOIN governantes g ON p.governante_id = g.id
            WHERE p.nome LIKE '%$termo%'
            ORDER BY p.nome";
    $consulta = mysqli_query($conexao, $sql);
    while ($linha = mysqli_fetch_assoc($consulta)) {
        $resultados[] = $linha;
    }
} elseif ($tipo === "cidades") {
    $sql = "SELECT ci.id, ci.nome, ci.populacao, p.nome AS pais_nome, g.nome AS governante_nome
            FROM cidades ci
            INNER JOIN paises p ON ci.pais_id = p.id
            LEFT JOIN governantes g ON ci.governante_id = g.id
            WHERE ci.nome LIKE '%$termo%'
            ORDER BY ci.nome";
    $consulta = mysqli_query($conexao, $sql);
    while ($linha = mysqli_fetch_assoc($consulta)) {
        $resultados[] = $linha;
    }
}

echo json_encode($resultados);
