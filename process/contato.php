<?php
session_start();
require_once '../includes/conexao.php';

// so aceita post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../contato.php');
    exit;
}

$erros = [];

$nome     = trim($_POST['nome'] ?? '');
$email    = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$assunto  = trim($_POST['assunto'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

// validacao
if (empty($nome))
    $erros[] = 'Nome é obrigatório.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
    $erros[] = 'E-mail inválido.';
if (!empty($telefone) && !preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $telefone))
    $erros[] = 'Telefone inválido.';
if (empty($assunto))
    $erros[] = 'Selecione o assunto.';
if (empty($mensagem) || strlen($mensagem) < 10)
    $erros[] = 'Mensagem muito curta (mínimo 10 caracteres).';

if (!empty($erros)) {
    $_SESSION['contato_erros'] = $erros;
    $_SESSION['contato_dados'] = [
        'nome' => $nome, 'email' => $email, 'telefone' => $telefone,
        'assunto' => $assunto, 'mensagem' => $mensagem
    ];
    header('Location: ../contato.php');
    exit;
}

// salva no banco
$stmt = $pdo->prepare("
    INSERT INTO mensagens (nome, email, telefone, assunto, mensagem)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->execute([$nome, $email, $telefone, $assunto, $mensagem]);

$_SESSION['contato_sucesso'] = 'Mensagem enviada! Nossa equipe responde em até 24h.';
$_SESSION['contato_dados']   = [];

header('Location: ../contato.php');
exit;
