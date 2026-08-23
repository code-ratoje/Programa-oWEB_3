<?php
require_once "config/conexao.php";

$totalContinentes = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT COUNT(*) AS total FROM continentes"))["total"];
$totalPaises = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT COUNT(*) AS total FROM paises"))["total"];
$totalCidades = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT COUNT(*) AS total FROM cidades"))["total"];
$totalGovernantes = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT COUNT(*) AS total FROM governantes"))["total"];

$titulo_pagina = "Início";
require_once "includes/cabecalho.php";
?>

<div class="container">
    <h1>CRUD Mundo</h1>
    <p>Sistema de gerenciamento de continentes, países, cidades e governantes do mundo.</p>

    <div class="cartoes-resumo">
        <a href="continentes_listar.php" class="cartao">
            <span class="cartao-numero"><?php echo $totalContinentes; ?></span>
            <span>Continentes</span>
        </a>
        <a href="paises_listar.php" class="cartao">
            <span class="cartao-numero"><?php echo $totalPaises; ?></span>
            <span>Países</span>
        </a>
        <a href="cidades_listar.php" class="cartao">
            <span class="cartao-numero"><?php echo $totalCidades; ?></span>
            <span>Cidades</span>
        </a>
        <a href="governantes_listar.php" class="cartao">
            <span class="cartao-numero"><?php echo $totalGovernantes; ?></span>
            <span>Governantes</span>
        </a>
    </div>

    <p><a href="estatisticas.php">📊 Ver estatísticas do sistema →</a></p>
</div>

<?php require_once "includes/rodape.php"; ?>
