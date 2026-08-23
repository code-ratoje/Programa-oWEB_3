<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo_pagina) ? htmlspecialchars($titulo_pagina) . " - CRUD Mundo" : "CRUD Mundo"; ?></title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

    <header class="cabecalho-site">
        <div class="cabecalho-conteudo">
            <a href="index.php" class="logo">🌍 CRUD Mundo</a>
            <nav class="menu-principal">
                <a href="continentes_listar.php">Continentes</a>
                <a href="paises_listar.php">Países</a>
                <a href="cidades_listar.php">Cidades</a>
                <a href="governantes_listar.php">Governantes</a>
                <a href="estatisticas.php">Estatísticas</a>
            </nav>
        </div>
    </header>

    <main>
