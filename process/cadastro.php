<?php
session_start();
require_once '../includes/conexao.php';

// so aceita post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../cadastro.php');
    exit;
}

$erros = [];

$nome     = trim($_POST['nome'] ?? '');
$email    = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$senha    = $_POST['senha'] ?? '';
$confirma = $_POST['confirma'] ?? '';

// validacao dos campos
if (empty($nome))
    $erros[] = 'Nome é obrigatório.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
    $erros[] = 'E-mail inválido.';
if (!empty($telefone) && !preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $telefone))
    $erros[] = 'Telefone inválido.';
if (empty($senha) || strlen($senha) < 6)
    $erros[] = 'Senha deve ter pelo menos 6 caracteres.';
if ($senha !== $confirma)
    $erros[] = 'As senhas não coincidem.';

// verifica se email ja existe
if (empty($erros)) {
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch())
        $erros[] = 'Este e-mail já está cadastrado.';
}

// volta com erros se tiver
if (!empty($erros)) {
    $_SESSION['cadastro_erros'] = $erros;
    $_SESSION['cadastro_dados'] = [
        'nome' => $nome, 'email' => $email, 'telefone' => $telefone
    ];
    header('Location: ../cadastro.php');
    exit;
}

// hash da senha e insere no banco
$hash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, telefone, senha) VALUES (?, ?, ?, ?)");
$stmt->execute([$nome, $email, $telefone, $hash]);

$id = $pdo->lastInsertId();

// ja loga automaticamente
$_SESSION['usuario_id']   = $id;
$_SESSION['usuario_nome'] = $nome;
$_SESSION['usuario_tipo'] = 'cliente';

header('Location: ../pedidos.php');
exit;
