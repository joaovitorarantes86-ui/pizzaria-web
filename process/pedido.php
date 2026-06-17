<?php
session_start();
require_once '../includes/conexao.php';

// so aceita post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pedidos.php');
    exit;
}

$erros = [];

$nome      = trim($_POST['nome'] ?? '');
$telefone  = trim($_POST['telefone'] ?? '');
$pizza     = trim($_POST['pizza'] ?? '');
$tamanho   = trim($_POST['tamanho'] ?? '');
$endereco  = trim($_POST['endereco'] ?? '');
$cep       = trim($_POST['cep'] ?? '');
$pagamento = trim($_POST['pagamento'] ?? '');
$obs       = trim($_POST['obs'] ?? '');

// validacao
if (empty($nome))
    $erros[] = 'Nome é obrigatório.';
if (empty($telefone) || !preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $telefone))
    $erros[] = 'Telefone inválido.';
if (empty($pizza))
    $erros[] = 'Selecione o sabor da pizza.';
if (empty($tamanho))
    $erros[] = 'Selecione o tamanho.';
if (empty($endereco))
    $erros[] = 'Endereço é obrigatório.';
if (empty($cep) || !preg_match('/^\d{5}-?\d{3}$/', $cep))
    $erros[] = 'CEP inválido.';
if (empty($pagamento))
    $erros[] = 'Selecione a forma de pagamento.';

if (!empty($erros)) {
    $_SESSION['pedido_erros'] = $erros;
    $_SESSION['pedido_dados'] = [
        'nome' => $nome, 'telefone' => $telefone, 'pizza' => $pizza,
        'tamanho' => $tamanho, 'endereco' => $endereco, 'cep' => $cep,
        'pagamento' => $pagamento, 'obs' => $obs
    ];
    $pizza_label = '';
    header('Location: ../pedidos.php');
    exit;
}

// pega preco do banco pelo id
$pizza_id = (int) $pizza;
$stmt = $pdo->prepare("SELECT nome, preco FROM cardapio WHERE id = ?");
$stmt->execute([$pizza_id]);
$row = $stmt->fetch();
$total = $row ? (float) $row['preco'] : 0;
$pizza_label = $row ? $row['nome'] . ' - R$ ' . number_format($total, 2, ',', '.') : 'Desconhecida';

$usuario_id = $_SESSION['usuario_id'] ?? null;

// insere pedido no banco
$stmt = $pdo->prepare("
    INSERT INTO pedidos (usuario_id, nome_cliente, telefone, pizza, tamanho, endereco, cep, pagamento, observacoes, total)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->execute([$usuario_id, $nome, $telefone, $pizza_label, $tamanho, $endereco, $cep, $pagamento, $obs, $total]);

$_SESSION['pedido_sucesso'] = "Pedido de <strong>" . htmlspecialchars($pizza_label) . " ($tamanho)</strong> recebido! Em breve entraremos em contato no número $telefone.";
$_SESSION['pedido_dados']   = [];

header('Location: ../pedidos.php');
exit;
