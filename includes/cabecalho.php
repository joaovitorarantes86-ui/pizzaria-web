<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$logado = isset($_SESSION['usuario_tipo']);
$nome   = $_SESSION['usuario_nome'] ?? '';
$tipo   = $_SESSION['usuario_tipo'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilo.css">
    <title><?= isset($titulo) ? $titulo . ' - Pizzaria da Suzy' : 'Pizzaria da Suzy' ?></title>
</head>
<body>

<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <a href="index.php" class="logo-text">Arantes <span>Pizzaria</span></a>

            <div class="nav-wrapper" id="navWrapper">
                <ul class="nav-list">
                    <li><a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="ativo"' : '' ?>>Início</a></li>
                    <li><a href="sobre.php" <?= basename($_SERVER['PHP_SELF']) == 'sobre.php' ? 'class="ativo"' : '' ?>>Sobre</a></li>
                    <li><a href="cardapio.php" <?= basename($_SERVER['PHP_SELF']) == 'cardapio.php' ? 'class="ativo"' : '' ?>>Cardápio</a></li>
                    <li><a href="pedidos.php" <?= basename($_SERVER['PHP_SELF']) == 'pedidos.php' ? 'class="ativo"' : '' ?>>Pedidos</a></li>
                    <li><a href="contato.php" <?= basename($_SERVER['PHP_SELF']) == 'contato.php' ? 'class="ativo"' : '' ?>>Contato</a></li>
                    <?php if ($logado): ?>
                    <li><a href="enderecos.php" <?= basename($_SERVER['PHP_SELF']) == 'enderecos.php' ? 'class="ativo"' : '' ?>>Endereços</a></li>
                    <?php endif; ?>
                </ul>

                <div class="nav-action">
                    <?php if ($logado): ?>
                        <span class="nav-user"><?= htmlspecialchars($nome) ?></span>
                        <?php if ($tipo === 'admin'): ?>
                            <a href="admin/index.php"><button class="nav-btn nav-btn-painel">Painel</button></a>
                        <?php endif; ?>
                        <a href="process/logout.php"><button class="nav-btn nav-btn-sair">Sair</button></a>
                    <?php else: ?>
                        <a href="login.php"><button class="nav-btn nav-btn-entrar">Entrar</button></a>
                    <?php endif; ?>
                </div>
            </div>

            <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>
<main>
