<?php
session_start();
require_once '../includes/conexao.php';

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_POST['alterar_status'])) {
    $id_pedido = (int) $_POST['id_pedido'];
    $novo_status = $_POST['novo_status'];
    $status_validos = ['pendente', 'confirmado', 'entregue', 'cancelado'];
    if (in_array($novo_status, $status_validos)) {
        $stmt = $pdo->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
        $stmt->execute([$novo_status, $id_pedido]);
    }
    header('Location: index.php');
    exit;
}

if (isset($_GET['marcar_lida'])) {
    $id_msg = (int) $_GET['marcar_lida'];
    $pdo->prepare("UPDATE mensagens SET lida = 1 WHERE id = ?")->execute([$id_msg]);
    header('Location: index.php');
    exit;
}

$nome = $_SESSION['usuario_nome'];

$pedidos_hoje    = $pdo->query("SELECT COUNT(*) FROM pedidos WHERE DATE(criado_em) = CURDATE()")->fetchColumn();
$faturado_hoje   = $pdo->query("SELECT COALESCE(SUM(total),0) FROM pedidos WHERE DATE(criado_em) = CURDATE()")->fetchColumn();
$pedidos_total   = $pdo->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
$faturado_total  = $pdo->query("SELECT COALESCE(SUM(total),0) FROM pedidos")->fetchColumn();
$total_clientes  = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo = 'cliente'")->fetchColumn();
$pizzas_cardapio = $pdo->query("SELECT COUNT(*) FROM cardapio WHERE ativo = 1")->fetchColumn();
$msgs_nao_lidas  = $pdo->query("SELECT COUNT(*) FROM mensagens WHERE lida = 0")->fetchColumn();

$status_counts = $pdo->query("SELECT status, COUNT(*) as total FROM pedidos GROUP BY status")->fetchAll();
$pendentes = 0; $confirmados = 0; $entregues = 0; $cancelados = 0;
foreach ($status_counts as $s) {
    if ($s['status'] === 'pendente') $pendentes = $s['total'];
    if ($s['status'] === 'confirmado') $confirmados = $s['total'];
    if ($s['status'] === 'entregue') $entregues = $s['total'];
    if ($s['status'] === 'cancelado') $cancelados = $s['total'];
}

$pizza_top = $pdo->query("SELECT pizza, COUNT(*) as total FROM pedidos GROUP BY pizza ORDER BY total DESC LIMIT 1")->fetch();

$pedidos   = $pdo->query("SELECT * FROM pedidos ORDER BY criado_em DESC LIMIT 20")->fetchAll();
$mensagens = $pdo->query("SELECT * FROM mensagens ORDER BY criado_em DESC LIMIT 20")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/estilo.css">
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Admin - Painel</title>
</head>
<body>

<div class="admin-page">

    <aside class="admin-sidebar">
        <div class="logo-text">
            Pizzaria da <span>Suzy</span>
            <small>Painel Admin</small>
        </div>
        <button class="menu-toggle" id="adminMenuToggle" aria-label="Abrir menu" style="margin:0 12px 16px; display:none;">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="sidebar-nav" id="sidebarNav">
            <a href="index.php" class="ativo">&#9679; Dashboard</a>
            <a href="cardapio.php">&#9679; Cardápio</a>
            <a href="../index.php">&#9679; Ver site</a>
        </nav>
        <div class="sidebar-footer">
            <span style="color:rgba(255,255,255,0.3);font-size:0.8rem;">Olá, <?= htmlspecialchars($nome) ?></span>
            <a href="logout.php">Sair</a>
        </div>
    </aside>

    <main class="admin-main">

        <div class="admin-topbar">
            <h1>Dashboard</h1>
            <span class="user-greeting">Bem-vindo, <?= htmlspecialchars($nome) ?></span>
        </div>

        <div class="stats-grid">
            <div class="stat-item s-gold">
                <div class="stat-val"><?= $pedidos_hoje ?></div>
                <div class="stat-label">Pedidos hoje</div>
            </div>
            <div class="stat-item s-green">
                <div class="stat-val small">R$ <?= number_format($faturado_hoje, 2, ',', '.') ?></div>
                <div class="stat-label">Faturamento hoje</div>
            </div>
            <div class="stat-item s-blue">
                <div class="stat-val"><?= $pedidos_total ?></div>
                <div class="stat-label">Total de Pedidos</div>
            </div>
            <div class="stat-item s-purple">
                <div class="stat-val small">R$ <?= number_format($faturado_total, 2, ',', '.') ?></div>
                <div class="stat-label">Faturamento Total</div>
            </div>
            <div class="stat-item s-teal">
                <div class="stat-val"><?= $total_clientes ?></div>
                <div class="stat-label">Clientes</div>
            </div>
            <div class="stat-item s-amber">
                <div class="stat-val"><?= $pizzas_cardapio ?></div>
                <div class="stat-label">Pizzas no Cardápio</div>
            </div>
            <div class="stat-item s-red">
                <div class="stat-val"><?= $msgs_nao_lidas ?></div>
                <div class="stat-label">Mensagens não lidas</div>
            </div>
        </div>

        <div class="status-grid">
            <div class="status-item s-pendente">
                <div class="s-num"><?= $pendentes ?></div>
                <div class="s-label">Pendentes</div>
                <?php $total_pedidos = $pendentes + $confirmados + $entregues + $cancelados; $pct = $total_pedidos > 0 ? round(($pendentes / $total_pedidos) * 100) : 0; ?>
                <div class="s-bar"><div class="s-bar-inner" style="width:<?= $pct ?>%"></div></div>
            </div>
            <div class="status-item s-confirmado">
                <div class="s-num"><?= $confirmados ?></div>
                <div class="s-label">Confirmados</div>
                <?php $pct = $total_pedidos > 0 ? round(($confirmados / $total_pedidos) * 100) : 0; ?>
                <div class="s-bar"><div class="s-bar-inner" style="width:<?= $pct ?>%"></div></div>
            </div>
            <div class="status-item s-entregue">
                <div class="s-num"><?= $entregues ?></div>
                <div class="s-label">Entregues</div>
                <?php $pct = $total_pedidos > 0 ? round(($entregues / $total_pedidos) * 100) : 0; ?>
                <div class="s-bar"><div class="s-bar-inner" style="width:<?= $pct ?>%"></div></div>
            </div>
            <div class="status-item s-cancelado">
                <div class="s-num"><?= $cancelados ?></div>
                <div class="s-label">Cancelados</div>
                <?php $pct = $total_pedidos > 0 ? round(($cancelados / $total_pedidos) * 100) : 0; ?>
                <div class="s-bar"><div class="s-bar-inner" style="width:<?= $pct ?>%"></div></div>
            </div>
            <?php if ($pizza_top): ?>
            <div class="status-item s-top">
                <div class="s-num"><?= htmlspecialchars($pizza_top['pizza']) ?></div>
                <div class="s-label"><?= $pizza_top['total'] ?> pedidos &middot; Mais pedida</div>
                <div class="s-bar"><div class="s-bar-inner" style="width:100%"></div></div>
            </div>
            <?php endif; ?>
        </div>

        <div class="table-wrap">
            <h3>Pedidos Recentes</h3>
            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Pizza</th>
                        <th>Tamanho</th>
                        <th>Pagamento</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pedidos)): ?>
                        <tr><td colspan="8" style="text-align:center; color:var(--text-light);">Nenhum pedido ainda.</td></tr>
                    <?php else: ?>
                        <?php foreach ($pedidos as $p): ?>
                        <tr>
                            <td>#<?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['nome_cliente']) ?></td>
                            <td><?= htmlspecialchars($p['pizza']) ?></td>
                            <td><?= htmlspecialchars($p['tamanho']) ?></td>
                            <td><?= htmlspecialchars($p['pagamento']) ?></td>
                            <td><strong>R$ <?= number_format($p['total'], 2, ',', '.') ?></strong></td>
                            <td>
                                <span class="badge badge-<?= htmlspecialchars($p['status']) ?>"><?= ucfirst(htmlspecialchars($p['status'])) ?></span>
                                <form method="POST" style="display:inline; margin-left:6px;">
                                    <input type="hidden" name="id_pedido" value="<?= $p['id'] ?>">
                                    <select name="novo_status" onchange="this.form.submit()" style="font-size:11px; padding:2px 4px; border:1px solid #d6d3ce; border-radius:4px;">
                                        <option value="">Alterar</option>
                                        <option value="pendente">Pendente</option>
                                        <option value="confirmado">Confirmado</option>
                                        <option value="entregue">Entregue</option>
                                        <option value="cancelado">Cancelado</option>
                                    </select>
                                    <input type="hidden" name="alterar_status" value="1">
                                </form>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($p['criado_em'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>

        <div class="table-wrap">
            <h3>Mensagens de Contato</h3>
            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Assunto</th>
                        <th>Mensagem</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mensagens)): ?>
                        <tr><td colspan="7" style="text-align:center; color:var(--text-light);">Nenhuma mensagem ainda.</td></tr>
                    <?php else: ?>
                        <?php foreach ($mensagens as $m): ?>
                        <tr style="<?= !$m['lida'] ? 'font-weight:600; background:#FFFBEB;' : '' ?>">
                            <td>#<?= $m['id'] ?></td>
                            <td><?= htmlspecialchars($m['nome']) ?></td>
                            <td><?= htmlspecialchars($m['email']) ?></td>
                            <td><?= htmlspecialchars($m['assunto']) ?></td>
                            <td><?= htmlspecialchars(substr($m['mensagem'], 0, 60)) ?>...</td>
                            <td><?= date('d/m/Y H:i', strtotime($m['criado_em'])) ?></td>
                            <td>
                                <?php if (!$m['lida']): ?>
                                    <a href="?marcar_lida=<?= $m['id'] ?>" class="btn btn-sm btn-success">Marcar lida</a>
                                <?php else: ?>
                                    <span style="color:var(--text-light); font-size:0.82rem;">Lida</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>

    </main>
</div>

<script src="../JS/script.js"></script>
<script>
setInterval(function() {
    fetch('stats.php')
        .then(function(r) { return r.json(); })
        .then(function(d) {
            var cards = document.querySelectorAll('.stat-item .stat-val');
            if (cards.length >= 7) {
                cards[0].textContent = d.pedidos_hoje;
                cards[1].textContent = 'R$ ' + d.faturado_hoje;
                cards[2].textContent = d.pedidos_total;
                cards[3].textContent = 'R$ ' + d.faturado_total;
                cards[4].textContent = d.total_clientes;
                cards[5].textContent = d.pizzas_cardapio;
                cards[6].textContent = d.msgs_nao_lidas;
            }
            var sDivs = document.querySelectorAll('.status-item .s-num');
            if (sDivs.length >= 4) {
                sDivs[0].textContent = d.pendentes;
                sDivs[1].textContent = d.confirmados;
                sDivs[2].textContent = d.entregues;
                sDivs[3].textContent = d.cancelados;
            }
            if (d.pizza_top_nome && sDivs.length >= 5) {
                var topDiv = document.querySelector('.status-item.s-top .s-num');
                if (topDiv) topDiv.textContent = d.pizza_top_nome;
                var topLabel = document.querySelector('.status-item.s-top .s-label');
                if (topLabel) topLabel.textContent = d.pizza_top_qtd + ' pedidos';
            }
        })
        .catch(function(e) {});
}, 15000);
</script>
</body>
</html>
