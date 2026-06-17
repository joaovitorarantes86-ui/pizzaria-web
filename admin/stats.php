<?php
session_start();
require_once '../includes/conexao.php';

// so admin pode acessar
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    http_response_code(403);
    exit;
}

header('Content-Type: application/json');

// busca stats do banco
$pedidos_hoje    = (int) $pdo->query("SELECT COUNT(*) FROM pedidos WHERE DATE(criado_em) = CURDATE()")->fetchColumn();
$faturado_hoje   = (float) $pdo->query("SELECT COALESCE(SUM(total),0) FROM pedidos WHERE DATE(criado_em) = CURDATE()")->fetchColumn();
$pedidos_total   = (int) $pdo->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
$faturado_total  = (float) $pdo->query("SELECT COALESCE(SUM(total),0) FROM pedidos")->fetchColumn();
$total_clientes  = (int) $pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo = 'cliente'")->fetchColumn();
$pizzas_cardapio = (int) $pdo->query("SELECT COUNT(*) FROM cardapio WHERE ativo = 1")->fetchColumn();
$msgs_nao_lidas  = (int) $pdo->query("SELECT COUNT(*) FROM mensagens WHERE lida = 0")->fetchColumn();

// conta por status
$status_counts = $pdo->query("SELECT status, COUNT(*) as total FROM pedidos GROUP BY status")->fetchAll();
$pendentes = 0; $confirmados = 0; $entregues = 0; $cancelados = 0;
foreach ($status_counts as $s) {
    if ($s['status'] === 'pendente') $pendentes = (int) $s['total'];
    if ($s['status'] === 'confirmado') $confirmados = (int) $s['total'];
    if ($s['status'] === 'entregue') $entregues = (int) $s['total'];
    if ($s['status'] === 'cancelado') $cancelados = (int) $s['total'];
}

// pizza mais pedida
$pizza_top = $pdo->query("SELECT pizza, COUNT(*) as total FROM pedidos GROUP BY pizza ORDER BY total DESC LIMIT 1")->fetch();

echo json_encode([
    'pedidos_hoje'    => $pedidos_hoje,
    'faturado_hoje'   => number_format($faturado_hoje, 2, ',', '.'),
    'pedidos_total'   => $pedidos_total,
    'faturado_total'  => number_format($faturado_total, 2, ',', '.'),
    'total_clientes'  => $total_clientes,
    'pizzas_cardapio' => $pizzas_cardapio,
    'msgs_nao_lidas'  => $msgs_nao_lidas,
    'pendentes'       => $pendentes,
    'confirmados'     => $confirmados,
    'entregues'       => $entregues,
    'cancelados'      => $cancelados,
    'pizza_top_nome'  => $pizza_top ? htmlspecialchars($pizza_top['pizza']) : null,
    'pizza_top_qtd'   => $pizza_top ? (int) $pizza_top['total'] : 0,
]);
