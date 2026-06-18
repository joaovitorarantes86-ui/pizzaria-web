<?php
session_start();
require_once '../includes/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Excluir endereço
if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];
    $stmt = $pdo->prepare("DELETE FROM enderecos WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $usuario_id]);
    $_SESSION['endereco_msg'] = 'Endereço excluído.';
    header('Location: ../enderecos.php');
    exit;
}

// Salvar endereço
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rua         = trim($_POST['rua'] ?? '');
    $numero      = trim($_POST['numero'] ?? '');
    $bairro      = trim($_POST['bairro'] ?? '');
    $cidade      = trim($_POST['cidade'] ?? '');
    $cep         = trim($_POST['cep'] ?? '');
    $complemento = trim($_POST['complemento'] ?? '');

    if (empty($rua) || empty($numero) || empty($bairro) || empty($cidade) || empty($cep)) {
        $_SESSION['endereco_erro'] = 'Preencha todos os campos obrigatórios.';
        header('Location: ../enderecos.php');
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO enderecos (usuario_id, rua, numero, bairro, cidade, cep, complemento) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$usuario_id, $rua, $numero, $bairro, $cidade, $cep, $complemento]);

    $_SESSION['endereco_msg'] = 'Endereço salvo com sucesso!';
    header('Location: ../enderecos.php');
    exit;
}

header('Location: ../enderecos.php');
exit;
