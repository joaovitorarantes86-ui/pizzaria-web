<?php
// inicia sessao se ainda nao foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// dados do usuario logado
$logado = isset($_SESSION['usuario_tipo']);
$nome   = $_SESSION['usuario_nome'] ?? '';
$tipo   = $_SESSION['usuario_tipo'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title><?= isset($titulo) ? $titulo . ' - Arantes Pizzaria' : 'Arantes Pizzaria' ?></title>
</head>
<body class="dark-mode">

<!-- topo / cabecalho -->
<div class="topo">
    <div class="container">
        <nav>
            <!-- logo -->
            <div class="logo">
                <a href="index.php">Arantes <span>Pizzaria</span></a>
            </div>
            <!-- menu de navegacao -->
            <ul id="menu">
                <li><a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="ativo"' : '' ?>>Início</a></li>
                <li><a href="sobre.php" <?= basename($_SERVER['PHP_SELF']) == 'sobre.php' ? 'class="ativo"' : '' ?>>Sobre</a></li>
                <li><a href="cardapio.php" <?= basename($_SERVER['PHP_SELF']) == 'cardapio.php' ? 'class="ativo"' : '' ?>>Cardápio</a></li>
                <li><a href="pedidos.php" <?= basename($_SERVER['PHP_SELF']) == 'pedidos.php' ? 'class="ativo"' : '' ?>>Pedidos</a></li>
                <?php if ($logado): ?>
                    <!-- usuario logado -->
                    <li><span style="color:#ccc; font-size:0.85rem; margin-right:5px;"><?= htmlspecialchars($nome) ?></span></li>
                    <li>
                        <?php if ($tipo === 'admin'): ?>
                            <!-- link painel admin -->
                            <a href="admin/index.php"><button class="btn btn-laranja">Painel</button></a>
                        <?php endif; ?>
                        <a href="process/logout.php"><button class="btn btn-vermelho">Sair</button></a>
                    </li>
                <?php else: ?>
                    <!-- nao logado -> mostra botao entrar -->
                    <li><a href="login.php"><button class="btn btn-laranja">Entrar</button></a></li>
                <?php endif; ?>
            </ul>
            <!-- icone menu sanduiche (mobile) -->
            <div class="menu-icon" onclick="toggleMenu()">
                <img src="IMG/menu.png" id="menu-img" alt="Menu">
            </div>
        </nav>
    </div>
</div>